<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->file_count = 60;
        $this->file_per_page = 60;
        if (!check_user_permission('add_post')) {
            exit();
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * IMAGES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Image File
     */
    public function upload_image_file()
    {
        $this->file_model->upload_image();
    }

    /**
     * Get Images
     */
    public function get_images()
    {
        $images = $this->file_model->get_images($this->file_count);
        $this->print_images($images);
    }

    /**
     * Select Image File
     */
    public function select_image_file()
    {
        $file_id = $this->input->post('file_id', true);

        $file = $this->file_model->get_image($file_id);
        if (!empty($file)) {
            echo base_url() . $file->image_mid;
        }
    }

    /**
     * Laod More Images
     */
    public function load_more_images()
    {
        $min = $this->input->post('min', true);
        $images = $this->file_model->get_more_images($min, $this->file_per_page);
        $this->print_images($images);
    }

    /**
     * Search Images
     */
    public function search_image_file()
    {
        $search = trim($this->input->post('search', true));
        $images = $this->file_model->search_images($search);
        $this->print_images($images);
    }

    /**
     * Print Images
     */
    public function print_images($images)
    {
        if (!empty($images)):
            foreach ($images as $image):
                echo '<div class="col-file-manager" id="img_col_id_' . $image->id . '">';
                echo '<div class="file-box" data-file-id="' . $image->id . '" data-mid-file-path="' . $image->image_mid . '" data-default-file-path="' . $image->image_default . '" data-slider-file-path="' . $image->image_slider . '" data-big-file-path="' . $image->image_big . '" >';
                echo '<div class="image-container">';
                echo '<img src="' . base_url() . $image->image_slider . '" alt="" class="img-responsive">';
                echo '</div>';
                if (!empty($image->file_name)):
                    echo '<span class="file-name">' . html_escape($image->file_name) . '</span>';
                endif;
                echo '</div> </div>';
            endforeach;
        endif;
    }

    /**
     * Delete Image File
     */
    public function delete_image_file()
    {
        $file_id = $this->input->post('file_id', true);
        $this->file_model->delete_image($file_id);
    }


    /*
    *------------------------------------------------------------------------------------------
    * QUIZ IMAGES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Quiz Image File
     */
    public function upload_quiz_image_file()
    {
        $this->file_model->upload_quiz_image();
    }

    /**
     * Get Quiz Images
     */
    public function get_quiz_images()
    {
        $quiz_images = $this->file_model->get_quiz_images($this->file_count);
        $this->print_quiz_images($quiz_images);
    }

    /**
     * Laod More Quiz Images
     */
    public function load_more_quiz_images()
    {
        $min = $this->input->post('min', true);
        $quiz_images = $this->file_model->get_more_quiz_images($min, $this->file_per_page);
        $this->print_quiz_images($quiz_images);
    }

    /**
     * Search Quiz Images
     */
    public function search_quiz_image_file()
    {
        $search = trim($this->input->post('search', true));
        $quiz_images = $this->file_model->search_quiz_images($search);
        $this->print_quiz_images($quiz_images);
    }

    /**
     * Print Quiz Images
     */
    public function print_quiz_images($quiz_images)
    {
        if (!empty($quiz_images)):
            foreach ($quiz_images as $image):
                echo '<div class="col-file-manager" id="img_col_id_' . $image->id . '">';
                echo '<div class="file-box" data-file-id="' . $image->id . '" data-default-file-path="' . $image->image_default . '" data-small-file-path="' . $image->image_small . '">';
                echo '<div class="image-container">';
                echo '<img src="' . base_url() . $image->image_small . '" alt="" class="img-responsive">';
                echo '</div>';
                if (!empty($image->file_name)):
                    echo '<span class="file-name">' . html_escape($image->file_name) . '</span>';
                endif;
                echo '</div> </div>';
            endforeach;
        endif;
    }

    /**
     * Delete Quiz Image File
     */
    public function delete_quiz_image_file()
    {
        $file_id = $this->input->post('file_id', true);
        $this->file_model->delete_quiz_image($file_id);
    }


    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload File
     */
    public function upload_file()
    {
        $this->file_model->upload_file();
    }

    /**
     * Get Files
     */
    public function get_files()
    {
        $files = $this->file_model->get_files($this->file_count);
        $this->print_files($files);
    }

    /**
     * Laod More Files
     */
    public function load_more_files()
    {
        $min = $this->input->post('min', true);
        $files = $this->file_model->get_more_files($min, $this->file_per_page);
        $this->print_files($files);
    }

    /**
     * Search Files
     */
    public function search_files()
    {
        $search = trim($this->input->post('search', true));
        $files = $this->file_model->search_files($search);
        $this->print_files($files);
    }

    /**
     * Print Files
     */
    public function print_files($files)
    {
        if (!empty($files)):
            foreach ($files as $file):
                echo '<div class="col-file-manager" id="file_col_id_' . $file->id . '">';
                echo '<div class="file-box" data-file-id="' . $file->id . '" data-file-name="' . $file->file_name . '">';
                echo '<div class="image-container icon-container">';
                echo '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($file->file_name, PATHINFO_EXTENSION) . '"></div>';
                echo '</div>';
                echo '<span class="file-name">' . html_escape($file->file_name) . '</span>';
                echo '</div> </div>';
            endforeach;
        endif;
    }

    /**
     * Delete File
     */
    public function delete_file()
    {
        $file_id = $this->input->post('file_id', true);
        $this->file_model->delete_file($file_id);
    }


    /*
    *------------------------------------------------------------------------------------------
    * VIDEOS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Video
     */
    public function upload_video()
    {
        $this->file_model->upload_video();
    }

    /**
     * Get Videos
     */
    public function get_videos()
    {
        $videos = $this->file_model->get_videos($this->file_count);
        $this->print_videos($videos);
    }

    /**
     * Laod More Videos
     */
    public function load_more_videos()
    {
        $min = $this->input->post('min', true);
        $videos = $this->file_model->get_more_videos($min, $this->file_per_page);
        $this->print_videos($videos);
    }

    /**
     * Search Videos
     */
    public function search_videos()
    {
        $search = trim($this->input->post('search', true));
        $videos = $this->file_model->search_videos($search);
        $this->print_videos($videos);
    }

    /**
     * Print Videos
     */
    public function print_videos($videos)
    {
        if (!empty($videos)):
            foreach ($videos as $video):
                echo '<div class="col-file-manager" id="video_col_id_' . $video->id . '">';
                echo '<div class="file-box" data-video-id="' . $video->id . '" data-video-path="' . $video->video_path . '">';
                echo '<div class="image-container icon-container">';
                echo '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($video->video_name, PATHINFO_EXTENSION) . '"></div>';
                echo '</div>';
                echo '<span class="file-name">' . html_escape($video->video_name) . '</span>';
                echo '</div> </div>';
            endforeach;
        endif;
    }

    /**
     * Delete Video
     */
    public function delete_video()
    {
        $video_id = $this->input->post('video_id', true);
        $this->file_model->delete_video($video_id);
    }


    /*
    *------------------------------------------------------------------------------------------
    * AUDIOS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Upload Audio
     */
    public function upload_audio()
    {
        $this->file_model->upload_audio();
    }

    /**
     * Get Audios
     */
    public function get_audios()
    {
        $audios = $this->file_model->get_audios($this->file_count);
        $this->print_audios($audios);
    }

    /**
     * Laod More Audios
     */
    public function load_more_audios()
    {
        $min = $this->input->post('min', true);
        $audios = $this->file_model->get_more_audios($min, $this->file_per_page);
        $this->print_audios($audios);
    }

    /**
     * Search Audios
     */
    public function search_audios()
    {
        $search = trim($this->input->post('search', true));
        $audios = $this->file_model->search_audios($search);
        $this->print_audios($audios);
    }

    /**
     * Print Audios
     */
    public function print_audios($audios)
    {
        if (!empty($audios)):
            foreach ($audios as $audio):
                echo '<div class="col-file-manager" id="audio_col_id_' . $audio->id . '">';
                echo '<div class="file-box" data-audio-id="' . $audio->id . '" data-audio-name="' . $audio->audio_name . '">';
                echo '<div class="image-container icon-container">';
                echo '<div class="file-icon file-icon-lg" data-type="' . @pathinfo($audio->audio_path, PATHINFO_EXTENSION) . '"></div>';
                echo '</div>';
                echo '<span class="file-name">' . html_escape($audio->audio_name) . '</span>';
                echo '</div> </div>';
            endforeach;
        endif;
    }

    /**
     * Delete Audio
     */
    public function delete_audio()
    {
        $audio_id = $this->input->post('audio_id', true);
        $this->file_model->delete_audio($audio_id);
    }
}
