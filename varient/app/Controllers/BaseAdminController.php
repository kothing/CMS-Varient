<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CommonModel;
use App\Models\PostModel;
use App\Models\SettingsModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Globals;
use Psr\Log\LoggerInterface;

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
class BaseAdminController extends Controller
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
     * @var array
     */
    protected $helpers = [
        'text', 'cookie', 'security'
    ];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();

        $this->generalSettings = Globals::$generalSettings;
        //settings
        $this->settings = Globals::$settings;
        //active languages
        $this->activeLanguages = Globals::$languages;

        //check auth
        if (!authCheck()) {
            redirectToUrl(adminUrl('login'));
            exit();
        }
        //maintenance mode
        if ($this->generalSettings->maintenance_mode_status == 1) {
            if (!isAdmin()) {
                $authModel = new AuthModel();
                $authModel->logout();
                redirectToUrl(adminUrl('login'));
                exit();
            }
        }

        //active theme
        $this->activeTheme = getActiveTheme();

        //set control panel lang
        if (!empty($this->session->get('vr_control_panel_lang'))) {
            Globals::setActiveLanguage($this->session->get('vr_control_panel_lang'));
        }
        //active lang
        $this->activeLang = Globals::$activeLang;
        //categories
        $this->categories = getCategories();
        //per page
        $this->perPage = 15;
        if (!empty(cleanNumber(inputGet('show')))) {
            $this->perPage = cleanNumber(inputGet('show'));
        }
        //update last seen
        updateLastSeen();

        //view variables
        $view = \Config\Services::renderer();
        $view->setData(['activeLang' => $this->activeLang, 'activeLanguages' => $this->activeLanguages, 'activeTheme' => $this->activeTheme, 'generalSettings' => $this->generalSettings, 'baseSettings' => $this->settings, 'baseCategories' => $this->categories]);
    }
}
