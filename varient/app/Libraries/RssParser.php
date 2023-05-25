<?php
require APPPATH . "ThirdParty/simplepie/autoloader.php";
require APPPATH . "ThirdParty/simplepie/idn/idna_convert.class.php";
require APPPATH . "ThirdParty/rss-parser/Feed.php";
require APPPATH . "ThirdParty/rss-parser/embed/autoloader.php";

// Load all required Feed classes
use YuzuruS\Rss\Feed;


class RssParser
{
    /**
     * @return  feeds
     **/
    public function getFeeds($url)
    {
        header('Content-type:text/html; charset=utf-8');
        $feed = new \SimplePie\SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(false);
        $feed->init();
        $feed->handle_content_type();
        return $feed->get_items();
    }

    //get image
    public function getImage($item, $download = false)
    {
        if ($download == true) {
            //download image
            $uploadModel = new \App\Models\UploadModel();
            $data = [
                'image_big' => '',
                'image_default' => '',
                'image_slider' => '',
                'image_mid' => '',
                'image_small' => ''
            ];
            $imgURL = $this->getImageURLFromFeed($item);
            if (empty($imgURL)) {
                return $data;
            }
            try {
                $tempPath = $uploadModel->downloadTempImage($imgURL, 'jpg');
                if (!empty($tempPath) && file_exists($tempPath)) {
                    $data = [
                        'image_big' => $uploadModel->uploadPostImage($tempPath, 'big'),
                        'image_default' => $uploadModel->uploadPostImage($tempPath, 'default'),
                        'image_slider' => $uploadModel->uploadPostImage($tempPath, 'slider'),
                        'image_mid' => $uploadModel->uploadPostImage($tempPath, 'mid'),
                        'image_small' => $uploadModel->uploadPostImage($tempPath, 'small')
                    ];
                }
                return $data;
            } catch (\Exception $e) {
                return $data;
            }
        }
        return $this->getImageURLFromFeed($item);
    }

    //get image URL from feed
    public function getImageURLFromFeed($item)
    {
        //enclosure image
        $imgURL = $this->getPostImageFromEnclosure($item);
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }
        //og image
        $imgURL = $this->getImageFromOG($item);
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }
        //text image
        $imgURL = '';
        $images = $this->getImageFromText($item);
        if (!empty($images)) {
            $imgURL = @$images[0];
        }
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }
        //embed og image
        $imgURL = $this->getImageFromEmbedOG($item);
        if (!empty($imgURL) && (strpos($imgURL, 'http') !== false)) {
            return $imgURL;
        }
        return null;
    }

    //get post image from enclosure
    public function getPostImageFromEnclosure($item)
    {
        $imgURL = '';
        if (!empty($item->get_enclosure())) {
            if (!empty($item->get_enclosure()->get_link())) {
                $imgURL = $item->get_enclosure()->get_link();
            }
        }
        return $imgURL;
    }

    //get post image from og tag
    public function getImageFromOG($item)
    {
        if (!empty($item->get_link())) {
            $metaOGImg = null;
            $response = Feed::httpRequest($item->get_link(), NULL, NULL, NULL);
            if (!empty($response)) {
                $html = new DOMDocument();
                @$html->loadHTML($response);
                foreach ($html->getElementsByTagName('meta') as $meta) {
                    if ($meta->getAttribute('property') == 'og:image') {
                        $metaOGImg = $meta->getAttribute('content');
                    }
                }
            }
            return $metaOGImg;
        }
        return '';
    }

    //get post image from description
    public function getImageFromText($item)
    {
        try {
            $text = $item->get_description();
            return Feed::getImgFromText($text);
        } catch (Exception $e) {
            return false;
        }
    }

    //get post image from og tag embed
    public function getImageFromEmbedOG($item)
    {
        try {
            $og_img = '';
            if (!empty($item->get_link())) {
                $og_img = Feed::getImgFromOg($item->get_link());
            }
            return $og_img;
        } catch (Exception $e) {
            return false;
        }
    }

}