<?php

namespace App\Controllers;

use App\Models\CommonModel;
use App\Models\PageModel;
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
class BaseController extends Controller
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
        $this->settingsModel = new SettingsModel();
        $this->commonModel = new CommonModel();
        $this->postModel = new PostModel();

        //general settings
        $this->generalSettings = Globals::$generalSettings;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            setActiveLangPostRequest();
        }

        //settings
        $this->settings = Globals::$settings;
        //active languages
        $this->activeLanguages = Globals::$languages;
        //active lang
        $this->activeLang = Globals::$activeLang;

        //maintenance mode
        if ($this->generalSettings->maintenance_mode_status == 1) {
            if (!isAdmin()) {
                echo view('common/maintenance', ['generalSettings' => $this->generalSettings, 'baseSettings' => $this->settings]);
            }
        }
        //site fonts
        $this->activeFonts = $this->settingsModel->getSelectedFonts($this->settings);

        //active theme
        $this->activeTheme = getActiveTheme();

        //rtl
        $this->rtl = false;
        if ($this->activeLang->text_direction == 'rtl') {
            $this->rtl = true;
        }
        $this->darkMode = 0;
        $mode = $this->generalSettings->theme_mode;
        if (!empty(helperGetCookie('theme_mode'))) {
            $mode = helperGetCookie('theme_mode');
        }
        if ($mode == 'dark') {
            $this->darkMode = 1;
        }

        //menu links
        $menuLinks = getCachedData('menu_links');
        if (empty($menuLinks)) {
            $pageModel = new PageModel();
            $menuLinks = $pageModel->getMenuLinks($this->activeLang->id);
            setCacheData('menu_links', $menuLinks);
        }
        //widgets
        $this->widgets = getCachedData('widgets');
        if (empty($this->widgets)) {
            $this->widgets = $this->settingsModel->getWidgetsByLang($this->activeLang->id);
            setCacheData('widgets', $this->widgets);
        }
        //categories
        $this->categories = getCachedData('categories');
        if (empty($this->categories)) {
            $this->categories = getCategoriesByLang($this->activeLang->id);
            setCacheData('categories', $this->categories);
        }
        //latest categories posts
        $this->latestCategoryPosts = getCachedData('latest_category_posts');
        if (empty($this->latestCategoryPosts)) {
            $this->latestCategoryPosts = $this->postModel->getLatestCategoryPosts($this->activeLang->id);
            setCacheData('latest_category_posts', $this->latestCategoryPosts);
        }

        //ad spaces
        $this->adSpaces = $this->commonModel->getAdSpacesByLang($this->activeLang->id);

        //update last seen
        updateLastSeen();

        //view variables
        $view = \Config\Services::renderer();
        $view->setData(['assetsPath' => 'assets/' . getThemePath(), 'activeTheme' => $this->activeTheme, 'activeLang' => $this->activeLang, 'generalSettings' => $this->generalSettings, 'baseSettings' => $this->settings, 'activeLanguages' => $this->activeLanguages, 'rtl' => $this->rtl,
            'darkMode' => $this->darkMode, 'activeFonts' => $this->activeFonts, 'baseMenuLinks' => $menuLinks, 'baseWidgets' => $this->widgets, 'baseCategories' => $this->categories, 'baseLatestCategoryPosts' => $this->latestCategoryPosts, 'adSpaces' => $this->adSpaces]);
    }
}
