<?php namespace App\Models;

use CodeIgniter\Model;

class PostItemModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builderGalleryItems = $this->db->table('post_gallery_items');
        $this->builderSortedListItems = $this->db->table('post_sorted_list_items');
    }

    //add post list items
    public function addPostListItems($postId, $postType)
    {
        $titles = inputPost('list_item_title');
        $orders = inputPost('list_item_order');
        $images = inputPost('list_item_image');
        $largeImages = inputPost('list_item_image_large');
        $imageStorages = inputPost('list_item_image_storage');
        $contents = inputPost('list_item_content');
        $imageDescriptions = inputPost('list_item_image_description');
        if (!empty($titles)) {
            for ($i = 0; $i < countItems($titles); $i++) {
                $data = [
                    'post_id' => $postId,
                    'title' => !empty($titles[$i]) ? $titles[$i] : '',
                    'content' => !empty($contents[$i]) ? $contents[$i] : '',
                    'image' => !empty($images[$i]) ? $images[$i] : '',
                    'image_large' => !empty($largeImages[$i]) ? $largeImages[$i] : '',
                    'image_description' => !empty($imageDescriptions[$i]) ? $imageDescriptions[$i] : '',
                    'storage' => !empty($imageStorages[$i]) ? $imageStorages[$i] : '',
                    'item_order' => !empty($orders[$i]) ? $orders[$i] : 1
                ];
                $builder = $this->getBuilder($postType);
                $builder->insert($data);
            }
        }
    }

    //edit post list items
    public function editPostListItems($postId, $postType)
    {
        $postListItems = $this->getPostListItems($postId, $postType);
        if (!empty($postListItems)) {
            foreach ($postListItems as $postListItem) {
                $item_order = inputPost('list_item_order_' . $postListItem->id);
                if (!isset($item_order)) {
                    $item_order = 1;
                }
                $data = [
                    'title' => inputPost('list_item_title_' . $postListItem->id),
                    'content' => inputPost('list_item_content_' . $postListItem->id),
                    'image' => inputPost('list_item_image_' . $postListItem->id),
                    'image_large' => inputPost('list_item_image_large_' . $postListItem->id),
                    'image_description' => inputPost('list_item_image_description_' . $postListItem->id),
                    'storage' => inputPost('list_item_image_storage_' . $postListItem->id),
                    'item_order' => $item_order
                ];
                $builder = $this->getBuilder($postType);
                $builder->where('id', $postListItem->id)->update($data);
            }
        }
    }

    //add post list item
    public function addPostListItem($postId, $postType)
    {
        $rowOrder = $this->getPostListMaxOrder($postId, $postType);
        $maxOrder = 0;
        if (!empty($rowOrder) && !empty($rowOrder->max_order)) {
            $maxOrder = $rowOrder->max_order;
        }
        $data = [
            'post_id' => $postId,
            'title' => '',
            'content' => '',
            'image' => '',
            'image_large' => '',
            'image_description' => '',
            'item_order' => $maxOrder + 1
        ];
        $builder = $this->getBuilder($postType);
        $builder->insert($data);
        return $this->db->insertID();
    }

    //get post list items
    public function getPostListItems($postId, $postType)
    {
        if ($postType == 'gallery') {
            return $this->builderGalleryItems->select("post_gallery_items.*, 'gallery' AS item_post_type")->where('post_id', cleanNumber($postId))->orderBy('item_order')->get()->getResult();
        }
        return $this->builderSortedListItems->select("post_sorted_list_items.*, 'sorted_list' AS item_post_type")->where('post_id', cleanNumber($postId))->orderBy('item_order')->get()->getResult();
    }

    //get post list item
    public function getPostListItem($itemId, $postType)
    {
        if ($postType == 'gallery') {
            return $this->builderGalleryItems->select("post_gallery_items.*, 'gallery' AS item_post_type")->where('id', cleanNumber($itemId))->get()->getRow();
        }
        return $this->builderSortedListItems->select("post_sorted_list_items.*, 'sorted_list' AS item_post_type")->where('id', cleanNumber($itemId))->get()->getRow();
    }

    //get gallery post item by order
    public function getGalleryPostItemByOrder($postId, $order)
    {
        $order = cleanNumber($order);
        $nthRow = $order - 1;
        if ($nthRow <= 0) {
            $nthRow = 0;
        }
        return $this->builderGalleryItems->where('post_id', cleanNumber($postId))->orderBy('item_order')->get()->getRow($nthRow);
    }

    //get post list items count
    public function getPostListItemsCount($postId, $postType)
    {
        $builder = $this->getBuilder($postType);
        return $builder->where('post_id', cleanNumber($postId))->countAllResults();
    }

    //get post list max order value
    public function getPostListMaxOrder($postId, $postType)
    {
        $builder = $this->getBuilder($postType);
        return $builder->select("MAX(item_order) AS max_order")->where('post_id', cleanNumber($postId))->get()->getRow();
    }

    //delete post list item
    public function deletePostListItem($itemId, $postType)
    {
        $item = $this->getPostListItem($itemId, $postType);
        if (!empty($item)) {
            $post = getPostById($item->post_id);
            if (!empty($post)) {
                if (!checkPostOwnership($post->user_id)) {
                    return false;
                }
                if ($postType == 'gallery') {
                    return $this->builderGalleryItems->where('id', $item->id)->delete();
                } else {
                    return $this->builderSortedListItems->where('id', $item->id)->delete();
                }
            }
        }
        return false;
    }

    //delete post list items
    public function deletePostListItems($postId, $postType)
    {
        $items = $this->getPostListItems($postId, $postType);
        if (!empty($items)) {
            foreach ($items as $item) {
                $this->deletePostListItem($item->id, $postType);
            }
        }
    }

    //get builder
    public function getBuilder($postType)
    {
        if ($postType == 'gallery') {
            return $this->builderGalleryItems;
        }
        return $this->builderSortedListItems;
    }

}