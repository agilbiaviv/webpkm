<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\MenuController;
use App\Models\MenuModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];
    protected $footerData;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */

    protected $menus;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Ambil footer config
        $footerModel = new \App\Models\FooterConfigModel();
        $this->footerData = $footerModel->find(1);

        service('renderer')->setVar('footer', $this->footerData);


        // Ambil semua menu aktif urut posisi
        $menuModel = new MenuModel();
        $menus = $menuModel->db->table('menus')
            ->select('menus.*, parent.name as parent_name')
            ->join('menus as parent', 'parent.id = menus.parent_id', 'left')
            ->where('menus.status', 'active')
            ->orderBy('menus.position', 'ASC')
            ->get()
            ->getResultArray();

        // Bikin tree dari flat array
        $this->menus = $this->buildTree($menus);

        // Share $menus ke view
        service('renderer')->setVar('menus', $this->menus);

        if (env('app.maintenanceMode') === 'true' || env('app.maintenanceMode') === true) {
            echo view('frontend/maintenance');
            exit;
        }



        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }

    private function buildTree(array $elements, $parentId = null): array
    {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }
}
