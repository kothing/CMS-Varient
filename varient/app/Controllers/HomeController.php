<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CategoryModel;
use App\Models\CommonModel;
use App\Models\GalleryModel;
use App\Models\PageModel;
use App\Models\PostAdminModel;
use App\Models\PostItemModel;
use App\Models\QuizModel;
use App\Models\ReactionModel;
use App\Models\RssModel;
use App\Models\TagModel;
use App\Models\UploadModel;
use Config\Globals;


class HomeController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->postsPerPage = $this->generalSettings->pagination_per_page;
    }

    public function index()
    {
        $data['title'] = $this->settings->home_title;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['homeTitle'] = $this->settings->home_title;

        $data['latestPosts'] = getLatestPosts(POST_NUM_LOAD_MORE + 2);
        $data['sliderPosts'] = $this->latestCategoryPosts;
        $data['featuredPosts'] = $this->latestCategoryPosts;
        
        //slider posts
        if ($this->generalSettings->show_latest_posts_on_slider != 1) {
            $data['sliderPosts'] = getSliderPosts();
        }
        //feature posts
        if ($this->generalSettings->show_latest_posts_on_featured != 1) {
            $data['featuredPosts'] = getFeaturedPosts();
        }
        //breaking news
        $data['breakingNews'] = getBreakingNews();
        $data['limitLoadMorePosts'] = POST_NUM_LOAD_MORE;

        echo loadView('partials/_header', $data);
        echo loadView('index', $data);
        echo loadView('partials/_footer', $data);
    }

    /**
     * Posts Page
     */
    public function posts()
    {
        $data['title'] = trans("posts");
        $data['description'] = trans("posts") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("posts") . "," . $this->settings->application_name;
        
        $numRows = getCachedData('posts_count');
        if (empty($numRows)) {
            $numRows = $this->postModel->getPostCount();
            setCacheData('posts_count', $numRows);
        }
        $pager = paginate($this->postsPerPage, $numRows);
        $cacheKey = 'posts_page_' . $pager->getCurrentPage();
        $data['posts'] = getCachedData($cacheKey);
        if (empty($data['posts'])) {
            $data['posts'] = $this->postModel->getPostsPaginated($this->postsPerPage, $pager->offset);
            setCacheData($cacheKey, $data['posts']);
        }

        echo loadView('partials/_header', $data);
        echo loadView('post/posts', $data);
        echo loadView('partials/_footer', $data);
    }

    /**
     * Dynamic URL by Slug
     */
    public function any($slug)
    {
        $slug = cleanSlug($slug);
        if (empty($slug)) {
            return redirect()->to(langBaseUrl());
        }
        $pageModel = new PageModel();
        
        $page = $pageModel->getPageByLang($slug, $this->activeLang->id);
        if (!empty($page)) {
            $this->page($page);
        } else {
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getCategoryBySlug($slug);
            if (!empty($category)) {
                $this->category($category);
            } else {
                $post = $this->postModel->getPostBySlug($slug);
                if (!empty($post)) {
                    $this->post($post);
                } else {
                    $this->error404();
                }
            }
        }
    }

    /**
     * Post
     */
    private function post($post, $pageNumber = null)
    {
        if (empty($post)) {
            return redirect()->to(langBaseUrl());
        }
        //check post auth
        if (!authCheck() && $post->need_auth == 1) {
            $this->session->setFlashdata('error', trans("message_post_auth"));
            redirectToUrl(generateURL('register'));
            exit();
        }
        
        $data['post'] = $post;
        $data['postJsonLD'] = $post;
        $data['postUser'] = getUserById($post->user_id);
        $tagModel = new TagModel();
        $data['postTags'] = $tagModel->getPostTags($post->id);
        $postAdminModel = new PostAdminModel();
        $data['postImages'] = $postAdminModel->getAdditionalImages($post->id);
        $data['comments'] = $this->commonModel->getComments($post->id, COMMENT_LIMIT);
        $data['commentLimit'] = COMMENT_LIMIT;
        $data['relatedPosts'] = $this->postModel->getRelatedPosts($post->category_id, $post->id, $this->categories);
        $data['previousPost'] = $this->postModel->getPreviousPost($post->id);
        $data['nextPost'] = $this->postModel->getNextPost($post->id);
        $data['postType'] = $post->post_type;
        if (!empty($post->feed_id)) {
            $rssModel = new RssModel();
            $data['feed'] = $rssModel->getFeed($post->feed_id);
        }
        $data = setPostMetaTags($post, $data['postTags'], $data);
        $reactionModel = new ReactionModel();
        $data['reactions'] = $reactionModel->getReaction($post->id);
        //gallery post
        if ($post->post_type == 'gallery') {
            if ($pageNumber == null || empty($pageNumber)) {
                $pageNumber = 1;
            }
            $postItemModel = new PostItemModel();
            $data['galleryPostNumRows'] = $postItemModel->getPostListItemsCount($post->id, $post->post_type);
            $data['galleryPostItem'] = $postItemModel->getGalleryPostItemByOrder($post->id, $pageNumber);
            $data['pageNumber'] = $pageNumber;
            if ($pageNumber < 1 || $pageNumber > $data['galleryPostNumRows']) {
                redirectToUrl(generatePostURL($post));
                exit();
            }
        }
        //sorted list post
        if ($post->post_type == 'sorted_list') {
            $postItemModel = new PostItemModel();
            $data['sortedListItems'] = $postItemModel->getPostListItems($post->id, $post->post_type);
        }
        //quiz
        if ($post->post_type == 'trivia_quiz' || $post->post_type == 'personality_quiz') {
            $quizModel = new QuizModel();
            $data['quizQuestions'] = $quizModel->getQuizQuestions($post->id);
        }

        echo loadView('partials/_header', $data);
        echo loadView('post/post', $data);
        echo loadView('partials/_footer', $data);
        //increase pageviews count
        $this->postModel->increasePostPageviews($post, $data['postUser']);
    }

    /**
     * Gallery Post Page
     */
    public function galleryPost($slug, $pageNumber)
    {
        $post = $this->postModel->getPostBySlug($slug);
        if (empty($post)) {
            return redirect()->to(langBaseUrl());
        }
        $this->post($post, cleanNumber($pageNumber));
    }

    /**
     * Page
     */
    private function page($page)
    {
        if (empty($page)) {
            return redirect()->to(langBaseUrl());
        }
        if ($page->visibility == 0) {
            $this->error404();
        } else {
            $this->checkPageAuth($page);

            $data['title'] = $page->title;
            $data['description'] = $page->description;
            $data['keywords'] = $page->keywords;
            $data['page'] = $page;
            if ($page->page_default_name == 'gallery') {
                $this->gallery($page, $data);
            } elseif ($page->page_default_name == 'contact') {
                echo loadView('partials/_header', $data);
                echo loadView('contact', $data);
                echo loadView('partials/_footer');
            } else {
                echo loadView('partials/_header', $data);
                echo loadView('page', $data);
                echo loadView('partials/_footer');
            }
        }
    }

    /**
     * Category
     */
    private function category($category, $isParent = true)
    {
        if (empty($category)) {
            return redirect()->to(langBaseUrl());
        }
        if ($isParent && $category->parent_id != 0) {
            $this->error404();
        } else {
            $data['title'] = $category->name;
            $data['description'] = $category->description;
            $data['keywords'] = $category->keywords;
            $data['category'] = $category;

            $numRows = getCachedData('post_count_category' . $category->id);
            if (empty($numRows)) {
                $numRows = $this->postModel->getPostCountByCategory($category->id, $this->categories);
                setCacheData('post_count_category', $numRows);
            }
            $pager = paginate($this->postsPerPage, $numRows);
            $cacheKey = 'posts_category_' . $category->id . '_page' . $pager->getCurrentPage();
            $data['posts'] = getCachedData($cacheKey);
            if (empty($data['posts'])) {
                $data['posts'] = $this->postModel->getPostsByCategoryPaginated($category->id, $this->categories, $this->postsPerPage, $pager->offset);
                setCacheData($cacheKey, $data['posts']);
            }

            echo loadView('partials/_header', $data);
            echo loadView('category', $data);
            echo loadView('partials/_footer');
        }
    }

    /**
     * Subcategory
     */
    public function subCategory($parentSlug, $slug)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->getCategoryBySlug($slug);
        if (empty($category)) {
            return redirect()->to(langBaseUrl());
        }
        $this->category($category, false);
    }

    /**
     * Tag
     */
    public function tag($tagSlug)
    {
        $model = new TagModel();
        $data['tag'] = $model->getTag($tagSlug);
        if (empty($data['tag'])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = $data['tag']->tag;
        $data['description'] = trans("tag") . ': ' . $data['tag']->tag;
        $data['keywords'] = trans("tag") . ', ' . $data['tag']->tag;
        
        $numRows = $this->postModel->getPostCountByTag($tagSlug);
        $pager = paginate($this->postsPerPage, $numRows);
        $data['posts'] = $this->postModel->getTagPostsPaginated($tagSlug, $this->postsPerPage, $pager->offset);

        echo loadView('partials/_header', $data);
        echo loadView('tag', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Gallery
     */
    private function gallery($category, $data)
    {
        $model = new GalleryModel();
        $data['galleryAlbums'] = $model->getAlbumsByLang($this->activeLang->id);
        $data['jsPage'] = "gallery";
        

        echo loadView('partials/_header', $data);
        echo loadView('gallery/gallery', $data);
        echo loadView('partials/_footer');
    }


    /**
     * Gallery Album Page
     */
    public function galleryAlbum($id)
    {
        $model = new GalleryModel();
        $pageModel = new PageModel();
        $data['page'] = $pageModel->getPageByDefaultName('gallery', $this->activeLang->id);
        $data['jsPage'] = "gallery";
        if (empty($data['page'])) {
            return redirect()->to(langBaseUrl());
        }
        $this->checkPageAuth($data['page']);
        if ($data['page']->visibility == 0) {
            $this->error404();
        } else {
            $data['title'] = $data['page']->title;
            $data['description'] = $data['page']->description;
            $data['keywords'] = $data['page']->keywords;
            
            $data['album'] = $model->getAlbum($id);
            if (empty($data['album'])) {
                return redirect()->to(generateURL('gallery'));
            }
            $data['galleryImages'] = $model->getImagesByAlbum($data['album']->id);
            $data['galleryCategories'] = $model->getCategoriesByAlbum($data['album']->id);

            echo loadView('partials/_header', $data);
            echo loadView('gallery/gallery_album', $data);
            echo loadView('partials/_footer', $data);
        }
    }

    /**
     * Reading List Page
     */
    public function readingList()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("reading_list");
        $data['description'] = trans("reading_list") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("reading_list") . "," . $this->settings->application_name;
        
        $numRows = $this->postModel->getReadingListPostsCount(user()->id);
        $pager = paginate($this->postsPerPage, $numRows);
        $data['posts'] = $this->postModel->getReadingListPostsPaginated(user()->id, $this->postsPerPage, $pager->offset);

        echo loadView('partials/_header', $data);
        echo loadView('reading_list', $data);
        echo loadView('partials/_footer', $data);
    }

    /**
     * Search Page
     */
    public function search()
    {
        $q = inputGet('q', true);
        if (!empty($q)) {
            $q = strip_tags($q);
        }
        if (empty($q)) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("search") . ': ' . $q;
        $data['description'] = trans("search") . ': ' . $q;
        $data['keywords'] = trans("search") . ', ' . $q;
        $data['q'] = $q;
        $data['searchInContent'] = 0;
        if (!empty(cleanNumber(esc(inputGet('sc'))))) {
            $data['searchInContent'] = 1;
        }
        
        $numRows = $this->postModel->getSearchPostsCount($q, $data['searchInContent']);
        $pager = paginate($this->postsPerPage, $numRows);
        $data['posts'] = $this->postModel->getSearchPostsPaginated($q, $data['searchInContent'], $this->postsPerPage, $pager->offset);

        echo loadView('partials/_header', $data);
        echo loadView('search', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Contact Page Post
     */
    public function contactPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('name', trans("name"), 'required|max_length[200]');
        $val->setRule('email', trans("email"), 'required|valid_email|max_length[200]');
        $val->setRule('message', trans("message"), 'required|max_length[5000]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            if (reCAPTCHA('validate', $this->generalSettings) == 'invalid') {
                $this->session->setFlashdata('error', trans("msg_recaptcha"));
                return redirect()->back()->withInput();
            }
            $model = new CommonModel();
            if ($model->addContactMessage()) {
                $this->session->setFlashdata('success', trans("message_contact_success"));
            } else {
                $this->session->setFlashdata('error', trans("message_contact_error"));
            }
        }
        return redirect()->back();
    }

    /**
     * Preview
     */
    public function preview($slug)
    {
        if (!authCheck() || empty(cleanSlug($slug))) {
            return redirect()->to(langBaseUrl());
        }
        $post = $this->postModel->getPostPreview($slug);
        if (!empty($post)) {
            if (!checkPostOwnership(user()->id)) {
                return redirect()->to(langBaseUrl());
            }
            $this->post($post);
        } else {
            $this->error404();
        }
    }

    /**
     * Rss Feeds
     */
    public function rssFeeds()
    {
        if ($this->generalSettings->show_rss == 1) {
            $data['title'] = trans("rss_feeds");
            $data['description'] = trans("rss_feeds") . " - " . $this->settings->site_title;
            $data['keywords'] = trans("rss_feeds") . "," . $this->settings->application_name;
            
            echo loadView('partials/_header', $data);
            echo loadView('rss/rss_feeds', $data);
            echo loadView('partials/_footer');
        } else {
            $this->error404();
        }
    }

    /**
     * Rss Latest Posts
     */
    public function rssLatestPosts()
    {
        if ($this->generalSettings->show_rss == 1) {
            
            helper('xml');
            $data['feedName'] = $this->settings->site_title . ' - ' . trans("latest_posts");
            $data['encoding'] = 'utf-8';
            $data['feedURL'] = langBaseUrl('rss/latest-posts');
            $data['pageDescription'] = $this->settings->site_title . ' - ' . trans("latest_posts");
            $data['pageLanguage'] = $this->activeLang->short_form;
            $data['creatorEmail'] = '';
            $data['posts'] = $this->postModel->getRSSPosts(null, null, 50);
            header('Content-Type: application/rss+xml; charset=utf-8');
            echo loadView('rss/rss', $data);
        } else {
            $this->error404();
        }
    }

    /**
     * Rss By Category
     */
    public function rssByCategory($slug)
    {
        if ($this->generalSettings->show_rss == 1) {
            $categoryModel = new CategoryModel();
            $category = $categoryModel->getCategoryBySlug($slug);
            if (empty($category)) {
                return redirect()->to(generateURL('rss_feeds'));
            }
            
            helper('xml');
            $data['feedName'] = $this->settings->site_title . ' - ' . trans("title_category") . ': ' . $category->name;
            $data['encoding'] = 'utf-8';
            $data['feedURL'] = langBaseUrl('rss/category/' . $category->name_slug);
            $data['pageDescription'] = $this->settings->site_title . ' - ' . trans("title_category") . ': ' . $category->name;
            $data['pageLanguage'] = $this->activeLang->short_form;
            $data['creatorEmail'] = '';
            $data['posts'] = $this->postModel->getRSSPosts(null, $category->id, 500);
            header('Content-Type: application/rss+xml; charset=utf-8');
            echo loadView('rss/rss', $data);
        } else {
            $this->error404();
        }
    }

    /**
     * Rss By User
     */
    public function rssByUser($slug)
    {
        if ($this->generalSettings->show_rss == 1) {
            $authModel = new AuthModel();
            $user = $authModel->getUserBySlug($slug);
            if (empty($user)) {
                return redirect()->to(generateURL('rss_feeds'));
            }
            
            helper('xml');
            $data['feedName'] = $this->settings->site_title . ' - ' . $user->username;
            $data['encoding'] = 'utf-8';
            $data['feedURL'] = langBaseUrl('rss/author/') . $user->slug;
            $data['pageDescription'] = $this->settings->site_title . " - " . $user->username;
            $data['pageLanguage'] = $this->activeLang->short_form;
            $data['creatorEmail'] = '';
            $data['posts'] = $this->postModel->getRSSPosts($user->id, null, 500);
            header('Content-Type: application/rss+xml; charset=utf-8');
            echo loadView('rss/rss', $data);
        } else {
            $this->error404();
        }
    }

    //check page auth
    private function checkPageAuth($page)
    {
        if (!authCheck() && $page->need_auth == 1) {
            $this->session->setFlashdata('error', trans("message_page_auth"));
            redirectToUrl(langBaseUrl('register'));
            exit();
        }
    }

    //error 404
    public function error404()
    {
        header("HTTP/1.0 404 Not Found");
        $data['title'] = $this->settings->home_title;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;
        $data['homeTitle'] = $this->settings->home_title;
        $data['isPage404'] = true;

        echo loadView('partials/_header', $data);
        echo view('errors/html/error_404');
        echo loadView('partials/_footer', $data);
    }
}
