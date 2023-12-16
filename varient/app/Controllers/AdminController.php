<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CategoryModel;
use App\Models\CommonModel;
use App\Models\EmailModel;
use App\Models\LanguageModel;
use App\Models\NewsletterModel;
use App\Models\PageModel;
use App\Models\PollModel;
use App\Models\PostAdminModel;
use App\Models\PostModel;
use App\Models\RewardModel;
use App\Models\SettingsModel;
use App\Models\SitemapModel;

class AdminController extends BaseAdminController
{
    protected $postAdminModel;
    protected $settingsModel;
    protected $pageModel;
    protected $authModel;
    protected $commonModel;
    protected $newsletterModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->postAdminModel = new PostAdminModel();
        $this->settingsModel = new SettingsModel();
        $this->pageModel = new PageModel();
        $this->authModel = new AuthModel();
        $this->commonModel = new CommonModel();
        $this->newsletterModel = new NewsletterModel();

        if(checkCronTime(1)){
            //delete old posts
            $this->postAdminModel->deleteOldPosts();
            //delete old page views
            $postModel = new PostModel();
            $postModel->deleteOldPageviews();
            //delete old sessions
            $this->settingsModel->deleteOldSessions();
            //update cron time
            $this->settingsModel->setLastCronUpdate();
        }
    }

    /**
     * Index Page
     */
    public function index()
    {
        checkPermission('admin_panel');
        $data['title'] = trans("index");
        $data['latestComments'] = $this->commonModel->getLatestComments(1, 5);
        $data['latestPendingComments'] = $this->commonModel->getLatestComments(0, 5);
        $data['latestContactMessages'] = $this->commonModel->getContactMessages(5);
        $data['latestUsers'] = $this->authModel->getLatestUsers();
        $data['postsCount'] = $this->postAdminModel->getPostsCount();
        $data['pendingPostsCount'] = $this->postAdminModel->getPendingPostsCount();
        $data['draftsCount'] = $this->postAdminModel->getDraftsCount();
        $data['scheduledPostsCount'] = $this->postAdminModel->getScheduledPostsCount();

        $this->commonModel->fixNullRecords();

        echo view('admin/includes/_header', $data);
        echo view('admin/index', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Navigation
     */
    public function navigation()
    {
        checkPermission('navigation');
        $data["selectedLang"] = inputGet("lang");
        if (empty($data["selectedLang"])) {
            $data["selectedLang"] = $this->activeLang->id;
            return redirect()->to(adminUrl('navigation?lang=' . $data["selectedLang"]));
        }
        $data['title'] = trans("navigation");
        $data['menuLinks'] = $this->pageModel->getMenuLinks($data["selectedLang"]);

        echo view('admin/includes/_header', $data);
        echo view('admin/navigation/navigation', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Menu Link Post
     */
    public function addMenuLinkPost()
    {
        checkPermission('navigation');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->pageModel->addLink()) {
                $this->session->setFlashdata('success', trans("msg_added"));
                resetCacheDataOnChange();
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->back()->withInput();
            }
        }
        return redirect()->to(adminUrl('navigation?lang=' . $this->activeLang->id));
    }

    /**
     * Update Menu Link
     */
    public function editMenuLink($id)
    {
        checkPermission('navigation');
        $data['title'] = trans("navigation");
        $data['page'] = $this->pageModel->getPageById($id);
        if (empty($data['page'])) {
            return redirect()->to(adminUrl('navigation'));
        }
        $data['menuLinks'] = $this->pageModel->getMenuLinks($data["page"]->lang_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/navigation/edit_link', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Menü Link Post
     */
    public function editMenuLinkPost()
    {
        checkPermission('navigation');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->pageModel->editLink($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
                resetCacheDataOnChange();
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('navigation?lang=' . $this->activeLang->id));
    }

    /**
     * Sort Menu Items
     */
    public function sortMenuItems()
    {
        checkPermission('navigation');
        $this->pageModel->sortMenuItems();
    }

    /**
     * Hide Show Home Link
     */
    public function hideShowHomeLink()
    {
        checkPermission('navigation');
        $this->pageModel->hideShowHomeLink();
    }

    /**
     * Delete Navigation Post
     */
    public function deleteNavigationPost()
    {
        if (!checkUserPermission('navigation')) {
            exit();
        }
        $id = inputPost('id');
        $data["page"] = $this->pageModel->getPageById($id);
        if (!empty($data['page'])) {
            if (!empty($this->pageModel->getSubpages($id))) {
                $this->session->setFlashdata('error', trans("msg_delete_subpages"));
                exit();
            }
            if ($this->pageModel->deletePage($id)) {
                $this->session->setFlashdata('success', trans("msg_deleted"));
                resetCacheDataOnChange();
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Menu Limit Post
     */
    public function menuLimitPost()
    {
        checkPermission('navigation');
        if ($this->pageModel->updateMenuLimit()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->back();
    }

    /**
     * Themes
     */
    public function themes()
    {
        checkAdmin();
        $data['title'] = trans("themes");
        $data['themes'] = $this->settingsModel->getThemes();

        echo view('admin/includes/_header', $data);
        echo view('admin/themes', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Set Theme Post
     */
    public function setThemePost()
    {
        checkAdmin();
        $this->settingsModel->setTheme();
        return redirect()->to(adminUrl('themes'));
    }

    /**
     * Set Theme Settings Post
     */
    public function setThemeSettingsPost()
    {
        checkAdmin();
        $this->settingsModel->setThemeSettings();
        return redirect()->to(adminUrl('themes'));
    }

    /**
     * Pages
     */
    public function pages()
    {
        checkPermission('pages');
        $data['title'] = trans("pages");

        $data['pages'] = $this->pageModel->getPages();
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/page/pages', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Page
     */
    public function addPage()
    {
        checkPermission('pages');
        $data['title'] = trans("add_page");
        $data['menuLinks'] = $this->pageModel->getMenuLinks($this->activeLang->id);

        echo view('admin/includes/_header', $data);
        echo view('admin/page/add', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Page Post
     */
    public function addPagePost()
    {
        checkPermission('pages');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->pageModel->addPage()) {
                resetCacheDataOnChange();
                $this->session->setFlashdata('success', trans("msg_added"));
                return redirect()->back();
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Edit Page
     */
    public function editPage($id)
    {
        checkPermission('pages');
        $data['title'] = trans("update_page");
        $data['page'] = $this->pageModel->getPageById($id);
        if (empty($data['page'])) {
            return redirect()->back();
        }
        $data['menuLinks'] = $this->pageModel->getMenuLinks($data['page']->lang_id);

        echo view('admin/includes/_header', $data);
        echo view('admin/page/edit', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Page Post
     */
    public function editPagePost()
    {
        checkPermission('pages');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            $redirectUrl = inputPost('redirect_url');
            if ($this->pageModel->editPage($id)) {
                resetCacheDataOnChange();
                $this->session->setFlashdata('success', trans("msg_updated"));
                if (!empty($redirectUrl)) {
                    return redirect()->to($redirectUrl);
                }
                return redirect()->to(adminUrl('pages'));
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->back()->withInput();
    }

    /**
     * Delete Page Post
     */
    public function deletePagePost()
    {
        checkPermission('pages');
        $id = inputPost('id');
        $page = $this->pageModel->getPageById($id);
        if (!empty($page)) {
            if ($page->is_custom == 0) {
                $this->session->setFlashdata('error', trans("msg_page_delete"));
                exit();
            } else {
                if (countItems($this->pageModel->getSubpages($id)) > 0) {
                    $this->session->setFlashdata('error', trans("msg_delete_subpages"));
                }
                if ($this->pageModel->deletePage($id)) {
                    resetCacheDataOnChange();
                    $this->session->setFlashdata('success', trans("msg_deleted"));
                } else {
                    $this->session->setFlashdata('error', trans("msg_error"));
                }
            }
        }
    }

    //get menu links by language
    public function getMenuLinksByLang()
    {
        $langId = inputPost('lang_id');
        if (!empty($langId)) {
            $menuLinks = $this->pageModel->getMenuLinks($langId);
            if (!empty($menuLinks)) {
                foreach ($menuLinks as $item) {
                    if ($item["type"] != "category" && $item["location"] == "main" && $item['parent_id'] == "0") {
                        echo ' <option value="' . $item["id"] . '">' . $item["title"] . '</option>';
                    }
                }
            }
        }
    }

    /**
     * Add Widget
     */
    public function addWidget()
    {
        checkPermission('widgets');
        $data['title'] = trans("add_widget");
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->getParentCategories();

        echo view('admin/includes/_header', $data);
        echo view('admin/widget/add', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Widgets
     */
    public function widgets()
    {
        checkPermission('widgets');
        $data['title'] = trans("widgets");

        $data['widgets'] = $this->settingsModel->getWidgets();
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/widget/widgets', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Widget Post
     */
    public function addWidgetPost()
    {
        checkPermission('widgets');
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('add-widget'))->withInput();
        } else {
            if ($this->settingsModel->addWidget()) {
                $this->session->setFlashdata('success', trans("msg_added"));
                resetCacheDataOnChange();
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('add-widget'));
    }

    /**
     * Edit Widget
     */
    public function editWidget($id)
    {
        checkPermission('widgets');
        $data['title'] = trans("update_widget");
        $data['widget'] = $this->settingsModel->getWidget($id);
        if (empty($data['widget'])) {
            return redirect()->to(adminUrl('widgets'));
        }
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->getParentCategories();

        echo view('admin/includes/_header', $data);
        echo view('admin/widget/edit', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Widget Post
     */
    public function editWidgetPost()
    {
        checkPermission('widgets');
        $id = cleanNumber(inputPost('id'));
        $val = \Config\Services::validation();
        $val->setRule('title', trans("title"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            redirectToBackURL();
        } else {
            if ($this->settingsModel->editWidget($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
                resetCacheDataOnChange();
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->to(adminUrl('edit-widget/' . $id))->withInput();
            }
        }
        redirectToBackURL();
    }

    /**
     * Delete Widget Post
     */
    public function deleteWidgetPost()
    {
        checkPermission('widgets');
        $id = inputPost('id');
        $widget = $this->settingsModel->getWidget($id);
        if ($widget->is_custom == 0) {
            $lang = getLanguage($widget->lang_id);
            if (!empty($lang)) {
                $this->session->setFlashdata('error', trans("msg_widget_delete"));
            }
        } else {
            if ($this->settingsModel->deleteWidget($id)) {
                $this->session->setFlashdata('success', trans("msg_deleted"));
                resetCacheDataOnChange();
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Polls
     */
    public function polls()
    {
        checkPermission('polls');
        $data['title'] = trans("polls");
        $pollModel = new PollModel();

        $data['polls'] = $pollModel->getPolls();
        $data['langSearchColumn'] = 2;

        echo view('admin/includes/_header', $data);
        echo view('admin/poll/polls', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Poll
     */
    public function addPoll()
    {
        checkPermission('polls');
        $data['title'] = trans("add_poll");

        echo view('admin/includes/_header', $data);
        echo view('admin/poll/add', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Poll Post
     */
    public function addPollPost()
    {
        checkPermission('polls');
        $val = \Config\Services::validation();
        $val->setRule('question', trans("question"), 'required');
        $val->setRule('option1', trans("option_1"), 'required');
        $val->setRule('option2', trans("option_2"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('add-poll'))->withInput();
        } else {
            $pollModel = new PollModel();
            if ($pollModel->addPoll()) {
                $this->session->setFlashdata('success', trans("msg_added"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('add-poll'));
    }

    /**
     * Edit Poll
     */
    public function editPoll($id)
    {
        checkPermission('polls');
        $data['title'] = trans("update_poll");
        $pollModel = new PollModel();
        $data['poll'] = $pollModel->getPoll($id);
        if (empty($data['poll'])) {
            return redirect()->to(adminUrl('polls'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/poll/edit', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Poll Post
     */
    public function editPollPost()
    {
        checkPermission('polls');
        $id = cleanNumber(inputPost('id'));
        $val = \Config\Services::validation();
        $val->setRule('question', trans("question"), 'required');
        $val->setRule('option1', trans("option_1"), 'required');
        $val->setRule('option2', trans("option_2"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('edit-poll/' . $id))->withInput();
        } else {
            $pollModel = new PollModel();
            if ($pollModel->editPoll($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->to(adminUrl('edit-poll/' . $id))->withInput();
            }
        }
        return redirect()->to(adminUrl('polls'));
    }

    /**
     * Delete Poll Post
     */
    public function deletePollPost()
    {
        checkPermission('polls');
        $id = inputPost('id');
        $pollModel = new PollModel();
        $poll = $pollModel->getPoll($id);
        if (!empty($poll)) {
            if ($pollModel->deletePoll($id)) {
                $this->session->setFlashdata('success', trans("msg_deleted"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Contact Messages
     */
    public function contactMessages()
    {
        checkPermission('comments_contact');
        $data['title'] = trans("contact_messages");

        $data['messages'] = $this->commonModel->getContactMessages();

        echo view('admin/includes/_header', $data);
        echo view('admin/contact_messages', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Delete Contact Message Post
     */
    public function deleteContactMessagePost()
    {
        if (!checkUserPermission('comments_contact')) {
            exit();
        }
        $id = inputPost('id');
        if ($this->commonModel->deleteContactMessage($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Contact Messages
     */
    public function deleteSelectedContactMessages()
    {
        if (!checkUserPermission('comments_contact')) {
            exit();
        }
        $this->commonModel->deleteMultiMessages();
    }

    /**
     * Comments
     */
    public function comments()
    {
        checkPermission('comments_contact');
        $data['title'] = trans("approved_comments");
        $data['topButtonText'] = trans("pending_comments");

        $data['topButtonURL'] = adminUrl('pending-comments');
        $data['showApproveButton'] = false;

        $numRows = $this->commonModel->getCommentsCount(1);
        $pager = paginate(30, $numRows);
        $data['comments'] = $this->commonModel->getCommentsPaginated(1, 30, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/comments', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Pending Comments
     */
    public function pendingComments()
    {
        checkPermission('comments_contact');
        $data['title'] = trans("pending_comments");

        $data['topButtonText'] = trans("approved_comments");
        $data['topButtonURL'] = adminUrl('comments');
        $data['showApproveButton'] = true;

        $numRows = $this->commonModel->getCommentsCount(0);
        $pager = paginate(30, $numRows);
        $data['comments'] = $this->commonModel->getCommentsPaginated(0, 30, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/comments', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Aprrove Comment Post
     */
    public function approveCommentPost()
    {
        checkPermission('comments_contact');
        $id = inputPost('id');
        if ($this->commonModel->approveComment($id)) {
            $this->session->setFlashdata('success', trans("msg_comment_approved"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('pending-comments'));
    }


    /**
     * Delete Comment Post
     */
    public function deleteCommentPost()
    {
        if (!checkUserPermission('comments_contact')) {
            exit();
        }
        $id = inputPost('id');
        if ($this->commonModel->deleteComment($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Approve Selected Comments
     */
    public function approveSelectedComments()
    {
        if (!checkUserPermission('comments_contact')) {
            exit();
        }
        $this->commonModel->approveMultiComments();
    }

    /**
     * Delete Selected Comments
     */
    public function deleteSelectedComments()
    {
        if (!checkUserPermission('comments_contact')) {
            exit();
        }
        $this->commonModel->deleteMultiComments();
    }

    /**
     * Newsletter
     */
    public function newsletter()
    {
        checkPermission('newsletter');
        $data['title'] = trans("newsletter");

        $data['subscribers'] = $this->newsletterModel->getSubscribers();
        $data['users'] = $this->authModel->getAllUsers();

        echo view('admin/includes/_header', $data);
        echo view('admin/newsletter/newsletter', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Send Email
     */
    public function newsletterSendEmail()
    {
        checkPermission('newsletter');
        $data['title'] = trans("newsletter");
        $data['emails'] = inputPost('email');
        $data['submit'] = inputPost('submit');
        if (empty($data['emails'])) {
            $this->session->setFlashdata('error', trans("newsletter_email_error"));
            return redirect()->to(adminUrl('newsletter'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/newsletter/send_email', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Send Email Post
     */
    public function newsletterSendEmailPost()
    {
        checkPermission('newsletter');
        if (@$this->newsletterModel->sendEmail()) {
            echo json_encode(['result' => 1]);
            exit();
        }
        echo json_encode(['result' => 0]);
    }

    /**
     * Newsletter Settings Post
     */
    public function newsletterSettingsPost()
    {
        checkPermission('newsletter');
        if ($this->newsletterModel->updateSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('newsletter'));
    }

    /**
     * Delete Subscriber Post
     */
    public function deleteSubscriberPost()
    {
        if (!checkUserPermission('newsletter')) {
            exit();
        }
        $id = inputPost('id');
        if ($this->newsletterModel->deleteSubscriber($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Ads
     */
    public function adSpaces()
    {
        checkPermission('ad_spaces');
        $data['title'] = trans("ad_spaces");
        $data['adSpaceKey'] = inputGet('ad_space');
        $data['langId'] = inputGet('lang');
        if (empty($data['adSpaceKey'])) {
            $data['adSpaceKey'] = 'header';
        }

        $lang = getLanguage($data['langId']);
        if (empty($lang)) {
            $data['langId'] = $this->activeLang->id;
        }
        $data['adSpace'] = $this->commonModel->getAdSpace($data['langId'], $data['adSpaceKey']);
        if (empty($data['adSpace'])) {
            return redirect()->to(adminUrl('ad-spaces'));
        }
        $data['arrayAdSpaces'] = [
            'header' => trans('ad_space_header'),
            'index_top' => trans('ad_space_index_top'),
            'index_bottom' => trans('ad_space_index_bottom'),
            'post_top' => trans('ad_space_post_top'),
            'post_bottom' => trans('ad_space_post_bottom'),
            'posts_top' => trans('ad_space_posts_top'),
            'posts_bottom' => trans('ad_space_posts_bottom'),
            'sidebar_1' => trans('sidebar') . '-1',
            'sidebar_2' => trans('sidebar') . '-2',
            'in_article_1' => trans('ad_space_in_article') . '-1',
            'in_article_2' => trans('ad_space_in_article') . '-2'
        ];
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->getParentCategoriesByLang($data['langId']);

        echo view('admin/includes/_header', $data);
        echo view('admin/ad_spaces', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Ad Spaces Post
     */
    public function adSpacesPost()
    {
        checkPermission('ad_spaces');
        $id = inputPost('id');
        if ($this->commonModel->updateAdSpaces($id)) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        redirectToBackURL();
    }

    /**
     * Google Adsense Code Post
     */
    public function googleAdsenseCodePost()
    {
        if ($this->commonModel->updateGoogleAdsenseCode()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('ad-spaces'));
    }

    /**
     * Users
     */
    public function users()
    {
        checkPermission('users');
        $data['title'] = trans("users");

        $numRows = $this->authModel->getUsersCount();
        $pager = paginate($this->perPage, $numRows);
        $data['users'] = $this->authModel->getUsersPaginated($this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/users/users');
        echo view('admin/includes/_footer');
    }

    /**
     * Administrators
     */
    public function administrators()
    {
        checkAdmin();
        $data['title'] = trans("administrators");
        $data['users'] = $this->authModel->getAdministrators();


        echo view('admin/includes/_header', $data);
        echo view('admin/users/administrators');
        echo view('admin/includes/_footer');
    }

    /**
     * Add User
     */
    public function addUser()
    {
        checkAdmin();
        $data['title'] = trans("add_user");
        $data['roles'] = $this->authModel->getRolesPermissions();

        echo view('admin/includes/_header', $data);
        echo view('admin/users/add_user');
        echo view('admin/includes/_footer');
    }

    /**
     * Add User Post
     */
    public function addUserPost()
    {
        checkAdmin();
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|max_length[255]');
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('add-user'))->withInput();
        } else {
            $id = inputPost('id');
            $email = inputPost('email');
            $username = inputPost('username');
            $slug = inputPost('slug');
            if (!$this->authModel->isUniqueUsername($username, $id)) {
                $this->session->setFlashdata('error', trans("msg_username_unique_error"));
                return redirect()->to(adminUrl('add-user'))->withInput();
            }
            if (!$this->authModel->isEmailUnique($email, $id)) {
                $this->session->setFlashdata('error', trans("message_email_unique_error"));
                return redirect()->to(adminUrl('add-user'))->withInput();
            }
            if ($this->authModel->isSlugUnique($slug, $id)) {
                $this->session->setFlashdata('error', trans("msg_slug_used"));
                return redirect()->to(adminUrl('add-user'))->withInput();
            }
            if ($this->authModel->addUser($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->to(adminUrl('add-user'))->withInput();
            }
        }
        return redirect()->to(adminUrl('add-user'));
    }

    /**
     * Edit User
     */
    public function editUser($id)
    {
        checkPermission('users');
        $data['title'] = trans("update_profile");
        $data['user'] = getUserById($id);
        if (empty($data['user'])) {
            return redirect()->to(adminUrl('users'));
        }
        if ($data['user']->role == 'admin' && user()->role != 'admin') {
            return redirect()->to(adminUrl('users'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/users/edit_user');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit User Post
     */
    public function editUserPost()
    {
        checkPermission('users');
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|max_length[255]');
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back();
        } else {
            $id = inputPost('id');
            $email = inputPost('email');
            $username = inputPost('username');
            $slug = inputPost('slug');
            if (!$this->authModel->isEmailUnique($email, $id)) {
                $this->session->setFlashdata('error', trans("message_email_unique_error"));
                return redirect()->back();
            }
            if (!$this->authModel->isUniqueUsername($username, $id)) {
                $this->session->setFlashdata('error', trans("msg_username_unique_error"));
                return redirect()->back();
            }
            if ($this->authModel->isSlugUnique($slug, $id)) {
                $this->session->setFlashdata('error', trans("msg_slug_used"));
                return redirect()->back();
            }
            if ($this->authModel->editUser($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('edit-user/' . cleanNumber($id)));
    }

    /**
     * Change User Role
     */
    public function changeUserRolePost()
    {
        checkPermission('users');
        $id = inputPost('user_id');
        $role = inputPost('role');
        $user = getUserById($id);
        if (empty($user)) {
            return redirect()->to(adminUrl('users'));
        }
        if ($this->authModel->changeUserRole($id, $role)) {
            $this->session->setFlashdata('success', trans("msg_role_changed"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('users'));
    }

    /**
     * User Options Post
     */
    public function userOptionsPost()
    {
        checkPermission('users');
        $id = inputPost('id');
        $submit = inputPost('submit');
        $backURL = inputPost('back_url');
        $user = getUserById($id);
        if (!empty($user)) {
            if ($submit == 'reward_system') {
                $rewardModel = new RewardModel();
                if ($rewardModel->enableDisableRewardSystem($user)) {
                    $this->session->setFlashdata('success', trans("msg_updated"));
                } else {
                    $this->session->setFlashdata('error', trans("msg_error"));
                }
            } elseif ($submit == 'confirm_email') {
                if ($this->authModel->verifyEmail($user)) {
                    $this->session->setFlashdata('success', trans("msg_updated"));
                } else {
                    $this->session->setFlashdata('error', trans("msg_error"));
                }
            } elseif ($submit == 'ban_user') {
                if ($this->authModel->banUser($user)) {
                    $this->session->setFlashdata('success', trans("msg_updated"));
                } else {
                    $this->session->setFlashdata('error', trans("msg_error"));
                }
            }
        }
        if (!empty($backURL)) {
            return redirect()->to(adminUrl($backURL));
        }
        return redirect()->to(adminUrl('users'));
    }

    /**
     * Delete User Post
     */
    public function deleteUserPost()
    {
        if (!checkUserPermission('users')) {
            exit();
        }
        $id = inputPost('id');
        $user = getUserById($id);
        if (!empty($user) && $user->id == 1) {
            $this->session->setFlashdata('error', trans("msg_error"));
            exit();
        }
        if ($this->authModel->deleteUser($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Roles Permissions
     */
    public function rolesPermissions()
    {
        checkAdmin();
        $data['title'] = trans("roles_permissions");
        $data['roles'] = $this->authModel->getRolesPermissions();

        echo view('admin/includes/_header', $data);
        echo view('admin/users/roles_permissions');
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Role
     */
    public function editRole($id)
    {
        checkAdmin();
        $data['title'] = trans("edit_role");
        $data['role'] = $this->authModel->getRole($id);
        if (empty($data['role'])) {
            return redirect()->to(adminUrl('roles-permissions'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/users/edit_role', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Role Post
     */
    public function editRolePost()
    {
        checkAdmin();
        $id = inputPost('id');
        if ($this->authModel->editRole($id)) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('roles-permissions'));
    }

    /**
     * Seo Tools
     */
    public function seoTools()
    {
        checkPermission('seo_tools');
        $data['title'] = trans("seo_tools");
        $data["selectedLangId"] = inputGet('lang');
        if (empty($data["selectedLangId"])) {
            $data["selectedLangId"] = $this->activeLang->id;
        }
        $data['seoSettings'] = $this->settingsModel->getSettings($data["selectedLangId"]);

        echo view('admin/includes/_header', $data);
        echo view('admin/seo_tools', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Seo Tools Post
     */
    public function seoToolsPost()
    {
        checkPermission('seo_tools');
        $langId = inputPost('lang_id');
        if ($this->settingsModel->updateSeoSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('seo-tools?lang=' . cleanNumber($langId)));
    }

    /**
     * Generate Sitemap Post
     */
    public function generateSitemapPost()
    {
        $model = new SitemapModel();
        $model->updateSitemapSettings();
        $model->generateSitemap();
        $this->session->setFlashdata('success', trans("msg_updated"));
        return redirect()->back();
    }

    /**
     * Delete Sitemap Post
     */
    public function deleteSitemapPost()
    {
        $fileName = inputPost('file_name');
        if (!empty($fileName)) {
            $fileName = basename($fileName);
            if (file_exists(FCPATH . $fileName)) {
                @unlink(FCPATH . $fileName);
            }
        }
        return redirect()->back();
    }

    /**
     * Storage
     */
    public function storage()
    {
        $data['title'] = trans("storage");

        echo view('admin/includes/_header', $data);
        echo view('admin/storage', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Storage Post
     */
    public function storagePost()
    {
        if ($this->settingsModel->updateStorageSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('storage'));
    }

    /**
     * AWS S3 Post
     */
    public function awsS3Post()
    {
        if ($this->settingsModel->updateAwsS3()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('storage'));
    }

    /**
     * Cache System
     */
    public function cacheSystem()
    {
        checkAdmin();
        $data['title'] = trans("cache_system");

        echo view('admin/includes/_header', $data);
        echo view('admin/cache_system', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Cache System Post
     */
    public function cacheSystemPost()
    {
        checkAdmin();
        if (inputPost('action') == 'reset') {
            resetCacheData();
            $this->session->setFlashdata('success', trans("msg_reset_cache"));
        } else {
            if ($this->settingsModel->updateCacheSystem()) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('cache-system'));
    }

    /**
     * Google News
     */
    public function googleNews()
    {
        checkAdmin();
        $data['title'] = trans("google_news");
        $data['users'] = $this->authModel->getActiveUsers();
        echo view('admin/includes/_header', $data);
        echo view('admin/google_news', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Google News Post
     */
    public function googleNewsPost()
    {
        if ($this->settingsModel->updateGoogleNews()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('google-news'));
    }

    /**
     * Preferences
     */
    public function preferences()
    {
        checkPermission('settings');
        $data['title'] = trans("preferences");

        echo view('admin/includes/_header', $data);
        echo view('admin/settings/preferences', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Preferences Post
     */
    public function preferencesPost()
    {
        checkPermission('settings');
        $form = inputPost('submit');
        if ($this->settingsModel->updatePreferences($form)) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('preferences?tab=' . cleanStr($form)));
    }

    /**
     * File Upload Settings Post
     */
    public function fileUploadSettingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateFileUploadSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('preferences'));
    }

    /**
     * Route Settings
     */
    public function routeSettings()
    {
        checkAdmin();
        $data['title'] = trans("route_settings");
        $data['routes'] = $this->settingsModel->getRoutes();

        echo view('admin/includes/_header', $data);
        echo view('admin/settings/route_settings', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Route Settings Post
     */
    public function routeSettingsPost()
    {
        checkAdmin();
        if ($this->settingsModel->updateRouteSettings()) {
            $routes = $this->settingsModel->getRoutes();
            $this->session->setFlashdata('success', trans("msg_updated"));
            return redirect()->to(base_url($routes->admin . "/route-settings"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('route-settings'));
    }

    /**
     * Email Settings
     */
    public function emailSettings()
    {
        checkPermission('settings');
        $data['title'] = trans("email_settings");
        $data['service'] = inputGet('service');
        $data['protocol'] = inputGet('protocol');
        if (empty($data['service'])) {
            $data['service'] = $this->generalSettings->mail_service;
        }
        if ($data['service'] != 'swift' && $data['service'] != 'php' && $data['service'] != 'mailjet') {
            $data['service'] = 'swift';
        }
        if (empty($data['protocol'])) {
            $data['protocol'] = $this->generalSettings->mail_protocol;
        }
        if ($data['protocol'] != 'smtp' && $data['protocol'] != 'mail') {
            $data['protocol'] = 'smtp';
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/settings/email_settings', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Email Settings Post
     */
    public function emailSettingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateEmailSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('email-settings'));
    }

    /**
     * Update Contact Email Settings Post
     */
    public function contactEmailSettingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateContactEmailSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('email-settings'));
    }

    /**
     * Update Email Verification Settings Post
     */
    public function emailVerificationSettingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->emailVerificationSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('email-settings'));
    }

    /**
     * Send Test Email Post
     */
    public function sendTestEmailPost()
    {
        checkPermission('settings');
        $email = inputPost('email');
        $email = inputPost('email');
        $subject = $this->settings->application_name . " Test Email";
        $message = "<p>This is a test email. This e-mail is sent to your e-mail address for test purpose only. If you have received this e-mail, your e-mail system is working.</p>";
        $emailModel = new EmailModel();
        if (!empty($email)) {
            if (!$emailModel->sendTestEmail($email, $subject, $message)) {
                return redirect()->to(adminUrl('email-settings'));
            }
            $this->session->setFlashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('email-settings'));
    }

    /**
     * Font Settings
     */
    public function fontSettings()
    {
        checkPermission('settings');
        $data["selectedLangId"] = cleanNumber(inputGet('lang'));
        if (empty($data["selectedLangId"])) {
            $data["selectedLangId"] = $this->activeLang->id;
        }

        $data['title'] = trans("font_settings");
        $data['fonts'] = $this->settingsModel->getFonts();

        echo view('admin/includes/_header', $data);
        echo view('admin/font/fonts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Set Site Font Post
     */
    public function setSiteFontPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->setDefaultFonts()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('font-settings'));
    }

    /**
     * Add Font Post
     */
    public function addFontPost()
    {
        checkPermission('settings');
        $val = \Config\Services::validation();
        $val->setRule('font_name', trans("name"), 'required|max_length[255]');
        $val->setRule('font_family', trans("font_family"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if ($this->settingsModel->addFont()) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('font-settings'));
    }

    /**
     * Edit Font
     */
    public function editFont($id)
    {
        checkPermission('settings');
        $data['title'] = trans("update_font");
        $data['font'] = $this->settingsModel->getFont($id);
        if (empty($data['font'])) {
            return redirect()->to(adminUrl('font-settings'));
        }

        echo view('admin/includes/_header', $data);
        echo view('admin/font/edit', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Edit Font Post
     */
    public function editFontPost()
    {
        checkPermission('settings');
        $val = \Config\Services::validation();
        $val->setRule('font_name', trans("name"), 'required|max_length[255]');
        $val->setRule('font_family', trans("font_family"), 'required|max_length[500]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $id = inputPost('id');
            if ($this->settingsModel->editFont($id)) {
                $this->session->setFlashdata('success', trans("msg_updated"));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
            }
        }
        return redirect()->to(adminUrl('font-settings'));
    }

    /**
     * Delete Font Post
     */
    public function deleteFontPost()
    {
        checkPermission('settings');
        $id = inputPost('id');
        if ($this->settingsModel->deleteFont($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Social Login Configuration
     */
    public function socialLoginSettings()
    {
        checkPermission('settings');
        $data['title'] = trans("social_login_settings");


        echo view('admin/includes/_header', $data);
        echo view('admin/social_login', $data);
        echo view('admin/includes/_footer');
    }


    /**
     * Social Login Facebook Post
     */
    public function socialLoginSettingsPost()
    {
        checkPermission('settings');
        if ($this->settingsModel->updateSocialSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('social-login-settings'));
    }

    /**
     * General Settings
     */
    public function generalSettings()
    {
        checkPermission('settings');
        $data["settingsLangId"] = cleanNumber(inputGet("lang"));
        if (empty($data["settingsLangId"])) {
            $data["settingsLangId"] = $this->activeLang->id;
            return redirect()->to(adminUrl('general-settings?lang=' . $data["settingsLangId"]));
        }

        $data['title'] = trans("settings");
        $data['settings'] = $this->settingsModel->getSettings($data["settingsLangId"]);

        echo view('admin/includes/_header', $data);
        echo view('admin/settings/general_settings', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Settings Post
     */
    public function generalSettingsPost()
    {
        checkPermission('settings');
        $langId = cleanNumber(inputPost('lang_id'));
        $activeTab = cleanNumber(inputPost('active_tab'));
        if (empty($langId)) {
            $langId = $this->activeLang->id;
        }
        if ($this->settingsModel->updateSettings($langId)) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('general-settings?lang=' . $langId . '&tab=' . $activeTab));
    }

    /**
     * Recaptcha Settings Post
     */
    public function recaptchaSettingsPost()
    {
        checkPermission('settings');
        $langId = cleanNumber(inputPost('lang_id'));
        if (empty($langId)) {
            $langId = $this->activeLang->id;
        }
        if ($this->settingsModel->updateRecaptchaSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('general-settings?lang=' . $langId));
    }

    /**
     * Maintenance Mode Post
     */
    public function maintenanceModePost()
    {
        $langId = cleanNumber(inputPost('lang_id'));
        if (empty($langId)) {
            $langId = $this->activeLang->id;
        }
        if ($this->settingsModel->updateMaintenanceModeSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('general-settings?lang=' . $langId));
    }

    /**
     * Control Panel Language Post
     */
    public function setActiveLanguagePost()
    {
        $langId = inputPost('lang_id');
        $languageModel = new LanguageModel();
        $language = $languageModel->getLanguage($langId);
        if (!empty($language)) {
            $this->session->set('vr_control_panel_lang', $language->id);
        }
        redirectToBackURL();
    }

    /**
     * Download Database Backup
     */
    public function downloadDatabaseBackup()
    {
        checkAdmin();
        $response = \Config\Services::response();
        $data = $this->settingsModel->downloadBackup();
        $name = 'db_backup-' . date('Y-m-d H-i-s') . '.sql';
        return $response->download($name, $data);
    }
}
