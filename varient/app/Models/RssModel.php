<?php namespace App\Models;

use CodeIgniter\Model;

class RssModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('rss_feeds');
    }

    //input values
    public function inputValues()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'feed_name' => inputPost('feed_name'),
            'feed_url' => inputPost('feed_url'),
            'post_limit' => inputPost('post_limit'),
            'category_id' => inputPost('category_id'),
            'image_saving_method' => inputPost('image_saving_method'),
            'auto_update' => inputPost('auto_update'),
            'generate_keywords_from_title' => inputPost('generate_keywords_from_title'),
            'read_more_button' => inputPost('read_more_button'),
            'read_more_button_text' => inputPost('read_more_button_text'),
            'add_posts_as_draft' => inputPost('add_posts_as_draft')
        ];
    }

    //add feed
    public function addFeed()
    {
        $data = $this->inputValues();
        $subcategoryId = inputPost('subcategory_id');
        if (!empty($subcategoryId)) {
            $data['category_id'] = $subcategoryId;
        }
        $data["user_id"] = user()->id;
        $data["is_cron_updated"] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->builder->insert($data)) {
            return $this->db->insertID();
        }
        return false;
    }

    //edit feed
    public function editFeed($feed)
    {
        if (!empty($feed)) {
            $data = $this->inputValues();
            $subcategoryId = inputPost('subcategory_id');
            if (!empty($subcategoryId)) {
                $data['category_id'] = $subcategoryId;
            }
            return $this->builder->where('id', $feed->id)->update($data);
        }
        return false;
    }

    //update feed posts button
    public function updateFeedPostsButton($feedId)
    {
        $feed = $this->getFeed($feedId);
        if (!empty($feed)) {
            $posts = $this->db->table('posts')->where('feed_id', $feed->id)->get()->getResult();
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $this->db->table('posts')->where('id', $post->id)->update(['show_post_url' => $feed->read_more_button]);
                }
            }
        }
    }

    //get feed
    public function getFeed($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get feeds
    public function getFeeds()
    {
        return $this->builder->select('rss_feeds.*, (SELECT COUNT(*) FROM posts WHERE posts.feed_id = rss_feeds.id) AS num_posts')->get()->getResult();
    }

    //get feeds count
    public function getFeedsCount()
    {
        $this->filterFeeds();
        return $this->builder->countAllResults();
    }

    //get feeds paginated
    public function getFeedsPaginated($perPage, $offset)
    {
        $this->filterFeeds();
        return $this->builder->select('rss_feeds.*, (SELECT COUNT(*) FROM posts WHERE posts.feed_id = rss_feeds.id) AS num_posts')->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //filter feeds
    public function filterFeeds()
    {
        $langId = cleanNumber(inputGet('lang_id'));
        $q = inputGet('q');
        if (!empty($langId)) {
            $this->builder->where('lang_id', cleanNumber($langId));
        }
        if(!isAdmin()){
            $this->builder->where('user_id', user()->id);
        }
        if (!empty($q)) {
            $this->builder->like('feed_name', cleanStr($q));
        }
    }

    //get feeds by user
    public function getFeedsByUser($userId)
    {
        return $this->builder->where('user_id', cleanNumber($userId))->get()->getResult();
    }

    //get feeds cron
    public function getFeedsCron()
    {
        return $this->builder->where('auto_update', 1)->orderBy('is_cron_updated, id')->get(3)->getResult();
    }

    //get feeds not updated
    public function getFeedsNotUpdated()
    {
        return $this->builder->where('is_cron_updated', 0)->get()->getResult();
    }

    //reset feeds cron checked
    public function resetFeedsCronChecked()
    {
        $this->builder->update(['is_cron_updated' => 0]);
    }

    //set feed cron checked
    public function setFeedCronChecked($feedId)
    {
        $this->builder->where('id', cleanNumber($feedId))->update(['is_cron_updated' => 1]);
    }

    //delete feed
    public function deleteFeed($id)
    {
        $feed = $this->getFeed($id);
        if (!empty($feed)) {
            if (user()->role != 'admin' && user()->id != $feed->user_id) {
                return false;
            }
            return $this->builder->where('id', $feed->id)->delete();
        }
        return false;
    }

    //add rss feed posts
    public function addFeedPosts($feedId)
    {
        loadLibrary('RssParser');
        $rssParser = new \RssParser();
        $feed = $this->getFeed($feedId);
        if (!empty($feed)) {
            $response = $rssParser->getFeeds($feed->feed_url);
            $i = 0;
            if (!empty($response)) {
                foreach ($response as $item) {
                    if ($feed->post_limit == $i) {
                        break;
                    }
                    $title = $this->characterConvert($item->get_title());
                    $description = $this->characterConvert($item->get_description());
                    $content = $this->characterConvert($item->get_content());
                    $titleHash = md5($title ?? '');
                    $numRows = $this->db->table('posts')->where('title', cleanStr($title))->orWhere('title_hash', cleanStr($titleHash))->countAllResults();
                    if ($numRows < 1) {
                        $data = array();
                        $data['lang_id'] = $feed->lang_id;
                        $data['title'] = $title;
                        $data['title_slug'] = strSlug($title);
                        $data['title_hash'] = $titleHash;
                        $data['keywords'] = '';
                        if ($feed->generate_keywords_from_title == 1) {
                            $data['keywords'] = generateKeywords($title);
                        }
                        $data['summary'] = !empty($description) ? strip_tags($description) : '';
                        if (empty($data['summary'])) {
                            $summary = !empty($content) ? strTrim(strip_tags($content)) : '';
                            $data['summary'] = characterLimiter($summary, 240, '...');
                        }
                        $data['content'] = $content;
                        $data['category_id'] = $feed->category_id;
                        $data['optional_url'] = '';
                        $data['need_auth'] = 0;
                        $data['is_slider'] = 0;
                        $data['slider_order'] = 1;
                        $data['is_featured'] = 0;
                        $data['featured_order'] = 1;
                        $data['is_recommended'] = 0;
                        $data['is_breaking'] = 0;
                        $data['is_scheduled'] = 0;
                        $data['visibility'] = 1;
                        $data['post_type'] = "article";
                        $data['video_path'] = '';
                        $data['video_embed_code'] = '';
                        $data['user_id'] = $feed->user_id;
                        $data['feed_id'] = $feed->id;
                        $data['post_url'] = $item->get_link();
                        $data['show_post_url'] = $feed->read_more_button;
                        $data['image_description'] = '';
                        $data['created_at'] = date('Y-m-d H:i:s');
                        if ($feed->add_posts_as_draft == 1) {
                            $data['status'] = 0;
                        } else {
                            $data['status'] = 1;
                        }
                        //add image
                        if ($feed->image_saving_method == 'download') {
                            $dataImage = $rssParser->getImage($item, true);
                            if (!empty($dataImage) && is_array($dataImage)) {
                                $data['image_big'] = $dataImage['image_big'];
                                $data['image_default'] = $dataImage['image_default'];
                                $data['image_slider'] = $dataImage['image_slider'];
                                $data['image_mid'] = $dataImage['image_mid'];
                                $data['image_small'] = $dataImage['image_small'];
                                $data['image_mime'] = 'jpg';
                                $dataImage['file_name'] = $data['title_slug'];
                                $dataImage['user_id'] = $feed->user_id;
                                $db = \Config\Database::connect(null, false);
                                $db->table('images')->insert($dataImage);
                                $db->close();
                            }
                        } else {
                            $data['image_url'] = $rssParser->getImage($item, false);
                        }
                        if ($this->db->table('posts')->insert($data)) {
                            $postId = $this->db->insertID();
                            $postAdminModel = new PostAdminModel();
                            $postAdminModel->updateSlug($postId);
                        }
                    }
                    $i++;
                }

                //delete dublicated posts
                $postTitleHashs = $this->db->table('posts')->select('title_hash')->groupBy('title_hash')->having('COUNT(title_hash) > 1')->get()->getResult();
                if (!empty($postTitleHashs)) {
                    foreach ($postTitleHashs as $titleHash) {
                        if (!empty($titleHash)) {
                            $this->db->table('posts')->where('title_hash', $titleHash->title_hash)->orderBy('id DESC')->limit(1)->delete();
                        }
                    }
                }
                return true;
            }
        }
    }

    //convert characters
    public function characterConvert($str)
    {
        $str = strTrim($str);
        $str = strReplace("&amp;", "&", $str);
        $str = strReplace("&lt;", "<", $str);
        $str = strReplace("&gt;", ">", $str);
        $str = strReplace("&quot;", '"', $str);
        $str = strReplace("&apos;", "'", $str);
        return $str;
    }
}
