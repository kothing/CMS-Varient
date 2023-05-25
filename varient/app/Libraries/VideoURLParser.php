<?php
require APPPATH . 'ThirdParty/video-url-parser/vendor/autoload.php';

use RicardoFiorani\Matcher\VideoServiceMatcher;

class VideoURLParser
{
    //get video embed code
    public function getVideoEmbedCode($url)
    {
        try {
            $vsm = new VideoServiceMatcher();
            $video = $vsm->parse($url);
            return $video->getEmbedUrl();
        } catch (\RicardoFiorani\Exception\NotEmbeddableException $e) {
            return null;
        }
    }

    //get video thumbnail
    public function getVideoThumbnail($url)
    {
        try {
            $vsm = new VideoServiceMatcher();
            $video = $vsm->parse($url);
            $thumbnail = $video->getLargestThumbnail();
            if (empty($thumbnail)) {
                $thumbnail = $video->getSmallThumbnail();
            }
            return $thumbnail;
        } catch (\RicardoFiorani\Exception\NotEmbeddableException $e) {
            return null;
        }
    }
}