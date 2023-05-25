<?php

namespace App\Controllers;

use App\Models\FileModel;

class FileController extends BaseAdminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if (!checkUserPermission('admin_panel')) {
            exit();
        }
        $this->fileModel = new FileModel();
    }

    /*
    * --------------------------------------------------------------------
    * IMAGES
    * --------------------------------------------------------------------
    */

    /**
     * Upload Image
     */
    public function uploadImage()
    {
        $this->fileModel->uploadImage();
    }

    /**
     * Get Images
     */
    public function getImages()
    {
        $this->printImages($this->fileModel->getImages());
    }

    /**
     * Select Image File
     */
    public function selectImage()
    {
        $fileId = inputPost('file_id');
        $file = $this->fileModel->getImage($fileId);
        if (!empty($file)) {
            echo base_url($file->image_mid);
        }
    }

    /**
     * Laod More Images
     */
    public function loadMoreImages()
    {
        $lastId = inputPost('min');
        $this->printImages($this->fileModel->getMoreImages($lastId));
    }

    /**
     * Search Images
     */
    public function searchImage()
    {
        $search = inputPost('search');
        $this->printImages($this->fileModel->searchImages($search));
    }

    /**
     * Print Images
     */
    public function printImages($images)
    {
        $data = [
            'result' => 0,
            'content' => ''
        ];
        if (!empty($images)) {
            foreach ($images as $image) {
                $imgBaseURL = getBaseURLByStorage($image->storage);
                $data['content'] .= '<div class="col-file-manager" id="img_col_id_' . $image->id . '">';
                $data['content'] .= '<div class="file-box" data-file-id="' . $image->id . '" data-mid-file-path="' . $image->image_mid . '" data-default-file-path="' . $image->image_default . '" data-slider-file-path="' . $image->image_slider . '" data-big-file-path="' . $image->image_big . '" data-file-storage="' . $image->storage . '" data-file-base-url="' . $imgBaseURL . '">';
                $data['content'] .= '<div class="image-container">';
                $data['content'] .= '<img src="' . $imgBaseURL . $image->image_slider . '" alt="" class="img-responsive">';
                $data['content'] .= '</div>';
                if (!empty($image->file_name)):
                    $data['content'] .= '<span class="file-name">' . esc($image->file_name) . '</span>';
                endif;
                $data['content'] .= '</div> </div>';
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Delete Image
     */
    public function deleteImage()
    {
        $fileId = inputPost('file_id');
        $this->fileModel->deleteImage($fileId);
    }


    /*
    *------------------------------------------------------------------------------------------
    * QUIZ IMAGES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Quiz Image File
     */
    public function uploadQuizImageFile()
    {
        $this->fileModel->uploadQuizImage();
    }

    /**
     * Get Quiz Images
     */
    public function getQuizImages()
    {
        $quizImages = $this->fileModel->getQuizImages();
        $this->printQuizImages($quizImages);
    }

    /**
     * Laod More Quiz Images
     */
    public function loadMoreQuizImages()
    {
        $min = inputPost('min');
        $quizImages = $this->fileModel->getMoreQuizImages($min);
        $this->printQuizImages($quizImages);
    }

    /**
     * Search Quiz Images
     */
    public function searchQuizImage()
    {
        $search = inputPost('search');
        $quizImages = $this->fileModel->searchQuizImages($search);
        $this->printQuizImages($quizImages);
    }

    /**
     * Print Quiz Images
     */
    public function printQuizImages($quizImages)
    {
        $data = [
            'result' => 0,
            'content' => ''
        ];
        if (!empty($quizImages)) {
            foreach ($quizImages as $image) {
                $imgBaseURL = getBaseURLByStorage($image->storage);
                $data['content'] .= '<div class="col-file-manager" id="img_col_id_' . $image->id . '">';
                $data['content'] .= '<div class="file-box" data-file-id="' . $image->id . '" data-default-file-path="' . $image->image_default . '" data-small-file-path="' . $image->image_small . '" data-file-storage="' . $image->storage . '" data-file-base-url="' . $imgBaseURL . '">';
                $data['content'] .= '<div class="image-container">';
                $data['content'] .= '<img src="' . $imgBaseURL . $image->image_small . '" alt="" class="img-responsive">';
                $data['content'] .= '</div>';
                if (!empty($image->file_name)) {
                    $data['content'] .= '<span class="file-name">' . esc($image->file_name) . '</span>';
                }
                $data['content'] .= '</div> </div>';
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Delete Quiz Image File
     */
    public function deleteQuizImage()
    {
        $fileId = inputPost('file_id');
        $this->fileModel->deleteQuizImage($fileId);
    }


    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload File
     */
    public function uploadFile()
    {
        $this->fileModel->uploadFile();
    }

    /**
     * Get Files
     */
    public function getFiles()
    {
        $files = $this->fileModel->getFiles();
        $this->printFiles($files);
    }

    /**
     * Laod More Files
     */
    public function loadMoreFiles()
    {
        $min = inputPost('min');
        $files = $this->fileModel->getMoreFiles($min);
        $this->printFiles($files);
    }

    /**
     * Search Files
     */
    public function searchFiles()
    {
        $search = inputPost('search');
        $files = $this->fileModel->searchFiles($search);
        $this->printFiles($files);
    }

    /**
     * Print Files
     */
    public function printFiles($files)
    {
        $data = [
            'result' => 0,
            'content' => ''
        ];
        if (!empty($files)) {
            foreach ($files as $file) {
                $data['content'] .= '<div class="col-file-manager" id="file_col_id_' . $file->id . '">';
                $data['content'] .= '<div class="file-box" data-file-id="' . $file->id . '" data-file-name="' . $file->file_name . '">';
                $data['content'] .= '<div class="image-container icon-container">';
                $data['content'] .= '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($file->file_name, PATHINFO_EXTENSION) . '"></div>';
                $data['content'] .= '</div>';
                $data['content'] .= '<span class="file-name">' . esc($file->file_name) . '</span>';
                $data['content'] .= '</div> </div>';
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Delete File
     */
    public function deleteFile()
    {
        $fileId = inputPost('file_id');
        $this->fileModel->deleteFile($fileId);
    }


    /*
    *------------------------------------------------------------------------------------------
    * VIDEOS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Video
     */
    public function uploadVideo()
    {
        $this->fileModel->uploadVideo();
    }

    /**
     * Get Videos
     */
    public function getVideos()
    {
        $videos = $this->fileModel->getVideos();
        $this->printVideos($videos);
    }

    /**
     * Laod More Videos
     */
    public function loadMoreVideos()
    {
        $min = inputPost('min');
        $videos = $this->fileModel->getMoreVideos($min);
        $this->printVideos($videos);
    }

    /**
     * Search Videos
     */
    public function searchVideos()
    {
        $search = inputPost('search');
        $videos = $this->fileModel->searchVideos($search);
        $this->printVideos($videos);
    }

    /**
     * Print Videos
     */
    public function printVideos($videos)
    {
        $data = [
            'result' => 0,
            'content' => ''
        ];
        if (!empty($videos)) {
            foreach ($videos as $video) {
                $videoBaseURL = getBaseURLByStorage($video->storage);
                $data['content'] .= '<div class="col-file-manager" id="video_col_id_' . $video->id . '">';
                $data['content'] .= '<div class="file-box" data-video-id="' . $video->id . '" data-video-path="' . $video->video_path . '" data-video-storage="' . $video->storage . '" data-video-base-url="' . $videoBaseURL . '">';
                $data['content'] .= '<div class="image-container icon-container">';
                $data['content'] .= '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($video->video_name, PATHINFO_EXTENSION) . '"></div>';
                $data['content'] .= '</div>';
                $data['content'] .= '<span class="file-name">' . esc($video->video_name) . '</span>';
                $data['content'] .= '</div> </div>';
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Delete Video
     */
    public function deleteVideo()
    {
        $videoId = inputPost('video_id');
        $this->fileModel->deleteVideo($videoId);
    }


    /*
    *------------------------------------------------------------------------------------------
    * AUDIOS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Audio
     */
    public function uploadAudio()
    {
        $this->fileModel->uploadAudio();
    }

    /**
     * Get Audios
     */
    public function getAudios()
    {
        $audios = $this->fileModel->getAudios();
        $this->printAudios($audios);
    }

    /**
     * Laod More Audios
     */
    public function loadMoreAudios()
    {
        $min = inputPost('min');
        $audios = $this->fileModel->getMoreAudios($min);
        $this->printAudios($audios);
    }

    /**
     * Search Audios
     */
    public function searchAudios()
    {
        $search = inputPost('search');
        $audios = $this->fileModel->searchAudios($search);
        $this->printAudios($audios);
    }

    /**
     * Print Audios
     */
    public function printAudios($audios)
    {
        $data = [
            'result' => 0,
            'content' => ''
        ];
        if (!empty($audios)) {
            foreach ($audios as $audio) {
                $data['content'] .= '<div class="col-file-manager" id="audio_col_id_' . $audio->id . '">';
                $data['content'] .= '<div class="file-box" data-audio-id="' . $audio->id . '" data-audio-name="' . $audio->audio_name . '">';
                $data['content'] .= '<div class="image-container icon-container">';
                $data['content'] .= '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($audio->audio_path, PATHINFO_EXTENSION) . '"></div>';
                $data['content'] .= '</div>';
                $data['content'] .= '<span class="file-name">' . esc($audio->audio_name) . '</span>';
                $data['content'] .= '</div> </div>';
            }
        }
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Delete Audio
     */
    public function deleteAudio()
    {
        $audioId = inputPost('audio_id');
        $this->fileModel->deleteAudio($audioId);
    }
}
