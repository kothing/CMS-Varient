<?php namespace App\Models;

use CodeIgniter\Model;

class TagModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('tags');
    }

    //add post tags
    public function addPostTags($postId, $tags)
    {
        $tags = strTrim($tags);
        if (!empty($tags)) {
            $tagsArray = explode(',', $tags);
            if (!empty($tagsArray)) {
                foreach ($tagsArray as $tag) {
                    if (!empty($tag)) {
                        $tag = strTrim($tag);
                        if (strlen($tag) > 1) {
                            $data = [
                                'post_id' => cleanNumber($postId),
                                'tag' => strTrim($tag),
                                'tag_slug' => strSlug(strTrim($tag))
                            ];
                            if (empty($data["tag_slug"]) || $data["tag_slug"] == "-") {
                                $data["tag_slug"] = "tag-" . uniqid();
                            }
                            $this->builder->insert($data);
                        }
                    }
                }
            }
        }
    }

    //edit post tags
    public function editPostTags($postId)
    {
        $this->deletePostTags($postId);
        $tags = inputPost('tags');
        if (!empty($tags)) {
            $tagsArray = explode(",", $tags);
            if (!empty($tagsArray)) {
                foreach ($tagsArray as $tag) {
                    if (!empty($tag)) {
                        $tag = strTrim($tag);
                        if (strlen($tag) > 1) {
                            $data = [
                                'post_id' => cleanNumber($postId),
                                'tag' => $tag,
                                'tag_slug' => strSlug($tag)
                            ];
                            if (empty($data['tag_slug']) || $data['tag_slug'] == '-') {
                                $data['tag_slug'] = 'tag-' . uniqid();
                            }
                            $this->builder->insert($data);
                        }
                    }
                }
            }
        }
    }

    //get popular tags
    public function getPopularTags()
    {
        return $this->builder->join('posts', 'posts.id = tags.post_id')->select('tags.tag, tags.tag_slug, COUNT(tags.tag_slug) AS count')->groupBy('tags.tag, tags.tag_slug')
            ->where('posts.lang_id', cleanNumber($this->activeLang->id))->orderBy('count DESC')->get(15)->getResult();
    }

    //get tag
    public function getTag($slug)
    {
        return $this->builder->join('posts', 'posts.id = tags.post_id')->join('users', 'posts.user_id = users.id')->select('tags.*, posts.lang_id as tag_lang_id')
            ->where('tags.tag_slug', cleanStr($slug))->where('posts.status', 1)->where('posts.visibility', 1)->where('posts.is_scheduled', 0)->orderBy('tags.tag')->get()->getRow();
    }

    //get posts tags
    public function getPostTags($postId)
    {
        return $this->builder->where('post_id', cleanNumber($postId))->get()->getResult();
    }

    //get posts tags string
    public function getPostTagsString($postId)
    {
        $str = "";
        $count = 0;
        $tagsArray = $this->getPostTags($postId);
        foreach ($tagsArray as $item) {
            if ($count > 0) {
                $str .= ",";
            }
            $str .= $item->tag;
            $count++;
        }
        return $str;
    }

    //delete tags
    public function deletePostTags($postId)
    {
        $tags = $this->getPostTags($postId);
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $this->builder->where('id', $tag->id)->delete();
            }
        }
    }
}
