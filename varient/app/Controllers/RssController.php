<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\RssModel;

class RssController extends BaseAdminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        checkPermission('rss_feeds');
        $this->rssModel = new RssModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * RSS Feeds
     */
    public function feeds()
    {
        checkPermission('rss_feeds');
        $data['title'] = trans("rss_feeds");
        $numRows = $this->rssModel->getFeedsCount();
        $pager = paginate($this->perPage, $numRows);
        $data['feeds'] = $this->rssModel->getFeedsPaginated($this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/rss/feeds', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Import Feed
     */
    public function importFeed()
    {
        $data['title'] = trans("import_rss_feed");
        $data['parentCategories'] = $this->categoryModel->getParentCategoriesByLang($this->activeLang->id);

        echo view('admin/includes/_header', $data);
        echo view('admin/rss/import_feed', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Import Feed Post
     */
    public function importFeedPost()
    {
        $val = \Config\Services::validation();
        $val->setRule('feed_name', trans("feed_name"), 'required|max_length[500]');
        $val->setRule('feed_url', trans("feed_url"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('import-feed'))->withInput();
        } else {
            $feedId = $this->rssModel->addFeed();
            if (!empty($feedId)) {
                $this->rssModel->addFeedPosts($feedId);
                $this->session->setFlashdata('success', trans("msg_added"));
                resetCacheDataOnChange();
                return redirect()->to(adminUrl('import-feed'));
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->to(adminUrl('import-feed'));
    }

    /**
     * Update RSS Feed
     */
    public function editFeed($id)
    {
        $data['feed'] = $this->rssModel->getFeed($id);
        if (empty($data['feed'])) {
            return redirect()->to(adminUrl('feeds'));
        }
        if (!isAdmin() && user()->id != $data['feed']->user_id) {
            return redirect()->to(adminUrl('feeds'));
        }
        $data['title'] = trans("update_rss_feed");
        //define category ids
        $category = $this->categoryModel->getCategory($data['feed']->category_id);
        $data['parentCategoryId'] = $data['feed']->category_id;
        $data['subCategoryId'] = 0;
        if (!empty($category) && $category->parent_id != 0) {
            $parentCategory = $this->categoryModel->getCategory($category->parent_id);
            if (!empty($parentCategory)) {
                $data['parentCategoryId'] = $parentCategory->id;
                $data['subCategoryId'] = $category->id;
            }
        }
        $data['parentCategories'] = $this->categoryModel->getParentCategoriesByLang($data['feed']->lang_id);
        $data['subCategories'] = $this->categoryModel->getSubCategoriesByParentId($data['parentCategoryId']);

        echo view('admin/includes/_header', $data);
        echo view('admin/rss/edit_feed', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update RSS Feed Post
     */
    public function editFeedPost()
    {
        $id = inputPost('id');
        $val = \Config\Services::validation();
        $val->setRule('feed_name', trans("feed_name"), 'required|max_length[500]');
        $val->setRule('feed_url', trans("feed_url"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(adminUrl('edit-feed/' . cleanNumber($id)))->withInput();
        } else {
            $feed = $this->rssModel->getFeed($id);
            if (!empty($feed)) {
                if (!isAdmin() && user()->id != $data['feed']->user_id) {
                    return redirect()->to(adminUrl('feeds'));
                }
                $this->rssModel->editFeed($feed);
                $this->rssModel->updateFeedPostsButton($feed->id);
                $this->session->setFlashdata('success', trans("msg_updated"));
                resetCacheDataOnChange();
                return redirect()->to(adminUrl('edit-feed/' . cleanNumber($id)));
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        return redirect()->to(adminUrl('edit-feed/' . cleanNumber($id)))->withInput();
    }

    /**
     * Get Feed Posts
     */
    public function checkFeedPosts()
    {
        $id = inputPost('id');
        $this->rssModel->addFeedPosts($id);
        $this->session->setFlashdata('success', trans("msg_updated"));
        resetCacheDataOnChange();
        return redirect()->to(adminUrl('feeds'));
    }

    /**
     * Delete Feed
     */
    public function deleteFeedPost()
    {
        $id = inputPost('id');
        if ($this->rssModel->deleteFeed($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
            resetCacheDataOnChange();
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }
}