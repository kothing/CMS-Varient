<?php namespace App\Models;

use CodeIgniter\Model;

class PostModel extends BaseModel
{
    protected $builder;
    protected $sliderPostsLimit;
    protected $breakingPostsLimit;
    protected $popularPostsLimit;
    protected $recommendedPostsLimit;

    public function __construct()
    {
        parent::__construct();

        $this->builder = $this->db->table('posts');
        $this->sliderPostsLimit = 20;
        $this->breakingPostsLimit = 20;
        $this->popularPostsLimit = 5;
        $this->recommendedPostsLimit = 5;
    }

    //build sql query
    public function buildQuery($langId = null, $fetchContent = false, $joinTags = false, $isPreview = false)
    {
        if ($langId == null) {
            $langId = $this->activeLang->id;
        }
        $this->builder->resetQuery();
        $this->builder->join('categories', 'categories.id = posts.category_id')->join('users', 'users.id = posts.user_id');
        if ($joinTags) {
            $this->builder->join('tags', 'tags.post_id = posts.id');
        }
        if ($fetchContent) {
            $this->builder->select('posts.*');
        } else {
            $this->builder->select('posts.id, posts.lang_id, posts.title, posts.title_slug, posts.summary, posts.category_id, posts.image_big, posts.image_slider, posts.image_mid, posts.image_small, posts.image_mime, posts.image_storage, posts.slider_order, posts.featured_order, posts.post_type, posts.image_url, posts.user_id, posts.pageviews, posts.post_url, posts.updated_at, posts.created_at');
        }
        $this->builder->select('categories.name AS category_name, categories.name_slug AS category_slug , categories.color AS category_color, users.username AS author_username, users.slug AS author_slug,(SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count');
        if ($isPreview == false) {
            $this->builder->where('posts.is_scheduled', 0)->where('posts.visibility', 1)->where('posts.status = 1')->where('posts.lang_id', cleanNumber($langId));
        }
    }

    //get latest posts by category
    public function getLatestCategoryPosts($langId)
    {
        $sql = "SELECT id FROM
                (SELECT id, category_id, @ct_row_number := IF(@prev = category_id, @ct_row_number + 1, 1) AS number_of_rows, @prev := category_id
                FROM posts
                JOIN (SELECT @prev := NULL, @ct_row_number := 0) AS vars
                WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1
                ORDER BY category_id, created_at DESC
                ) AS table_posts
                WHERE number_of_rows <= 15";
        $result = $this->db->query($sql)->getResult();
        $postIdsArray = array();
        if (!empty($result)) {
            foreach ($result as $item) {
                array_push($postIdsArray, $item->id);
            }
        }
        if (countItems($postIdsArray) < 1) {
            return array();
        }
        $this->buildQuery($langId);
        return $this->builder->whereIn('posts.id', $postIdsArray, false)->orderBy('posts.created_at DESC, id DESC')->get()->getResult();
    }

    //get latest posts
    public function getLatestPosts($limit)
    {
        $this->buildQuery();
        return $this->builder->orderBy('posts.created_at DESC, id DESC')->limit(cleanNumber($limit))->get()->getResult();
    }

    //get slider posts
    public function getSliderPosts()
    {
        $this->buildQuery();
        $this->builder->where('posts.is_slider', 1);
        if ($this->generalSettings->sort_slider_posts == 'by_slider_order') {
            $this->builder->orderBy('posts.slider_order, posts.id');
        } else {
            $this->builder->orderBy('posts.created_at DESC');
        }
        return $this->builder->get($this->sliderPostsLimit)->getResult();
    }

    //get featured posts
    public function getFeaturedPosts()
    {
        $this->buildQuery();
        $this->builder->where('posts.is_featured', 1);
        if ($this->generalSettings->sort_featured_posts == 'by_featured_order') {
            $this->builder->orderBy('posts.featured_order');
        } else {
            $this->builder->orderBy('posts.created_at DESC');
        }
        return $this->builder->get(10)->getResult();
    }

    //get breaking news
    public function getBreakingNews()
    {
        $this->buildQuery();
        return $this->builder->where('posts.is_breaking', 1)->orderBy('posts.created_at DESC')->get($this->breakingPostsLimit)->getResult();
    }

    //get popular posts
    public function getPopularPosts($langId)
    {
        $this->buildQuery($langId);
        return $this->builder->where('posts.id IN (SELECT post_id FROM (SELECT post_pageviews_month.post_id, COUNT(*) AS count FROM post_pageviews_month GROUP BY post_id ORDER BY count DESC LIMIT 10) AS tbl)')
            ->orderBy('posts.pageviews DESC, posts.id')->get($this->popularPostsLimit)->getResult();
    }

    //get recommended posts
    public function getRecommendedPosts()
    {
        $this->buildQuery();
        return $this->builder->where('posts.is_recommended', 1)->orderBy('posts.created_at DESC')->get($this->recommendedPostsLimit)->getResult();
    }

    //get most viewed posts
    public function getMostViewedPosts($limit)
    {
        $this->buildQuery();
        return $this->builder->orderBy('posts.pageviews DESC')->get(cleanNumber($limit))->getResult();
    }

    //get post count
    public function getPostCount()
    {
        $this->buildQuery();
        return $this->builder->countAllResults();
    }

    //get posts paginated
    public function getPostsPaginated($perPage, $offset)
    {
        $this->buildQuery();
        return $this->builder->orderBy('posts.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get post by slug
    public function getPostBySlug($slug)
    {
        $this->buildQuery(null, true);
        return $this->builder->where('posts.title_slug', cleanSlug($slug))->get()->getRow();
    }

    //get post count by category
    public function getPostCountByCategory($categoryId, $categories)
    {
        $categoryIds = getCategoryTree($categoryId, $categories);
        if (countItems($categoryIds) < 1) {
            return array();
        }
        $this->buildQuery();
        return $this->builder->whereIn('posts.category_id', $categoryIds, false)->countAllResults();
    }

    //get posts by cateogry paginated
    public function getPostsByCategoryPaginated($categoryId, $categories, $perPage, $offset)
    {
        $categoryIds = getCategoryTree($categoryId, $categories);
        if (countItems($categoryIds) < 1) {
            return array();
        }
        $this->buildQuery();
        return $this->builder->whereIn('posts.category_id', $categoryIds, false)->orderBy('posts.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get paginated tag posts
    public function getTagPostsPaginated($tagSlug, $perPage, $offset)
    {
        $this->buildQuery(null, false, true);
        return $this->builder->where('tags.tag_slug', cleanStr($tagSlug))->orderBy('posts.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get post count by tag
    public function getPostCountByTag($tagSlug)
    {
        $this->buildQuery(null, false, true);
        return $this->builder->where('tags.tag_slug', cleanStr($tagSlug))->countAllResults();
    }

    //get search posts count
    public function getSearchPostsCount($q, $searchInContent)
    {
        $this->buildQuery();
        $this->builder->groupStart()->like('posts.title', $q)->orLike('posts.summary', $q);
        if ($searchInContent) {
            $this->builder->orLike('posts.content', $q);
        }
        return $this->builder->groupEnd()->countAllResults();
    }

    //get paginated search posts
    public function getSearchPostsPaginated($q, $searchInContent, $perPage, $offset)
    {
        $this->buildQuery();
        $this->builder->groupStart()->like('posts.title', $q)->orLike('posts.summary', $q);
        if ($searchInContent) {
            $this->builder->orLike('posts.content', $q);
        }
        return $this->builder->groupEnd()->orderBy('posts.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get user posts count
    public function getUserPostsCount($userId)
    {
        $this->buildQuery();
        return $this->builder->where('posts.user_id', cleanNumber($userId))->countAllResults();
    }

    //get paginated user posts
    public function getUserPostsPaginated($userId, $perPage, $offset)
    {
        $this->buildQuery();
        return $this->builder->where('posts.user_id', cleanNumber($userId))->orderBy('posts.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get related posts
    public function getRelatedPosts($categoryId, $postId, $categories)
    {
        $categoryIds = getCategoryTree($categoryId, $categories);
        if (countItems($categoryIds) < 1) {
            return array();
        }
        $sql = $this->builder->select('id')->whereIn('posts.category_id', $categoryIds, false)->orderBy('posts.created_at DESC')->getCompiledSelect();
        $this->buildQuery();
        return $this->builder->where('posts.id != ', cleanNumber($postId))->where('posts.id IN (' . $sql . ')')->orderBy('RAND()')->limit(6)->get()->getResult();
    }

    //get previous post
    public function getPreviousPost($id)
    {
        return $this->builder->where('posts.id <', cleanNumber($id))->where('posts.is_scheduled = 0')->where('posts.visibility = 1')->where('posts.status = 1')->where('posts.lang_id', cleanNumber($this->activeLang->id))->orderBy('posts.id DESC')->get(1)->getRow();
    }

    //get next post
    public function getNextPost($id)
    {
        return $this->builder->where('posts.id >', cleanNumber($id))->where('posts.is_scheduled = 0')->where('posts.visibility = 1')->where('posts.status = 1')->where('posts.lang_id', cleanNumber($this->activeLang->id))->orderBy('posts.id')->get(1)->getRow();
    }

    //get reading list posts count
    public function getReadingListPostsCount($userId)
    {
        $this->buildQuery();
        return $this->builder->join('reading_lists', 'reading_lists.post_id = posts.id')->where('reading_lists.user_id', cleanNumber($userId))->countAllResults();
    }

    //get paginated reading list posts
    public function getReadingListPostsPaginated($userId, $perPage, $offset)
    {
        $this->buildQuery();
        return $this->builder->join('reading_lists', 'reading_lists.post_id = posts.id')->where('reading_lists.user_id', cleanNumber($userId))->orderBy('reading_lists.id DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //check post is in the reading list or not
    public function isPostInReadingList($postId)
    {
        if (authCheck()) {
            if ($this->db->table('reading_lists')->where('post_id', cleanNumber($postId))->where('user_id', cleanNumber(user()->id))->countAllResults() > 0) {
                return true;
            }
        }
        return false;
    }

    //add to reading list
    public function addRemoveReadingListItem($postId, $operation)
    {
        if (authCheck()) {
            if ($operation == 'add') {
                $data = [
                    'post_id' => cleanNumber($postId),
                    'user_id' => user()->id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                return $this->db->table('reading_lists')->insert($data);
            } elseif ($operation == 'remove') {
                return $this->db->table('reading_lists')->where('post_id', cleanNumber($postId))->where('user_id', cleanNumber(user()->id))->delete();
            }
        }
        return false;
    }

    //get preview post
    public function getPostPreview($slug)
    {
        $this->buildQuery(null, true, false, true);
        return $this->builder->where('posts.title_slug', cleanSlug($slug))->get()->getRow();
    }

    //get rss posts
    public function getRSSPosts($userId, $categoryId, $categories, $limit)
    {
        $this->builder->join('categories', 'categories.id = posts.category_id')->join('users', 'users.id = posts.user_id')
            ->select('posts.*, categories.name AS category_name, categories.name_slug AS category_slug , categories.color AS category_color, users.username AS author_username, users.slug AS author_slug');
        if (!empty($categoryId)) {
            $categoryIds = getCategoryTree($categoryId, $categories);

            if (countItems($categoryIds) > 0) {
                $this->builder->whereIn('posts.category_id', $categoryIds, false);
            }
        }
        if (!empty($userId)) {
            $this->builder->where('posts.user_id', cleanNumber($userId));
        }
        return $this->builder->where('posts.is_scheduled', 0)->where('posts.visibility', 1)->where('posts.status = 1')->where('posts.lang_id', cleanNumber($this->activeLang->id))
            ->orderBy('posts.created_at DESC')->get(cleanNumber($limit))->getResult();
    }

    //get google news feeds
    public function getGoogleNewsFeeds($categories)
    {
        $langId = cleanNumber(inputGet('lang'));
        $categoryId = cleanNumber(inputGet('category'));
        $userId = cleanNumber(inputGet('author'));
        $limit = cleanNumber(inputGet('limit'));
        if ($limit <= 0) {
            $limit = 1000;
        }
        $key = 'google_news_lang' . $langId . '_cat' . $categoryId . '_author' . $userId . '_limit' . $limit;
        $posts = getCachedData('$key');
        if (!empty($posts)) {
            return $posts;
        }
        $this->builder->join('categories', 'categories.id = posts.category_id')->join('users', 'users.id = posts.user_id')
            ->select('posts.*, 
            (SELECT short_form FROM languages WHERE languages.id = posts.lang_id) AS lang_short_form,
            categories.name AS category_name, categories.name_slug AS category_slug , 
            categories.color AS category_color, users.username AS author_username, users.slug AS author_slug');
        if (!empty($langId)) {
            $this->builder->where('posts.lang_id', $langId);
        }
        if (!empty($categoryId)) {
            $categoryIds = getCategoryTree($categoryId, $categories);
            if (countItems($categoryIds) > 0) {
                $this->builder->whereIn('posts.category_id', $categoryIds, false);
            }
        }
        if (!empty($userId)) {
            $this->builder->where('posts.user_id', cleanNumber($userId));
        }
        $posts = $this->builder->where('posts.is_scheduled', 0)->where('posts.visibility', 1)->where('posts.status = 1')->orderBy('posts.created_at DESC')->get($limit)->getResult();
        $cache = \Config\Services::cache();
        cache()->save($key, $posts, 900);
        return $posts;
    }

    //increase post pageviews
    public function increasePostPageviews($post, $author)
    {
        $agent = $this->request->getUserAgent();
        if (!empty($post) && !empty($author) && !$agent->isRobot() && !isBot()) {
            if (empty(getSession('post_read_' . $post->id))) {
                $userAgent = $agent->getAgentString();
                $ipAddress = getIPAddress();
                $rewardAmount = 0;
                if ($this->generalSettings->reward_system_status == 1 && !empty($this->generalSettings->reward_amount) && $author->reward_system_enabled == 1) {
                    $rewardAmount = number_format($this->generalSettings->reward_amount / 1000, 10, '.', '');
                }
                $row = $this->db->table('post_pageviews_month')->where('post_id', $post->id)->where('ip_address', $ipAddress)->where('user_agent', $userAgent)->get(1)->getRow();
                if (empty($row)) {
                    if ($this->builder->where('id', $post->id)->update(['pageviews' => $post->pageviews + 1])) {
                        setSession('post_read_' . $post->id, '1');
                        $data = ['post_id' => $post->id, 'post_user_id' => $post->user_id, 'ip_address' => $ipAddress, 'user_agent' => $userAgent, 'reward_amount' => $rewardAmount, 'created_at' => date('Y-m-d H:i:s')];
                        if ($this->db->table('post_pageviews_month')->insert($data)) {
                            if ($rewardAmount > 0) {
                                $newBalance = $author->balance + $rewardAmount;
                                if (!empty($newBalance)) {
                                    $newBalance = number_format($newBalance, 10, '.', '');
                                }
                                $this->db->query("UPDATE users SET balance = ?, total_pageviews = total_pageviews + 1 WHERE id = ?", array($newBalance, $post->user_id));
                            }
                        }
                    }
                }
            }
        }
    }

    //delete old page views
    public function deleteOldPageviews()
    {
        $now = date('Y-m-d H:i:s');
        $month = strtotime("-30 days", strtotime($now));
        $this->db->query("DELETE FROM post_pageviews_month WHERE created_at < '" . date('Y-m-d H:i:s', $month) . "'");
    }
}