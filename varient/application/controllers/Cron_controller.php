<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check Feed Posts
     */
    public function check_feed_posts()
    {
        get_method();
        //load the library
        $this->load->library('rss_parser');
        $feeds = $this->rss_model->get_feeds();

        foreach ($feeds as $feed) {
            if (!empty($feed->feed_url) && $feed->auto_update == 1) {
                $this->rss_model->add_feed_posts($feed->id);
            }
        }
        reset_cache_data_on_change();
        echo "All feeds have been checked.";
    }

    /**
     * Check Scheduled Posts
     */
    public function check_scheduled_posts()
    {
        get_method();
        $this->post_admin_model->check_scheduled_posts();
    }

    /**
     * Update Sitemap
     */
    public function update_sitemap()
    {
        get_method();
        $this->load->model('sitemap_model');
        $this->sitemap_model->update_sitemap();
    }
}
