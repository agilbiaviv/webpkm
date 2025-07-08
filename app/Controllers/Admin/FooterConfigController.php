<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FooterConfigModel;

class FooterConfigController extends BaseController
{
    protected $footerConfig;

    public function __construct()
    {
        $this->footerConfig = new FooterConfigModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Konfigurasi Footer',
            'footer' => $this->footerConfig->find(1),
            'breadcrumbs' => [
                ['name' => 'Beranda', 'url' => 'admin/beranda'],
                ['name' => 'Konfigurasi Footer', 'active' => true]
            ]
        ];

        return view('admin/footer_config', $data);
    }

    public function update()
    {
        $rules = [
            'nama_instansi'   => 'required',
            'alamat'          => 'permit_empty',
            'telepon'         => 'permit_empty',
            'whatsapp'        => 'permit_empty',
            'email'           => 'permit_empty|valid_email',
            'facebook'        => 'permit_empty|valid_url',
            'instagram'       => 'permit_empty|valid_url',
            'tiktok'       => 'permit_empty|valid_url',
            'youtube'         => 'permit_empty|valid_url',
            'maps_embed_url'  => 'permit_empty',
        ];

        // Validasi gagal
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('error', 'Validasi gagal. Silakan periksa kembali input Anda.');
        }

        $data = $this->request->getPost();
        $data['id'] = 1; // kita pastikan selalu id 1

        try {
            $existing = $this->footerConfig->find(1);

            if ($existing) {
                if (!$this->footerConfig->update(1, $data)) {
                    throw new \Exception("Gagal memperbarui data.");
                }
            } else {
                if (!$this->footerConfig->insert($data)) {
                    throw new \Exception("Gagal menyimpan data.");
                }
            }

            return redirect()->back()->with('success', 'Konfigurasi footer berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }
}
