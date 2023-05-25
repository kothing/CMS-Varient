<?php

namespace App\Controllers;

use App\Models\PostAdminModel;
use App\Models\RssModel;
use App\Models\SitemapModel;

class CronController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Check Feed Posts
     */
    public function checkFeedPosts()
    {
        $rssModel = new RssModel();
        $feedNotUpdated = $rssModel->getFeedsNotUpdated();
        if (empty($feedNotUpdated)) {
            $rssModel->resetFeedsCronChecked();
        }
        $feeds = $rssModel->getFeedsCron();
        if (!empty($feeds)) {
            foreach ($feeds as $feed) {
                if (!empty($feed->feed_url)) {
                    $rssModel->addFeedPosts($feed->id);
                    $rssModel->setFeedCronChecked($feed->id);
                }
            }
            resetCacheDataOnChange();
        }
        echo "Feeds have been checked!";
    }

    /**
     * Update Sitemap
     */
    public function updateSitemap()
    {
        $sitemapModel = new SitemapModel();
        $sitemapModel->generateSitemap();
        echo "Sitemap has been generated!";
    }

    /**
     * Check Scheduled Posts
     */
    public function checkScheduledPosts()
    {
        $postAdminModel = new PostAdminModel();
        $postAdminModel->checkScheduledPosts();
    }
}
