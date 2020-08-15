<?php defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH . "third_party/image-resize/ImageResize.php";
include APPPATH . "third_party/image-resize/ImageResizeException.php";

use \Gumlet\ImageResize;
use \Gumlet\ImageResizeException;

class Upload_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->img_quality = 85;
    }

    //upload temp image
    public function upload_temp_image($file_name, $response)
    {
        if (isset($_FILES[$file_name])) {
            if (empty($_FILES[$file_name]['name'])) {
                return null;
            }
        }
        $config['upload_path'] = './uploads/tmp/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = 'img_' . generate_unique_id();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                if ($response == 'array') {
                    return $data['upload_data'];
                } else {
                    return $data['upload_data']['full_path'];
                }
            }
            return null;
        } else {
            return null;
        }
    }

    //post gif image upload
    public function post_gif_image_upload($file_name)
    {
        $date_directory = $this->create_directory_by_date('images');
        rename(FCPATH . 'uploads/tmp/' . $file_name, FCPATH . 'uploads/images/' . $date_directory . $file_name);
        return 'uploads/images/' . $date_directory . $file_name;
    }

    //post big image upload
    public function post_big_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('images');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->crop(750, 500, true);
            $new_path = 'uploads/images/' . $date_directory . 'image_750x500_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //post default image upload
    public function post_default_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('images');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->resizeToWidth(750);
            $new_path = 'uploads/images/' . $date_directory . 'image_750x_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //post slider image upload
    public function post_slider_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('images');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->crop(600, 460, true);
            $new_path = 'uploads/images/' . $date_directory . 'image_600x460_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //post mid image upload
    public function post_mid_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('images');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->crop(380, 226, true);
            $new_path = 'uploads/images/' . $date_directory . 'image_380x226_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //post small image upload
    public function post_small_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('images');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->crop(140, 98, true);
            $new_path = 'uploads/images/' . $date_directory . 'image_140x98_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //quiz gif image upload
    public function quiz_gif_image_upload($file_name)
    {
        $date_directory = $this->create_directory_by_date('quiz');
        rename(FCPATH . 'uploads/tmp/' . $file_name, FCPATH . 'uploads/quiz/' . $date_directory . $file_name);
        return 'uploads/quiz/' . $date_directory . $file_name;
    }

    //quiz default image upload
    public function quiz_default_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('quiz');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->crop(750, 500, true);
            $new_path = 'uploads/quiz/' . $date_directory . 'image_750x_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //quiz small image upload
    public function quiz_small_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('quiz');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->crop(370, 370, true);
            $new_path = 'uploads/quiz/' . $date_directory . 'image_370_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //gallery big image upload
    public function gallery_big_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('gallery');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->resizeToWidth(1920);
            $new_path = 'uploads/gallery/' . $date_directory . 'image_1920x_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //gallery small image upload
    public function gallery_small_image_upload($path)
    {
        try {
            $date_directory = $this->create_directory_by_date('gallery');
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->resizeToWidth(500);
            $new_path = 'uploads/gallery/' . $date_directory . 'image_500x_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //gallery gif image upload
    public function gallery_gif_image_upload($file_name)
    {
        $date_directory = $this->create_directory_by_date('gallery');
        rename(FCPATH . 'uploads/tmp/' . $file_name, FCPATH . 'uploads/gallery/' . $date_directory . $file_name);
        return 'uploads/gallery/' . $date_directory . $file_name;
    }

    //avatar image upload
    public function avatar_upload($user_id, $path)
    {
        try {
            $image = new ImageResize($path);
            $image->quality_jpg = $this->img_quality;
            $image->crop(240, 240, true);
            $new_path = 'uploads/profile/avatar_' . $user_id . '_' . uniqid() . '.jpg';
            $image->save(FCPATH . $new_path, IMAGETYPE_JPEG);
            return $new_path;
        } catch (ImageResizeException $e) {
            return null;
        }
    }

    //logo image upload
    public function logo_upload($file_name)
    {
        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|svg';
        $config['file_name'] = 'logo_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/logo/' . $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //favicon image upload
    public function favicon_upload($file_name)
    {
        $config['upload_path'] = './uploads/logo/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = 'favicon_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/logo/' . $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //ad upload
    public function ad_upload($file_name)
    {
        $config['upload_path'] = './uploads/blocks/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name'] = 'block_' . uniqid();
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/blocks/' . $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //upload file
    public function upload_file($file_name)
    {
        $date_directory = $this->create_directory_by_date('files');
        $name = $this->generate_file_name($file_name);
        if (empty($name)) {
            $name = "file_" . uniqid();
        }
        $config['upload_path'] = './uploads/files/' . $date_directory;
        $config['allowed_types'] = '*';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                $file_array = array(
                    'file_name' => $data['upload_data']['file_name'],
                    'file_path' => 'uploads/files/' . $date_directory . $data['upload_data']['file_name']
                );
                return $file_array;
            }
            return null;
        } else {
            return null;
        }
    }

    //upload video
    public function upload_video($file_name)
    {
        $date_directory = $this->create_directory_by_date('videos');
        $name = $this->generate_file_name($file_name);
        if (empty($name)) {
            $name = "video_" . uniqid();
        }
        $config['upload_path'] = './uploads/videos/' . $date_directory;
        $config['allowed_types'] = '*';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                $file_array = array(
                    'video_name' => $data['upload_data']['file_name'],
                    'video_path' => 'uploads/videos/' . $date_directory . $data['upload_data']['file_name']
                );
                return $file_array;
            }
            return null;
        } else {
            return null;
        }
    }

    //upload audio
    public function upload_audio($file_name)
    {
        $date_directory = $this->create_directory_by_date('audios');
        $name = $this->generate_file_name($file_name);
        if (empty($name)) {
            $name = "audio_" . uniqid();
        }
        $config['upload_path'] = './uploads/audios/' . $date_directory;
        $config['allowed_types'] = '*';
        $config['file_name'] = $name;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload($file_name)) {
            $data = array('upload_data' => $this->upload->data());
            if (isset($data['upload_data']['full_path'])) {
                return 'uploads/audios/' . $date_directory . $data['upload_data']['file_name'];
            }
            return null;
        } else {
            return null;
        }
    }

    //create directory by date
    public function create_directory_by_date($target_folder)
    {
        $year = date("Y");
        $month = date("m");

        $directory_year = FCPATH . "uploads/" . $target_folder . "/" . $year . "/";
        $directory_month = FCPATH . "uploads/" . $target_folder . "/" . $year . "/" . $month . "/";

        //If the directory doesn't already exists.
        if (!is_dir($directory_month)) {
            //Create directory.
            @mkdir($directory_month, 0755, true);
        }

        //add index.html if does not exist
        if (!file_exists($directory_year . "index.html")) {
            copy(BASEPATH . "core/index.html", $directory_year . "index.html");
        }
        if (!file_exists($directory_month . "index.html")) {
            copy(BASEPATH . "core/index.html", $directory_month . "index.html");
        }

        return $year . "/" . $month . "/";
    }

    //check file mime type
    public function check_file_mime_type($file_name, $allowed_types)
    {
        if (!isset($_FILES[$file_name])) {
            return false;
        }
        if (empty($_FILES[$file_name]['name'])) {
            return false;
        }
        $ext = pathinfo($_FILES[$file_name]['name'], PATHINFO_EXTENSION);
        if (in_array($ext, $allowed_types)) {
            return true;
        }
        return false;
    }

    //generate file name
    public function generate_file_name($file_name)
    {
        if (!empty($_FILES[$file_name]['name'])) {
            $name = @pathinfo(@$_FILES[$file_name]['name'], PATHINFO_FILENAME);
            $name = str_replace('.', '-', $name);
            return str_slug($name);
        }
    }

    //get file original name
    public function get_file_original_name($file)
    {
        if (!empty($file['name'])) {
            return pathinfo($file['name'], PATHINFO_FILENAME);
        }
        return '';
    }

    //get file original name with extension
    public function get_file_original_name_with_extension($data)
    {
        if (!empty($data['name'])) {
            return $data['name'];
        }
        return '';
    }

    //get file name without extension
    public function get_file_name_without_extension($file_name)
    {
        if (!empty($file_name)) {
            return @mb_convert_encoding((string)pathinfo($file_name, PATHINFO_FILENAME), 'UTF-8', 'auto');
        }
        return '';
    }

    //get file type
    public function get_file_type($file_name)
    {
        if (!empty($_FILES[$file_name]['name'])) {
            $ext = pathinfo($_FILES[$file_name]['name'], PATHINFO_EXTENSION);
            if ($ext == 'mp3' || $ext == 'MP3' || $ext == 'wav' || $ext == 'WAV' || $ext == 'ogg' || $ext == 'OGG' || $ext == 'm3u' || $ext == 'M3U') {
                return 'audio';
            } elseif ($ext == 'mp4' || $ext == 'MP4' || $ext == 'webm' || $ext == 'WEBM') {
                return 'video';
            }
        }
        return 'file';
    }

    //delete temp image
    public function delete_temp_image($path)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}