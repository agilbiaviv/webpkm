<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Berita\BeritaModel;

class Berita extends BaseController
{

    public function index()
    {
        $beritaModel = new BeritaModel();

        $keyword = $this->request->getGet('q');
        $month   = $this->request->getGet('month');
        $year    = $this->request->getGet('year');

        $query = $beritaModel->where('status', 1);

        if ($keyword) {
            $query->like('judul_berita', $keyword)
                ->orLike('deskripsi', $keyword);
        }

        if ($month) {
            $query->where('MONTH(tanggal_berita)', $month);
        }

        if ($year) {
            $query->where('YEAR(tanggal_berita)', $year);
        }

        $beritaList = $query->orderBy('tanggal_berita', 'DESC')->paginate(10);
        $pager = $beritaModel->pager;

        // Group by month and year
        $grouped = [];
        foreach ($beritaList as $item) {
            $groupKey = date('F Y', strtotime($item['tanggal_berita']));
            $grouped[$groupKey][] = $item;
        }

        return view('frontend/berita', [
            'beritaGrouped' => $grouped,
            'pager' => $pager,
            'keyword' => $keyword,
            'selectedMonth' => $month,
            'selectedYear' => $year
        ]);
    }

    public function detail($slug)
    {

        $beritaModel = new BeritaModel();

        $berita = $beritaModel->where('slug', $slug)->where('status', 1)->first();

        if (!$berita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Berita tidak ditemukan");
        }
        // Update view count
        $beritaModel->update($berita['id'], ['view_count' => $berita['view_count'] + 1]);

        // Get recommended news (same category, exclude current news)
        $recommended = $beritaModel
            ->where('kategori_id', $berita['kategori_id'])
            ->where('id !=', $berita['id'])
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->find();

        return view('frontend/berita_detail', [
            'title' => $berita['judul_berita'],
            'berita' => $berita,
            'recommended' => $recommended
        ]);
    }

    public function loadMore()
    {
        $beritaModel = new \App\Models\Berita\BeritaModel();

        // Validate & sanitize inputs
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 3;
        $offset = ($page - 1) * $perPage;

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $month = (int) ($this->request->getGet('month') ?? 0);
        $year = (int) ($this->request->getGet('year') ?? 0);

        // Ensure month and year are in valid range
        if ($month < 1 || $month > 12) {
            $month = null;
        }

        $currentYear = (int) date('Y');
        if ($year < 2000 || $year > $currentYear + 1) {
            $year = null;
        }

        // Build the query
        $query = $beritaModel->where('status', 1);

        if (!empty($search)) {
            $query->groupStart()
                ->like('judul_berita', $search)
                ->orLike('deskripsi', $search)
                ->groupEnd();
        }

        if (!empty($month)) {
            $query->where('MONTH(tanggal_berita)', $month);
        }

        if (!empty($year)) {
            $query->where('YEAR(tanggal_berita)', $year);
        }

        // Fetch 1 extra item to determine if there’s a next page
        $results = $query->orderBy('tanggal_berita', 'DESC')
            ->findAll($perPage + 1, $offset);

        $hasMore = count($results) > $perPage;
        $items = array_slice($results, 0, $perPage);

        // Group items by "Month Year" and render view
        $groupedHtml = [];

        $formatter = new \IntlDateFormatter(
            'id_ID',
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::NONE,
            'Asia/Jakarta',
            \IntlDateFormatter::GREGORIAN,
            'LLLL yyyy'
        );

        foreach ($items as $item) {
            $groupKey = $formatter->format(strtotime($item['tanggal_berita']));
            $groupedHtml[$groupKey][] = view('frontend/components/berita_card', ['item' => $item]);
        }

        return $this->response->setJSON([
            'success' => true,
            'groupedHtml' => $groupedHtml,
            'hasMore' => $hasMore,
        ]);
    }
}
