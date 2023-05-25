<?php

use \Config\Globals;

if (strpos($_SERVER['REQUEST_URI'], '/index.php') !== false) {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (!empty($url)) {
        $url = str_replace('/index.php', '', $url);
    }
    header('Location: ' . $url);
    exit();
}

//trimg string
if (!function_exists('strTrim')) {
    function strTrim($str)
    {
        if (!empty($str)) {
            return trim($str);
        }
    }
}

//str replace
if (!function_exists('strReplace')) {
    function strReplace($search, $replace, $str)
    {
        if (!empty($str)) {
            return str_replace($search, $replace, $str);
        }
    }
}

//character limiter
if (!function_exists('characterLimiter')) {
    function characterLimiter($str, $limit, $endChar = '')
    {
        if (!empty($str) && strlen($str) > $limit) {
            return mb_strimwidth($str, 0, $limit + 3, $endChar);
        }
        return $str;
    }
}

//get themes
if (!function_exists('getThemes')) {
    function getThemes()
    {
        return Globals::$themes;
    }
}

//get active theme
if (!function_exists('getActiveTheme')) {
    function getActiveTheme()
    {
        $theme = null;
        if (!empty(getThemes())) {
            foreach (getThemes() as $item) {
                if ($item->is_active == 1) {
                    $theme = $item;
                }
            }
            if (empty($theme)) {
                if (!empty(getThemes()[0])) {
                    $theme = getThemes()[0];
                }
            }
        }
        return $theme;
    }
}

//get theme path
if (!function_exists('getThemePath')) {
    function getThemePath()
    {
        $themePath = 'themes/classic';
        if (!empty(getActiveTheme())) {
            $themePath = 'themes/' . getActiveTheme()->theme_folder;
        }
        return $themePath;
    }
}

//load view
if (!function_exists('loadView')) {
    function loadView($view, $data = null)
    {
        if (!empty($data)) {
            return view(getThemePath() . '/' . $view, $data);
        } else {
            return view(getThemePath() . '/' . $view);
        }
    }
}

//language base URL
if (!function_exists('langBaseUrl')) {
    function langBaseUrl($route = null)
    {
        if (!empty($route)) {
            return Globals::$langBaseUrl . '/' . $route;
        }
        return Globals::$langBaseUrl;
    }
}

//generate base URL by language id
if (!function_exists('generateBaseURLByLangId')) {
    function generateBaseURLByLangId($langId)
    {
        if ($langId == Globals::$generalSettings->site_lang) {
            return base_url() . '/';
        } else {
            $languages = Globals::$languages;
            $shortForm = '';
            if (!empty($languages)) {
                foreach ($languages as $language) {
                    if ($langId == $language->id) {
                        $shortForm = $language->short_form;
                    }
                }
            }
            if ($shortForm != '') {
                return base_url($shortForm) . '/';
            }
        }
        return base_url() . '/';
    }
}

//generate base URL by language
if (!function_exists('generateBaseURLByLang')) {
    function generateBaseURLByLang($lang)
    {
        if (!empty($lang)) {
            if ($lang->id == Globals::$generalSettings->site_lang) {
                return base_url() . '/';
            } else {
                return base_url($lang->short_form) . '/';
            }
        }
        return base_url() . '/';
    }
}

//current full url
if (!function_exists('currentFullURL')) {
    function currentFullURL()
    {
        $currentURL = current_url();
        if (!empty($_SERVER['QUERY_STRING'])) {
            $currentURL = $currentURL . "?" . $_SERVER['QUERY_STRING'];
        }
        return $currentURL;
    }
}

//admin url
if (!function_exists('adminUrl')) {
    function adminUrl($route = null)
    {
        if (!empty($route)) {
            return base_url(Globals::$customRoutes->admin . '/' . $route);
        }
        return base_url(Globals::$customRoutes->admin);
    }
}

//force redirect to URL
if (!function_exists('redirectToUrl')) {
    function redirectToUrl($url)
    {
        header('Location: ' . $url);
    }
}

//redirect to back URL
if (!function_exists('redirectToBackURL')) {
    function redirectToBackURL()
    {
        $backURL = inputPost('back_url');
        if (!empty($backURL) && strpos($backURL, base_url()) !== false) {
            redirectToUrl($backURL);
            exit();
        }
        redirectToUrl(langBaseUrl());
        exit();
    }
}

//get request
if (!function_exists('inputGet')) {
    function inputGet($input_name, $removeForbidden = false)
    {
        $input = \Config\Services::request()->getGet($input_name);
        if (!is_array($input)) {
            $input = strTrim($input);
        }
        if ($removeForbidden) {
            $input = removeForbiddenCharacters($input);
        }
        return $input;
    }
}

//post request
if (!function_exists('inputPost')) {
    function inputPost($input_name, $removeForbidden = false)
    {
        $input = \Config\Services::request()->getPost($input_name);
        if (!is_array($input)) {
            $input = strTrim($input);
        }
        if ($removeForbidden) {
            $input = removeForbiddenCharacters($input);
        }
        return $input;
    }
}

//auth check
if (!function_exists('authCheck')) {
    function authCheck()
    {
        return Globals::$authCheck;
    }
}

//get active user
if (!function_exists('user')) {
    function user()
    {
        return Globals::$authUser;
    }
}

//get user by id
if (!function_exists('getUserById')) {
    function getUserById($id)
    {
        $model = new \App\Models\AuthModel();
        return $model->getUser($id);
    }
}

//is admin
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (authCheck()) {
            if (user()->role == 'admin') {
                return true;
            }
        }
        return false;
    }
}

//check admin
if (!function_exists('checkAdmin')) {
    function checkAdmin()
    {
        if (!isAdmin()) {
            return redirect()->to(langBaseUrl());
        }
    }
}

//get language
if (!function_exists('getLanguage')) {
    function getLanguage($id)
    {
        $model = new \App\Models\LanguageModel();
        return $model->getLanguage($id);
    }
}

//get favicon
if (!function_exists('getFavicon')) {
    function getFavicon()
    {
        $generalSettings = Globals::$generalSettings;
        if (!empty($generalSettings)) {
            if (!empty($generalSettings->favicon) && file_exists(FCPATH . $generalSettings->favicon)) {
                return base_url($generalSettings->favicon);
            }
            return base_url("assets/img/favicon.png");
        }
        return base_url("assets/img/favicon.png");
    }
}

//get logo
if (!function_exists('getLogo')) {
    function getLogo()
    {
        $generalSettings = Globals::$generalSettings;
        if (!empty($generalSettings)) {
            if (!empty($generalSettings->logo) && file_exists(FCPATH . $generalSettings->logo)) {
                return base_url($generalSettings->logo);
            }
            return base_url("assets/img/logo.svg");
        }
        return base_url("assets/img/logo.svg");
    }
}

//get logo footer
if (!function_exists('getLogoFooter')) {
    function getLogoFooter()
    {
        $generalSettings = Globals::$generalSettings;
        if (!empty($generalSettings)) {
            if (!empty($generalSettings->logo_footer) && file_exists(FCPATH . $generalSettings->logo_footer)) {
                return base_url($generalSettings->logo_footer);
            }
            return base_url("assets/img/logo-footer.svg");
        }
        return base_url("assets/img/logo-footer.svg");
    }
}

//get logo email
if (!function_exists('getLogoEmail')) {
    function getLogoEmail()
    {
        $generalSettings = Globals::$generalSettings;
        if (!empty($generalSettings)) {
            if (!empty($generalSettings->logo_email) && file_exists(FCPATH . $generalSettings->logo_email)) {
                return base_url($generalSettings->logo_email);
            }
            return base_url("assets/img/logo.png");
        }
        return base_url("assets/img/logo.png");
    }
}

//get user avatar
if (!function_exists('getUserAvatar')) {
    function getUserAvatar($avatarPath)
    {
        if (!empty($avatarPath)) {
            if (file_exists(FCPATH . $avatarPath)) {
                return base_url($avatarPath);
            }
            return $avatarPath;
        }
        return base_url("assets/img/user.png");
    }
}

//translation
if (!function_exists('trans')) {
    function trans($string)
    {
        if (isset(Globals::$languageTranslations[$string])) {
            return Globals::$languageTranslations[$string];
        }
        return "";
    }
}

//translation by label
if (!function_exists('getTransByLabel')) {
    function getTransByLabel($label, $langId)
    {
        $model = new \App\Models\LanguageModel();
        return $model->getTransByLabel($label, $langId);
    }
}

//check user permission
if (!function_exists('checkUserPermission')) {
    function checkUserPermission($permission)
    {
        if (authCheck()) {
            $userRole = user()->role;
            if ($userRole == 'admin') {
                return true;
            }
            $rolePermission = array_filter(Globals::$rolesPermissions, function ($item) use ($userRole) {
                return $item->role == $userRole;
            });
            foreach ($rolePermission as $key => $value) {
                $rolePermission = $value;
                break;
            }
            if (!empty($rolePermission) && $rolePermission->$permission == 1) {
                return true;
            }
        }
        return false;
    }
}

//check permission
if (!function_exists('checkPermission')) {
    function checkPermission($permission)
    {
        if (!checkUserPermission($permission)) {
            redirectToUrl(langBaseUrl());
            exit();
        }
    }
}

//get route
if (!function_exists('getRoute')) {
    function getRoute($key, $slash = false)
    {
        $route = $key;
        if (!empty(Globals::$customRoutes->$key)) {
            $route = Globals::$customRoutes->$key;
            if ($slash == true) {
                $route .= '/';
            }
        }
        return $route;
    }
}

//generate static url
if (!function_exists('generateURL')) {
    function generateURL($route1, $route2 = null)
    {
        if (!empty($route2)) {
            return langBaseUrl(getRoute($route1, true) . getRoute($route2));
        } else {
            return langBaseUrl(getRoute($route1));
        }
    }
}

//generate post url
if (!function_exists('generatePostURL')) {
    function generatePostURL($post, $baseURL = null)
    {
        if ($baseURL == null) {
            $baseURL = langBaseUrl() . '/';
        }
        if (!empty($post)) {
            if (!empty($post->post_url) && Globals::$generalSettings->redirect_rss_posts_to_original == 1) {
                return $post->post_url;
            }
            return $baseURL . $post->title_slug;
        }
        return "#";
    }
}


//generate tag url
if (!function_exists('generateTagURL')) {
    function generateTagURL($tagSlug)
    {
        if (!empty($tagSlug)) {
            return langBaseUrl(getRoute('tag', true) . $tagSlug);
        }
        return "#";
    }
}

//add new tab for post url
if (!function_exists('postURLNewTab')) {
    function postURLNewTab($post)
    {
        if (!empty($post)) {
            if (!empty($post->post_url) && Globals::$generalSettings->redirect_rss_posts_to_original == 1) {
                echo ' target="_blank"';
            }
        }
    }
}

//generate menu item url
if (!function_exists('generateMenuItemURL')) {
    function generateMenuItemURL($item, $baseCategories)
    {
        if (empty($item)) {
            return langBaseUrl('#');
        }
        if ($item->item_type == 'page') {
            if (!empty($item->item_link)) {
                return $item->item_link;
            } else {
                return langBaseUrl($item->item_slug);
            }
        } elseif ($item->item_type == 'category') {
            $category = getCategory($item->item_id, $baseCategories);
            if (!empty($category)) {
                if (!empty($category->parent_slug)) {
                    return langBaseUrl($category->parent_slug . "/" . $category->name_slug);
                } else {
                    return langBaseUrl($category->name_slug);
                }
            }
        } else {
            return langBaseUrl("#");
        }
    }
}

//generate category url
if (!function_exists('generateCategoryURL')) {
    function generateCategoryURL($category)
    {
        if (!empty($category)) {
            if (!empty($category->parent_slug)) {
                return langBaseUrl($category->parent_slug . "/" . $category->name_slug);
            }
            return langBaseUrl($category->name_slug);
        }
        return "#";
    }
}

//generate category url by id
if (!function_exists('generateCategoryURLById')) {
    function generateCategoryURLById($categoryId, $baseCategories)
    {
        $category = getCategory(cleanNumber($categoryId), $baseCategories);
        if (!empty($category)) {
            if (!empty($category->parent_slug)) {
                return langBaseUrl($category->parent_slug . "/" . $category->name_slug);
            }
            return langBaseUrl($category->name_slug);
        }
        return "#";
    }
}

//generate tag url
if (!function_exists('generateTagURL')) {
    function generateTagURL($slug)
    {
        if (!empty($slug)) {
            return langBaseUrl(getRoute('tag', true) . $slug);
        }
        return "#";
    }
}


//generate profile url
if (!function_exists('generateProfileURL')) {
    function generateProfileURL($userSlug)
    {
        if (!empty($userSlug)) {
            return langBaseUrl(getRoute('profile', true) . $userSlug);
        }
        return "#";
    }
}

//get sub menu links
if (!function_exists('getSubMenuLinks')) {
    function getSubMenuLinks($menuLinks, $parentId, $type)
    {
        $subLinks = array();
        if (!empty($menuLinks)) {
            $subLinks = array_filter($menuLinks, function ($item) use ($parentId, $type) {
                return $item->item_type == $type && $item->item_parent_id == $parentId;
            });
        }
        return $subLinks;
    }
}

//get gallery album
if (!function_exists('getGalleryAlbum')) {
    function getGalleryAlbum($id)
    {
        $model = new \App\Models\GalleryModel();
        return $model->getAlbum($id);
    }
}

//get gallery category
if (!function_exists('getGalleryCategory')) {
    function getGalleryCategory($id)
    {
        $model = new \App\Models\GalleryModel();
        return $model->getCategory($id);
    }
}

//get gallery cover image
if (!function_exists('getGalleryCoverImage')) {
    function getGalleryCoverImage($albumId)
    {
        $model = new \App\Models\GalleryModel();
        return $model->getCoverImage($albumId);
    }
}

//get page by default name
if (!function_exists('getPageByDefaultName')) {
    function getPageByDefaultName($defaultName, $langId)
    {
        $model = new \App\Models\PageModel();
        return $model->getPageByDefaultName($defaultName, $langId);
    }
}

//get page link by default name
if (!function_exists('getPageLinkByDefaultName')) {
    function getPageLinkByDefaultName($defaultName, $lang_id)
    {
        $page = getPageByDefaultName($defaultName, $lang_id);
        if (!empty($page)) {
            return langBaseUrl($page->slug);
        }
        return "#";
    }
}

//check if user online
if (!function_exists('isUserOnline')) {
    function isUserOnline($timestamp)
    {
        if (!empty($timestamp)) {
            $timeAgo = strtotime($timestamp);
            $currentTime = time();
            $timeDifference = $currentTime - $timeAgo;
            $seconds = $timeDifference;
            $minutes = round($seconds / 60);
            if ($minutes <= 3) {
                return true;
            }
        }
        return false;
    }
}

//check user follows
if (!function_exists('isUserFollows')) {
    function isUserFollows($followingId, $followerId)
    {
        $model = new \App\Models\ProfileModel();
        return $model->isUserFollows($followingId, $followerId);
    }
}

//esc & addslashes
if (!function_exists('escSls')) {
    function escSls($str)
    {
        if (!empty($str)) {
            return addslashes(esc($str));
        }
    }
}

//generate slug
if (!function_exists('strSlug')) {
    function strSlug($str)
    {
        $str = strTrim($str);
        if (!empty($str)) {
            return url_title(convert_accented_characters($str), "-", TRUE);
        }
    }
}

//clean slug
if (!function_exists('cleanSlug')) {
    function cleanSlug($slug)
    {
        $slug = strTrim($slug);
        if (!empty($slug)) {
            $slug = urldecode($slug);
        }
        if (!empty($slug)) {
            $slug = strip_tags($slug);
        }
        return removeSpecialCharacters($slug);
    }
}

//clean string
if (!function_exists('cleanStr')) {
    function cleanStr($str)
    {
        $str = strTrim($str);
        $str = removeSpecialCharacters($str);
        return esc($str);
    }
}

//clean number
if (!function_exists('cleanNumber')) {
    function cleanNumber($num)
    {
        $num = strTrim($num);
        $num = esc($num);
        if (empty($num)) {
            return 0;
        }
        return intval($num);
    }
}

//clean number
if (!function_exists('clrQuotes')) {
    function clrQuotes($str)
    {
        $str = strReplace('"', '', $str);
        $str = strReplace("'", '', $str);
        return $str;
    }
}

//remove forbidden characters
if (!function_exists('removeForbiddenCharacters')) {
    function removeForbiddenCharacters($str)
    {
        $str = strTrim($str);
        $str = strReplace(';', '', $str);
        $str = strReplace('"', '', $str);
        $str = strReplace('$', '', $str);
        $str = strReplace('%', '', $str);
        $str = strReplace('*', '', $str);
        $str = strReplace('/', '', $str);
        $str = strReplace('\'', '', $str);
        $str = strReplace('<', '', $str);
        $str = strReplace('>', '', $str);
        $str = strReplace('=', '', $str);
        $str = strReplace('?', '', $str);
        $str = strReplace('[', '', $str);
        $str = strReplace(']', '', $str);
        $str = strReplace('\\', '', $str);
        $str = strReplace('^', '', $str);
        $str = strReplace('`', '', $str);
        $str = strReplace('{', '', $str);
        $str = strReplace('}', '', $str);
        $str = strReplace('|', '', $str);
        $str = strReplace('~', '', $str);
        $str = strReplace('+', '', $str);
        return $str;
    }
}

//remove special characters
if (!function_exists('removeSpecialCharacters')) {
    function removeSpecialCharacters($str, $removeQuotes = false)
    {
        $str = removeForbiddenCharacters($str);
        $str = strReplace('#', '', $str);
        $str = strReplace('!', '', $str);
        $str = strReplace('(', '', $str);
        $str = strReplace(')', '', $str);
        if ($removeQuotes) {
            $str = clrQuotes($str);
        }
        return $str;
    }
}

//price formatted
if (!function_exists('priceFormatted')) {
    function priceFormatted($price, $decimalPoint = 2)
    {
        $thousandSep = ',';
        $decPoint = '.';
        if (getThousandSeparator() != ',') {
            $thousandSep = '.';
            $decPoint = ',';
        }
        if (!empty($price)) {
            if (is_int($price)) {
                $price = @number_format($price, 0, $decPoint, $thousandSep);
            } else {
                $price = @number_format($price, $decimalPoint, $decPoint, $thousandSep);
            }
        }
        if (Globals::$generalSettings->currency_symbol_format == "left") {
            $price = "<span>" . Globals::$generalSettings->currency_symbol . "</span>" . $price;
        } else {
            $price = $price . "<span>" . Globals::$generalSettings->currency_symbol . "</span>";
        }
        return $price;
    }
}

//get reward price decimal
if (!function_exists('getRewardPriceDecimal')) {
    function getRewardPriceDecimal()
    {
        if (Globals::$generalSettings->reward_amount >= 0.1) {
            return 5;
        }
        return 6;
    }
}

//get thousands separator
if (!function_exists('getThousandSeparator')) {
    function getThousandSeparator()
    {
        $thousandSeparator = ',';
        if (Globals::$generalSettings->currency_format == 'european') {
            $thousandSeparator = '.';
        }
        return $thousandSeparator;
    }
}

//check admin nav
if (!function_exists('getEarningObjectByDay')) {
    function getEarningObjectByDay($day, $pageViewsCounts)
    {
        if ($day < 10 && strpos($day, '0') == false) {
            $day = str_pad($day, 2, '0', STR_PAD_LEFT);
        }
        $date = date('Y') . '-' . date('m') . '-' . $day;
        $objects = array_filter($pageViewsCounts, function ($item) use ($date) {
            return $item->date == $date;
        });
        $object = null;
        if (!empty($objects)) {
            foreach ($objects as $key => $value) {
                $object = $value;
                break;
            }
        }
        return $object;
    }
}

//set cookie
if (!function_exists('helperSetCookie')) {
    function helperSetCookie($name, $value, $time = null)
    {
        if ($time == null) {
            $time = time() + (86400 * 30);
        }
        if (empty($params)) {
            $config = config('App');
            $params = array(
                'expires' => $time,
                'path' => $config->cookiePath,
                'domain' => $config->cookieDomain,
                'secure' => $config->cookieSecure,
                'httponly' => $config->cookieHTTPOnly,
                'samesite' => $config->cookieSameSite,
            );
        }
        if (!empty(getenv('cookie.prefix'))) {
            $name = getenv('cookie.prefix') . '_' . $name;
        }
        setcookie($name, $value, $params);
    }
}

//get cookie
if (!function_exists('helperGetCookie')) {
    function helperGetCookie($name)
    {
        if (!empty(getenv('cookie.prefix'))) {
            $name = getenv('cookie.prefix') . '_' . $name;
        }
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return false;
    }
}

//delete cookie
if (!function_exists('helperDeleteCookie')) {
    function helperDeleteCookie($name)
    {
        if (!empty(helperGetCookie($name))) {
            helperSetCookie($name, '', time() - 3600);
        }
    }
}

//set session
if (!function_exists('setSession')) {
    function setSession($name, $value)
    {
        $session = \Config\Services::session();
        $session->set($name, $value);
    }
}

//get session
if (!function_exists('getSession')) {
    function getSession($name)
    {
        $session = \Config\Services::session();
        if ($session->get($name) !== null) {
            return $session->get($name);
        }
        return null;
    }
}

//delete session
if (!function_exists('deleteSession')) {
    function deleteSession($name)
    {
        $session = \Config\Services::session();
        if ($session->get($name) !== null) {
            $session->remove($name);
        }
    }
}

//generate unique id
if (!function_exists('generateToken')) {
    function generateToken()
    {
        $id = uniqid("", TRUE);
        $id = strReplace(".", "-", $id);
        return $id . "-" . rand(10000000, 99999999);
    }
}

//get validation rules
if (!function_exists('getValRules')) {
    function getValRules($val)
    {
        $rules = $val->getRules();
        $newRules = array();
        if (!empty($rules)) {
            foreach ($rules as $key => $rule) {
                $newRules[$key] = [
                    'label' => $rule['label'],
                    'rules' => $rule['rules'],
                    'errors' => [
                        'required' => trans("form_validation_required"),
                        'min_length' => trans("form_validation_min_length"),
                        'max_length' => trans("form_validation_max_length"),
                        'matches' => trans("form_validation_matches"),
                        'is_unique' => trans("form_validation_is_unique")
                    ]
                ];
            }
        }
        return $newRules;
    }
}

//get segment value
if (!function_exists('getSegmentValue')) {
    function getSegmentValue($segmentNumber)
    {
        try {
            $uri = service('uri');
            if ($uri->getSegment($segmentNumber) !== null) {
                return $uri->getSegment($segmentNumber);
            }
        } catch (Exception $e) {
        }
        return null;
    }
}

//check admin nav
if (!function_exists('isAdminNavActive')) {
    function isAdminNavActive($arrayNavItems)
    {
        $segment = getSegmentValue(2);
        if (!empty($segment) && !empty($arrayNavItems)) {
            if (in_array($segment, $arrayNavItems)) {
                echo ' ' . 'active';
            }
        }
    }
}

//get navigation item edit link
if (!function_exists('getAdminNavItemEditLink')) {
    function getAdminNavItemEditLink($menuItem)
    {
        if (!empty($menuItem)) {
            if ($menuItem->item_type == "category") {
                return adminUrl('edit-category/' . $menuItem->item_id . '?redirect_url=' . current_url() . '?' . $_SERVER['QUERY_STRING']);
            } else {
                if (!empty($menuItem->item_link)) {
                    return adminUrl('edit-menu-link/' . $menuItem->item_id);
                } else {
                    return adminUrl('edit-page/' . $menuItem->item_id . '?redirect_url=' . current_url() . '?' . $_SERVER['QUERY_STRING']);
                }
            }
        }
    }
}

//get navigation item delete function
if (!function_exists('getAdminNavItemDeleteFunction')) {
    function getAdminNavItemDeleteFunction($menuItem)
    {
        if (!empty($menuItem)) {
            if ($menuItem->item_type == "category") {
                return "deleteItem('CategoryController/deleteCategoryPost','" . $menuItem->item_id . "','" . trans("confirm_category") . "');";
            } else {
                if (!empty($menuItem->item_link)) {
                    return "deleteItem('AdminController/deleteNavigationPost','" . $menuItem->item_id . "','" . trans("confirm_link") . "');";
                } else {
                    return "deleteItem('AdminController/deletePagePost','" . $menuItem->item_id . "','" . trans("confirm_page") . "');";
                }
            }
        }
    }
}

//get navigation item type
if (!function_exists('getAdminNavItemType')) {
    function getAdminNavItemType($menuItem)
    {
        if (!empty($menuItem)) {
            if ($menuItem->item_type == "category") {
                return trans("category");
            } else {
                if (!empty($menuItem->item_link)) {
                    return trans("link");
                } else {
                    return trans("page");
                }
            }
        }
    }
}

//count items
if (!function_exists('countItems')) {
    function countItems($items)
    {
        if (!empty($items) && is_array($items)) {
            return count($items);
        }
        return 0;
    }
}

//is recaptcha enabled
if (!function_exists('isRecaptchaEnabled')) {
    function isRecaptchaEnabled($generalSettings)
    {
        if (!empty($generalSettings->recaptcha_site_key) && !empty($generalSettings->recaptcha_secret_key)) {
            return true;
        }
        return false;
    }
}

//get recaptcha
if (!function_exists('reCaptcha')) {
    function reCaptcha($action, $generalSettings)
    {
        if (isRecaptchaEnabled($generalSettings)) {
            loadLibrary('reCAPTCHA');
            $reCAPTCHA = new reCAPTCHA($generalSettings->recaptcha_site_key, $generalSettings->recaptcha_secret_key);
            $reCAPTCHA->setLanguage(Globals::$activeLang->short_form);
            if ($action == "generate") {
                echo $reCAPTCHA->getScript();
                echo $reCAPTCHA->getHtml();
            } elseif ($action == "validate") {
                if (!$reCAPTCHA->isValid($_POST['g-recaptcha-response'])) {
                    return 'invalid';
                }
            }
        }
    }
}

//date format with month
if (!function_exists('formatDateFront')) {
    function formatDateFront($timestamp)
    {
        if (!empty($timestamp)) {
            $date = date("M j, Y", strtotime($timestamp));
            return replaceMonthName($date);
        }
    }
}

//date format
if (!function_exists('formatDate')) {
    function formatDate($timestamp)
    {
        if (!empty($timestamp)) {
            return date("Y-m-d / H:i", strtotime($timestamp));
        }
    }
}

//print formatted hour
if (!function_exists('formatHour')) {
    function formatHour($timestamp)
    {
        if (!empty($timestamp)) {
            return date("H:i", strtotime($timestamp));
        }
    }
}

//date format
if (!function_exists('replaceMonthName')) {
    function replaceMonthName($str)
    {
        $str = strTrim($str);
        $str = strReplace("Jan", trans("January"), $str);
        $str = strReplace("Feb", trans("February"), $str);
        $str = strReplace("Mar", trans("March"), $str);
        $str = strReplace("Apr", trans("April"), $str);
        $str = strReplace("May", trans("May"), $str);
        $str = strReplace("Jun", trans("June"), $str);
        $str = strReplace("Jul", trans("July"), $str);
        $str = strReplace("Aug", trans("August"), $str);
        $str = strReplace("Sep", trans("September"), $str);
        $str = strReplace("Oct", trans("October"), $str);
        $str = strReplace("Nov", trans("November"), $str);
        $str = strReplace("Dec", trans("December"), $str);
        return $str;
    }
}

//date diff
if (!function_exists('dateDifference')) {
    function dateDifference($date1, $date2, $format = '%a')
    {
        if (!empty($date1) && !empty($date2)) {
            $datetime1 = date_create($date1);
            $datetime2 = date_create($date2);
            $diff = date_diff($datetime1, $datetime2);
            return $diff->format($format);
        }
    }
}

//date difference in hours
if (!function_exists('dateDifferenceInHours')) {
    function dateDifferenceInHours($date1, $date2)
    {
        if (!empty($date1) && !empty($date2)) {
            $datetime1 = date_create($date1);
            $datetime2 = date_create($date2);
            $diff = date_diff($datetime1, $datetime2);
            $days = $diff->format('%a');
            $hours = $diff->format('%h');
            return $hours + ($days * 24);
        }
    }
}

//check cron time
if (!function_exists('checkCronTime')) {
    function checkCronTime($hour)
    {
        if (empty(Globals::$generalSettings->last_cron_update) || dateDifferenceInHours(date('Y-m-d H:i:s'), Globals::$generalSettings->last_cron_update) >= $hour) {
            return true;
        }
        return false;
    }
}

//update last seen
if (!function_exists('updateLastSeen')) {
    function updateLastSeen()
    {
        $model = new \App\Models\AuthModel();
        $model->updateLastSeen();
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($timestamp)
    {
        if (!empty($timestamp)) {
            $timeDiff = time() - strtotime($timestamp);
            $seconds = $timeDiff;
            $minutes = round($seconds / 60);
            $hours = round($seconds / 3600);
            $days = round($seconds / 86400);
            $weeks = round($seconds / 604800);
            $months = round($seconds / 2629440);
            $years = round($seconds / 31553280);
            if ($seconds <= 60) {
                return trans("just_now");
            } else if ($minutes <= 60) {
                if ($minutes == 1) {
                    return "1 " . trans("minute") . " " . trans("ago");
                } else {
                    return $minutes . " " . trans("minutes") . " " . trans("ago");
                }
            } else if ($hours <= 24) {
                if ($hours == 1) {
                    return "1 " . trans("hour") . " " . trans("ago");
                } else {
                    return $hours . " " . trans("hours") . " " . trans("ago");
                }
            } else if ($days <= 30) {
                if ($days == 1) {
                    return "1 " . trans("day") . " " . trans("ago");
                } else {
                    return $days . " " . trans("days") . " " . trans("ago");
                }
            } else if ($months <= 12) {
                if ($months == 1) {
                    return "1 " . trans("month") . " " . trans("ago");
                } else {
                    return $months . " " . trans("months") . " " . trans("ago");
                }
            } else {
                if ($years == 1) {
                    return "1 " . trans("year") . " " . trans("ago");
                } else {
                    return $years . " " . trans("years") . " " . trans("ago");
                }
            }
        }
    }
}

//paginate
if (!function_exists('paginate')) {
    function paginate($perPage, $total)
    {
        $page = @intval(inputGet('page'));
        if (empty($page) || $page < 1) {
            $page = 1;
        }
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total);
        $pager->page = $page;
        $pager->offset = ($page - 1) * $perPage;
        return $pager;
    }
}

//paginate
if (!function_exists('getIPAddress')) {
    function getIPAddress()
    {
        $request = \Config\Services::request();
        return $request->getIPAddress();
    }
}

//convert xml characters
if (!function_exists('convertToXMLCharacter')) {
    function convertToXMLCharacter($string)
    {
        $str = strReplace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
        $str = strReplace('#45;', '', $str);
        return $str;
    }
}

//check newsletter modal
if (!function_exists('checkNewsletterModal')) {
    function checkNewsletterModal()
    {
        if (!authCheck() && Globals::$generalSettings->newsletter_status == 1 && Globals::$generalSettings->newsletter_popup == 1) {
            if (empty(helperGetCookie('newsletter_popup'))) {
                helperSetCookie('newsletter_popup', '1', time() + (86400 * 365));
                return true;
            }
        }
        return false;
    }
}

//set active language ajax post
if (!function_exists('setActiveLangPostRequest')) {
    function setActiveLangPostRequest()
    {
        $sysLangId = cleanNumber(inputPost('sys_lang_id'));
        if (!empty($sysLangId) && Globals::$generalSettings->site_lang != $sysLangId) {
            $language = getLanguage($sysLangId);
            if (!empty($language)) {
                Globals::setActiveLanguage($language->id);
                Globals::updateLangBaseURL($language->short_form);
            }
        }
    }
}

//get popular tags
if (!function_exists('getPopularTags')) {
    function getPopularTags()
    {
        $popularTags = getCachedData('popular_tags');
        if (empty($popularTags)) {
            $model = new \App\Models\TagModel();
            $popularTags = $model->getPopularTags();
            setCacheData('popular_tags', $popularTags);
        }
        return $popularTags;
    }
}

//get polls
if (!function_exists('getPollsByActiveLang')) {
    function getPollsByActiveLang()
    {
        $model = new \App\Models\PollModel();
        return $model->getPollsByActiveLang();
    }
}

//calculate total vote of poll option
if (!function_exists('calculateTotalVotePollOption')) {
    function calculateTotalVotePollOption($poll)
    {
        $total = 0;
        if (!empty($poll)) {
            for ($i = 1; $i <= 10; $i++) {
                $op = "option{$i}_vote_count";
                $total += $poll->$op;
            }
        }
        return $total;
    }
}

//get social links array
if (!function_exists('getSocialLinksArray')) {
    function getSocialLinksArray()
    {
        $settings = Globals::$settings;
        $array = array();
        if (!empty($settings->facebook_url)) {
            array_push($array, ['name' => 'facebook', 'url' => $settings->facebook_url]);
        }
        if (!empty($settings->twitter_url)) {
            array_push($array, ['name' => 'twitter', 'url' => $settings->twitter_url]);
        }
        if (!empty($settings->pinterest_url)) {
            array_push($array, ['name' => 'pinterest', 'url' => $settings->pinterest_url]);
        }
        if (!empty($settings->instagram_url)) {
            array_push($array, ['name' => 'instagram', 'url' => $settings->instagram_url]);
        }
        if (!empty($settings->linkedin_url)) {
            array_push($array, ['name' => 'linkedin', 'url' => $settings->linkedin_url]);
        }
        if (!empty($settings->vk_url)) {
            array_push($array, ['name' => 'vk', 'url' => $settings->vk_url]);
        }
        if (!empty($settings->telegram_url)) {
            array_push($array, ['name' => 'telegram', 'url' => $settings->telegram_url]);
        }
        if (!empty($settings->youtube_url)) {
            array_push($array, ['name' => 'youtube', 'url' => $settings->youtube_url]);
        }
        return $array;
    }
}

//get widget
if (!function_exists('getWidget')) {
    function getWidget($baseWidgets, $type)
    {
        if (!empty($baseWidgets)) {
            foreach ($baseWidgets as $widget) {
                if ($widget->type == $type) {
                    return $widget;
                }
            }
        }
        return null;
    }
}

//get category widgets
if (!function_exists('getCategoryWidgets')) {
    function getCategoryWidgets($categoryId, $baseWidgets, $adSpaces, $langId)
    {
        $arrayWidgets = array();
        $widgetIds = array();
        $ads = array();
        $hasWidgets = false;
        if (!empty($baseWidgets)) {
            if (empty($categoryId)) {
                foreach ($baseWidgets as $widget) {
                    if (empty($widget->display_category_id) && !in_array($widget->id, $widgetIds) && $widget->lang_id == $langId) {
                        array_push($arrayWidgets, $widget);
                        array_push($widgetIds, $widget->id);
                    }
                }
            } else {
                foreach ($baseWidgets as $widget) {
                    if ($widget->display_category_id == $categoryId && !in_array($widget->id, $widgetIds) && $widget->lang_id == $langId) {
                        array_push($arrayWidgets, $widget);
                        array_push($widgetIds, $widget->id);
                    }
                }
            }
        }
        if (!empty($adSpaces)) {
            foreach ($adSpaces as $item) {
                if ($item->display_category_id == $categoryId) {
                    array_push($ads, $item);
                }
            }
        }
        if (!empty($arrayWidgets) || !empty($ads)) {
            $hasWidgets = true;
        }

        $classWidgets = new stdClass();
        $classWidgets->widgets = $arrayWidgets;
        $classWidgets->ads = $ads;
        $classWidgets->hasWidgets = $hasWidgets;
        return $classWidgets;
    }
}

//is reaction voted
if (!function_exists('isReactionVoted')) {
    function isReactionVoted($postId, $reaction)
    {
        if (!empty(helperGetCookie('reaction_' . $reaction . '_' . $postId))) {
            return true;
        }
        return false;
    }
}

//get font family
if (!function_exists('getFontFamily')) {
    function getFontFamily($activeFonts, $key, $removeFamilyText = false)
    {
        if (!empty($activeFonts[$key]) && !empty($activeFonts[$key]->font_family)) {
            $fontFamily = $activeFonts[$key]->font_family;
            if (!empty($fontFamily)) {
                if ($removeFamilyText) {
                    $fontFamilyArray = explode(':', $fontFamily);
                    if (!empty($fontFamilyArray[1])) {
                        return $fontFamilyArray[1];
                    }
                }
                return $activeFonts[$key]->font_family;
            }


        }
        return '';
    }
}

//get font url
if (!function_exists('getFontURL')) {
    function getFontURL($activeFonts, $key)
    {
        if (!empty($activeFonts[$key]) && !empty($activeFonts[$key]->font_url) && $activeFonts[$key]->font_source != 'local') {
            return $activeFonts[$key]->font_url;
        }
        return '';
    }
}

//load library
if (!function_exists('loadLibrary')) {
    function loadLibrary($library)
    {
        $path = APPPATH . 'Libraries/' . $library . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }
}

/**
 * --------------------------------------------------------------------------
 * POST FUNCTIONS
 * --------------------------------------------------------------------------
 */

//set cache data
if (!function_exists('setCacheData')) {
    function setCacheData($key, $data)
    {
        $key = $key . "_lang" . Globals::$activeLang->id;
        if (Globals::$generalSettings->cache_system == 1) {
            $cache = \Config\Services::cache();
            cache()->save($key, $data, Globals::$generalSettings->cache_refresh_time);
        }
    }
}

//set cache data by lang
if (!function_exists('setCacheDataByLang')) {
    function setCacheDataByLang($key, $data, $langId)
    {
        $key = $key . "_lang" . $langId;
        if (Globals::$generalSettings->cache_system == 1) {
            $cache = \Config\Services::cache();
            cache()->save($key, $data, Globals::$generalSettings->cache_refresh_time);
        }
    }
}

//get cached data
if (!function_exists('getCachedData')) {
    function getCachedData($key)
    {
        $key = $key . "_lang" . Globals::$activeLang->id;
        if (Globals::$generalSettings->cache_system == 1) {
            $cache = \Config\Services::cache();
            if ($data = cache($key)) {
                return $data;
            }
        }
        return false;
    }
}

//get cached data by lang
if (!function_exists('getCachedDataByLang')) {
    function getCachedDataByLang($key, $langId)
    {
        $key = $key . "_lang" . $langId;
        if (Globals::$generalSettings->cache_system == 1) {
            $cache = \Config\Services::cache();
            if ($data = cache($key)) {
                return $data;
            }
        }
        return false;
    }
}

//reset cache data
if (!function_exists('resetCacheData')) {
    function resetCacheData()
    {
        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . '*');
        if (!empty($files)) {
            foreach ($files as $file) {
                if (strpos($file, 'index.html') === false) {
                    @unlink($file);
                }
            }
        }
    }
}

//reset cache data on change
if (!function_exists('resetCacheDataOnChange')) {
    function resetCacheDataOnChange()
    {
        if (Globals::$generalSettings->refresh_cache_database_changes == 1) {
            resetCacheData();
        }
    }
}

//get category by id
if (!function_exists('getCategoryById')) {
    function getCategoryById($id)
    {
        $model = new \App\Models\CategoryModel();
        return $model->getCategory($id);
    }
}

//get category
if (!function_exists('getCategory')) {
    function getCategory($id, $categories)
    {
        $category = null;
        if (!empty($categories)) {
            $category = array_filter($categories, function ($item) use ($id) {
                return $item->id == $id;
            });
            foreach ($category as $key => $value) {
                $category = $value;
                break;
            }
        }
        return $category;
    }
}

//get categories
if (!function_exists('getCategories')) {
    function getCategories()
    {
        $model = new \App\Models\CategoryModel();
        return $model->getCategories();
    }
}

//get categories
if (!function_exists('getCategoriesByLang')) {
    function getCategoriesByLang($langId)
    {
        $model = new \App\Models\CategoryModel();
        return $model->getCategoriesByLang($langId);
    }
}

//get subcategories
if (!function_exists('getSubcategories')) {
    function getSubcategories($parentId, $categories)
    {
        if (!empty($categories)) {
            return array_filter($categories, function ($item) use ($parentId) {
                return $item->parent_id == $parentId;
            });
        }
        return null;
    }
}

//get category tree
if (!function_exists('getCategoryTree')) {
    function getCategoryTree($categoryId, $categories)
    {
        $tree = array();
        $categoryId = cleanNumber($categoryId);
        if (!empty($categoryId)) {
            array_push($tree, $categoryId);
            $subCategories = getSubcategories($categoryId, $categories);
            if (!empty($subCategories)) {
                foreach ($subCategories as $subCategory) {
                    array_push($tree, $subCategory->id);
                }
            }
        }
        return $tree;
    }
}

//get parent category tree
if (!function_exists('getParentCategoryTree')) {
    function getParentCategoryTree($categoryId, $categories)
    {
        $tree = array();
        $categoryId = cleanNumber($categoryId);
        if (!empty($categoryId)) {
            $category = getCategory($categoryId, $categories);
            if (!empty($category) && $category->parent_id != 0) {
                $parent = getCategory($category->parent_id, $categories);
                if (!empty($parent)) {
                    array_push($tree, $parent);
                }
            }
            array_push($tree, $category);
        }
        return $tree;
    }
}

//get posts by category
if (!function_exists('getPostsByCategoryId')) {
    function getPostsByCategoryId($categoryId, $categories, $latestCategoryPosts)
    {
        if (!empty($latestCategoryPosts)) {
            $categoryTree = getCategoryTree($categoryId, $categories);
            if (!empty($categoryTree)) {
                return array_filter($latestCategoryPosts, function ($item) use ($categoryTree) {
                    return in_array($item->category_id, $categoryTree);
                });
            }
        }
        return null;
    }
}

//get post by id
if (!function_exists('getPostById')) {
    function getPostById($id)
    {
        $model = new \App\Models\PostAdminModel();
        return $model->getPost($id);
    }
}

//get post image
if (!function_exists('getPostImage')) {
    function getPostImage($post, $imageSize)
    {
        if (!empty($post)) {
            if (!empty($post->image_url)) {
                return $post->image_url;
            } else {
                $path = "";
                if ($imageSize == "big") {
                    $path = $post->image_big;
                } elseif ($imageSize == "default") {
                    $path = $post->image_default;
                } elseif ($imageSize == "slider") {
                    $path = $post->image_slider;
                } elseif ($imageSize == "mid") {
                    $path = $post->image_mid;
                } elseif ($imageSize == "small") {
                    $path = $post->image_small;
                }
                if ($post->image_storage == 'aws_s3') {
                    $path = getAWSBaseURL() . $path;
                } else {
                    $path = base_url($path);
                }
                return $path;
            }
        }
    }
}

//get slider posts
if (!function_exists('getSliderPosts')) {
    function getSliderPosts()
    {
        $sliderPosts = getCachedData('slider_posts');
        if (empty($sliderPosts)) {
            $model = new \App\Models\PostModel();
            $sliderPosts = $model->getSliderPosts();
            setCacheData('slider_posts', $sliderPosts);
        }
        return $sliderPosts;
    }
}


//get featured posts
if (!function_exists('getFeaturedPosts')) {
    function getFeaturedPosts()
    {
        $featuredPosts = getCachedData('featured_posts');
        if (empty($featuredPosts)) {
            $model = new \App\Models\PostModel();
            $featuredPosts = $model->getFeaturedPosts();
            setCacheData('featured_posts', $featuredPosts);
        }
        return $featuredPosts;
    }
}

//get breaking news
if (!function_exists('getBreakingNews')) {
    function getBreakingNews()
    {
        $breakingNews = getCachedData('breaking_news');
        if (empty($breakingNews)) {
            $model = new \App\Models\PostModel();
            $breakingNews = $model->getBreakingNews();
            setCacheData('breaking_news', $breakingNews);
        }
        return $breakingNews;
    }
}

//check post image exist
if (!function_exists('checkPostImg')) {
    function checkPostImg($post, $type = '')
    {
        $isExist = false;
        if (!empty($post)) {
            if (!empty($post->image_mid) || !empty($post->image_small) || !empty($post->image_url)) {
                $isExist = true;
            }
        }
        if ($isExist == false && $type == 'class') {
            echo " post-item-no-image";
        } else {
            if ($type != 'class') {
                return $isExist;
            }
        }
    }
}

//get popular posts
if (!function_exists('getPopularPosts')) {
    function getPopularPosts($langId, $latestCategoryPosts)
    {
        $model = new \App\Models\PostModel();
        $popularPosts = getCachedDataByLang('popular_posts', $langId);
        if (empty($popularPosts)) {
            $popularPosts = completePopularPosts($model->getPopularPosts($langId), $langId, $latestCategoryPosts);
            setCacheDataByLang('popular_posts', $popularPosts, $langId);
        }
        return $popularPosts;
    }
}

//complete popular posts
if (!function_exists('completePopularPosts')) {
    function completePopularPosts($popularPosts, $langId, $latestCategoryPosts)
    {
        if (countItems($popularPosts) >= 5) {
            return $popularPosts;
        }
        if (!empty($latestCategoryPosts)) {
            foreach ($latestCategoryPosts as $post) {
                if ($post->lang_id == $langId) {
                    $inArray = false;
                    foreach ($popularPosts as $item) {
                        if ($item->id == $post->id) {
                            $inArray = true;
                        }
                    }
                    if ($inArray == false) {
                        $newPopular = clone $post;
                        $newPopular->pageviews = 0;
                        array_push($popularPosts, $newPopular);
                    }
                    if (countItems($popularPosts) >= 5) {
                        return $popularPosts;
                        break;
                    }
                }
            }
        }
        return $popularPosts;
    }
}

//get recommended posts
if (!function_exists('getRecommendedPosts')) {
    function getRecommendedPosts()
    {
        $recommendedPosts = getCachedData('recommended_posts');
        if (empty($recommendedPosts)) {
            $model = new  \App\Models\PostModel();
            $recommendedPosts = $model->getRecommendedPosts();
            setCacheData('recommended_posts', $recommendedPosts);
        }
        return $recommendedPosts;
    }
}

//get latest posts
if (!function_exists('getLatestPosts')) {
    function getLatestPosts($limit)
    {
        $key = 'latest_posts_' . $limit;
        $posts = getCachedData($key);
        if (empty($posts)) {
            $model = new  \App\Models\PostModel();
            $posts = $model->getLatestPosts($limit);
            setCacheData($key, $posts);
        }
        return $posts;
    }
}

//get most viewed posts
if (!function_exists('getMostViewedPosts')) {
    function getMostViewedPosts($limit)
    {
        $key = 'most_viewed_posts_' . $limit;
        $posts = getCachedData($key);
        if (empty($posts)) {
            $model = new  \App\Models\PostModel();
            $posts = $model->getMostViewedPosts($limit);
            setCacheData($key, $posts);
        }
        return $posts;
    }
}

//get post images
if (!function_exists('getPostAdditionalImages')) {
    function getPostAdditionalImages($postId)
    {
        $model = new \App\Models\PostAdminModel();
        return $model->getAdditionalImages($postId);
    }
}

//get post files
if (!function_exists('getPostFiles')) {
    function getPostFiles($postId)
    {
        $model = new \App\Models\PostAdminModel();
        return $model->getPostFiles($postId);
    }
}

//get quiz question answer
if (!function_exists('getQuizQuestionAnswers')) {
    function getQuizQuestionAnswers($questionId)
    {
        $model = new \App\Models\QuizModel();
        return $model->getQuizQuestionAnswers($questionId);
    }
}

//get post audios
if (!function_exists('getPostAudios')) {
    function getPostAudios($postId)
    {
        $model = new \App\Models\PostAdminModel();
        return $model->getPostAudios($postId);
    }
}

//check post delete permission
if (!function_exists('checkPostOwnership')) {
    function checkPostOwnership($ownerId)
    {
        if (checkUserPermission('manage_all_posts')) {
            return true;
        }
        if ($ownerId == user()->id) {
            return true;
        }
    }
}

//set post meta tags
if (!function_exists('setPostMetaTags')) {
    function setPostMetaTags($post, $postTags, $data)
    {
        $data['title'] = $post->title;
        $data['description'] = $post->summary;
        $data['keywords'] = $post->keywords;
        $data['ogTitle'] = $post->title;
        $data['ogType'] = 'article';
        $data['ogImage'] = getPostImage($post, 'big');
        $data['ogWidth'] = '750';
        $data['ogHeight'] = '422';
        $data['ogCreator'] = $post->author_username;
        $data['ogAuthor'] = $post->author_username;
        $data['ogPublishedTime'] = $post->created_at;
        $data['ogModifiedTime'] = $post->updated_at;
        if (empty($post->updated_at)) {
            $data['ogModifiedTime'] = $post->created_at;
        }
        $data['ogTags'] = $postTags;
        return $data;
    }
}

//check post is in the reading list or not
if (!function_exists('isPostInReadingList')) {
    function isPostInReadingList($postId)
    {
        $model = new \App\Models\PostModel();
        return $model->isPostInReadingList($postId);
    }
}

//generate keywords
if (!function_exists('generateKeywords')) {
    function generateKeywords($title)
    {
        if (!empty($title)) {
            $array = explode(" ", $title);
            $keywords = "";
            $i = 0;
            if (!empty($array)) {
                foreach ($array as $item) {
                    $item = strTrim($item);
                    $item = strTrim($item, ",");
                    if (!empty($item) && strlen($item) > 2) {
                        $item = removeSpecialCharacters($item);
                        if ($i == 0) {
                            $keywords = $item;
                        } else {
                            $keywords .= ", " . $item;
                        }
                    }
                    $i++;
                }
            }
            return $keywords;
        }
    }
}

//get aws base url
if (!function_exists('getAWSBaseURL')) {
    function getAWSBaseURL()
    {
        return 'https://s3.' . Globals::$generalSettings->aws_region . '.amazonaws.com/' . Globals::$generalSettings->aws_bucket . '/';
    }
}

//get post image base URL
if (!function_exists('getBaseURLByStorage')) {
    function getBaseURLByStorage($storage)
    {
        $baseURL = base_url() . '/';
        if ($storage == 'aws_s3') {
            $baseURL = getAWSBaseURL();
        }
        return $baseURL;
    }
}

//get csv value
if (!function_exists('getCSVInputValue')) {
    function getCSVInputValue($array, $key, $dataType = 'string')
    {
        if (!empty($array)) {
            if (!empty($array[$key])) {
                return $array[$key];
            }
        }
        if ($dataType == 'int') {
            return 0;
        }
        return '';
    }
}

//check if comment voted
if (!function_exists('isCommentVoted')) {
    function isCommentVoted($commentId)
    {
        if (!empty(helperGetCookie('comment_voted_' . $commentId))) {
            return true;
        }
        return false;
    }
}

//check comment owner
if (!function_exists('checkCommentOwner')) {
    function checkCommentOwner($comment)
    {
        if (!empty($comment)) {
            if (authCheck()) {
                if ($comment->user_id == user()->id) {
                    return true;
                }
            } else {
                if (!empty(helperGetCookie('added_comment_id_' . $comment->id))) {
                    return true;
                }
            }
        }
        return false;
    }
}

//get subcomments
if (!function_exists('getSubComments')) {
    function getSubComments($parentId)
    {
        $model = new \App\Models\CommonModel();
        return $model->getSubComments($parentId);
    }
}

//get media icon
if (!function_exists('getMediaIcon')) {
    function getMediaIcon($post, $class = '')
    {
        if (!empty($post)) {
            $cls = 'media-icon';
            if (!empty($class)) {
                $cls .= ' ' . $class;
            }
            if ($post->post_type == 'video') {
                echo '<span class="' . $cls . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ececec"viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"/></svg></span>';
            } elseif ($post->post_type == 'audio') {
                echo '<span class="' . $cls . '"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 160 160" fill="#ffffff"><path class="st0" d="M80,10c39,0,70,31,70,70s-31,70-70,70s-70-31-70-70S41,10,80,10z M80,0C36,0,0,36,0,80s36,80,80,80s80-36,80-80S124,0,80,0L80,0z"/><path d="M62.6,94.9c-2.5-1.7-5.8-2.8-9.4-2.8c-8,0-14.4,5.1-14.4,11.5c0,6.3,6.5,11.5,14.4,11.5s14.4-5.1,14.4-11.5v-35l36.7-5.8v26.5c-2.5-1.5-5.6-2.5-9-2.5c-8,0-14.4,5.1-14.4,11.5c0,6.3,6.5,11.5,14.4,11.5c8,0,14.4-5.1,14.4-11.5c0-0.4,0-0.9-0.1-1.3h0.1V40.2l-47.2,9.5V94.9z"/></svg></span>';
            }
        }
    }
}

//detect bots
if (!function_exists('isBot')) {
    function isBot()
    {
        if (preg_match('/abacho|accona|AddThis|AdsBot|ahoy|AhrefsBot|AISearchBot|alexa|altavista|anthill|appie|applebot|arale|araneo|AraybOt|ariadne|arks|aspseek
            |ATN_Worldwide|Atomz|baiduspider|baidu|bbot|bingbot|bing|Bjaaland|BlackWidow|BotLink|bot|boxseabot|bspider|calif|CCBot|ChinaClaw|christcrawler|CMC\/0\.01|combine
            |confuzzledbot|contaxe|CoolBot|cosmos|crawler|crawlpaper|crawl|curl|cusco|cyberspyder|cydralspider|dataprovider|digger|DIIbot|DotBot|downloadexpress|DragonBot
            |DuckDuckBot|dwcp|EasouSpider|ebiness|ecollector|elfinbot|esculapio|ESI|esther|eStyle|Ezooms|facebookexternalhit|facebook|facebot|fastcrawler|FatBot|FDSE|FELIX IDE
            |fetch|fido|find|Firefly|fouineur|Freecrawl|froogle|gammaSpider|gazz|gcreep|geona|Getterrobo-Plus|get|girafabot|golem|googlebot|\-google|grabber|GrabNet|griffon|Gromit
            |gulliver|gulper|hambot|havIndex|hotwired|htdig|HTTrack|ia_archiver|iajabot|IDBot|Informant|InfoSeek|InfoSpiders|INGRID\/0\.1|inktomi|inspectorwww|Internet Cruiser Robot
            |irobot|Iron33|JBot|jcrawler|Jeeves|jobo|KDD\-Explorer|KIT\-Fireball|ko_yappo_robot|label\-grabber|larbin|legs|libwww-perl|linkedin|Linkidator|linkwalker|Lockon|logo_gif_crawler
            |Lycos|m2e|majesticsEO|marvin|mattie|mediafox|mediapartners|MerzScope|MindCrawler|MJ12bot|mod_pagespeed|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|Nationa
            lDirectory|naverbot|NEC\-MeshExplorer|NetcraftSurveyAgent|NetScoop|NetSeer|newscan\-online|nil|none|Nutch|ObjectsSearch|Occam|openstat.ru\/Bot|packrat|pageboy|ParaSite|patric
            |pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pingdom|pinterest|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|rambler|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl
            |robofox|Scooter|Scrubby|Search\-AU|searchprocess|search|SemrushBot|Senrigan|seznambot|Shagseeker|sharp\-info\-agent|sift|SimBot|Site Valet|SiteSucker|skymob|SLCrawler\/2\.0
            |slurp|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|spider|suke|tach_bw|TechBOT|TechnoratiSnoop|templeton|teoma|titin|topiclink|twitterbot|twitter|UdmSearch
            |Ukonline|UnwindFetchor|URL_Spider_SQL|urlck|urlresolver|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|wapspider|WebBandit\/1\.0|webcatcher|WebCopier
            |WebFindBot|WebLeacher|WebMechanic|WebMoose|webquest|webreaper|webspider|webs|WebWalker|WebZip|wget|whowhere|winona|wlm|WOLP|woriobot|WWWC|XGET|xing|yahoo|YandexBot|YandexMobileBot
            |yandex|yeti|Zeus/i', $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }
        return false;
    }
}