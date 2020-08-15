<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model
{
    /*
    *------------------------------------------------------------------------------------------
    * IMAGES
    *------------------------------------------------------------------------------------------
    */

    //upload image
    public function upload_image()
    {
        $this->load->model('upload_model');
        $temp_data = $this->upload_model->upload_temp_image('file', 'array');
        if (!empty($temp_data)) {
            $temp_path = $temp_data['full_path'];
            if ($temp_data['image_type'] == 'gif') {
                $gif_path = $this->upload_model->post_gif_image_upload($temp_data['file_name']);
                $data["image_big"] = $gif_path;
                $data["image_default"] = $gif_path;
                $data["image_slider"] = $gif_path;
                $data["image_mid"] = $gif_path;
                $data["image_small"] = $gif_path;
                $data["image_mime"] = 'gif';
                $data["file_name"] = @$temp_data['client_name'];
            } else {
                $data["image_big"] = $this->upload_model->post_big_image_upload($temp_path);
                $data["image_default"] = $this->upload_model->post_default_image_upload($temp_path);
                $data["image_slider"] = $this->upload_model->post_slider_image_upload($temp_path);
                $data["image_mid"] = $this->upload_model->post_mid_image_upload($temp_path);
                $data["image_small"] = $this->upload_model->post_small_image_upload($temp_path);
                $data["image_mime"] = 'jpg';
                $data["file_name"] = @$temp_data['client_name'];
            }

            $this->insert_image($data);
            $this->upload_model->delete_temp_image($temp_path);
        }
    }

    //get image
    public function get_image($id)
    {
        $sql = "SELECT * FROM images WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get images
    public function get_images($limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM images WHERE user_id = ? ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM images ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($limit)));
        }
        return $query->result();
    }

    //get more images
    public function get_more_images($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM images WHERE images.id < ? AND user_id = ? ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM images WHERE images.id < ? ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($limit)));
        }
        return $query->result();
    }

    //search images
    public function search_images($search)
    {
        $like = '%' . $search . '%';
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM images WHERE user_id = ? AND images.file_name LIKE ? ORDER BY images.id DESC";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), $like));
        } else {
            $sql = "SELECT * FROM images WHERE images.file_name LIKE ? ORDER BY images.id DESC";
            $query = $this->db->query($sql, array($like));
        }
        return $query->result();
    }

    //insert image
    function insert_image($data)
    {
        $ci =& get_instance();
        $ci->load->database();
        // Connect to the database
        $mysqli = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $ci->db->database);
        $mysqli->query("SET CHARACTER SET utf8");
        $mysqli->query("SET NAMES utf8");

        $image_big = $ci->security->xss_clean($data["image_big"]);
        $image_default = $ci->security->xss_clean($data["image_default"]);
        $image_slider = $ci->security->xss_clean($data["image_slider"]);
        $image_mid = $ci->security->xss_clean($data["image_mid"]);
        $image_small = $ci->security->xss_clean($data["image_small"]);
        $image_mime = $ci->security->xss_clean($data["image_mime"]);
        $file_name = $ci->security->xss_clean($data["file_name"]);
        // Check for errors
        if (!mysqli_connect_errno()) {
            $mysqli->query("INSERT INTO `images` (`image_big`, `image_default`, `image_slider`, `image_mid`, `image_small`, `image_mime`,`file_name`, `user_id`) VALUES ('" . $image_big . "','" . $image_default . "','" . $image_slider . "','" . $image_mid . "','" . $image_small . "','" . $image_mime . "','" . $file_name . "','" . $this->auth_user->id . "');");
        }
        // Close the connection
        $mysqli->close();
    }

    //delete image
    public function delete_image($id)
    {
        $image = $this->get_image($id);
        if (!empty($image)) {
            //delete image from server
            delete_file_from_server($image->image_big);
            delete_file_from_server($image->image_default);
            delete_file_from_server($image->image_slider);
            delete_file_from_server($image->image_mid);
            delete_file_from_server($image->image_small);
            $this->db->where('id', $id);
            $this->db->delete('images');
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * QUIZ IMAGES
    *------------------------------------------------------------------------------------------
    */

    //upload quiz image
    public function upload_quiz_image()
    {
        $this->load->model('upload_model');
        $temp_data = $this->upload_model->upload_temp_image('file', 'array');
        if (!empty($temp_data)) {
            $temp_path = $temp_data['full_path'];
            if ($temp_data['image_type'] == 'gif') {
                $gif_path = $this->upload_model->quiz_gif_image_upload($temp_data['file_name']);
                $data["image_default"] = $gif_path;
                $data["image_small"] = $gif_path;
                $data["image_mime"] = 'gif';
                $data["file_name"] = @$temp_data['client_name'];
            } else {
                $data["image_default"] = $this->upload_model->quiz_default_image_upload($temp_path);
                $data["image_small"] = $this->upload_model->quiz_small_image_upload($temp_path);
                $data["image_mime"] = 'jpg';
                $data["file_name"] = @$temp_data['client_name'];
            }
            $this->insert_quiz_image($data);
            $this->upload_model->delete_temp_image($temp_path);
        }
    }

    //get quiz image
    public function get_quiz_image($id)
    {
        $sql = "SELECT * FROM quiz_images WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get quiz images
    public function get_quiz_images($limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM quiz_images WHERE user_id = ? ORDER BY id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM quiz_images ORDER BY id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($limit)));
        }
        return $query->result();
    }

    //get more quiz images
    public function get_more_quiz_images($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM quiz_images WHERE id < ? AND user_id = ? ORDER BY id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM quiz_images WHERE id < ? ORDER BY id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($limit)));
        }
        return $query->result();
    }

    //search quiz images
    public function search_quiz_images($search)
    {
        $like = '%' . $search . '%';
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM quiz_images WHERE user_id = ? AND file_name LIKE ? ORDER BY id DESC";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), $like));
        } else {
            $sql = "SELECT * FROM quiz_images WHERE file_name LIKE ? ORDER BY id DESC";
            $query = $this->db->query($sql, array($like));
        }
        return $query->result();
    }

    //insert quiz image
    function insert_quiz_image($data)
    {
        $ci =& get_instance();
        $ci->load->database();
        // Connect to the database
        $mysqli = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $ci->db->database);
        $mysqli->query("SET CHARACTER SET utf8");
        $mysqli->query("SET NAMES utf8");

        $image_default = $ci->security->xss_clean($data["image_default"]);
        $image_small = $ci->security->xss_clean($data["image_small"]);
        $file_name = $ci->security->xss_clean($data["file_name"]);
        $image_mime = $ci->security->xss_clean($data["image_mime"]);

        // Check for errors
        if (!mysqli_connect_errno()) {
            $mysqli->query("INSERT INTO `quiz_images` (`image_default`, `image_small`, `file_name`, `image_mime`, `user_id`) VALUES ('" . $image_default . "', '" . $image_small . "','" . $file_name . "','" . $image_mime . "','" . $this->auth_user->id . "');");
        }
        // Close the connection
        $mysqli->close();
    }

    //delete quiz image
    public function delete_quiz_image($id)
    {
        $quiz_image = $this->get_quiz_image($id);
        if (!empty($quiz_image)) {
            //delete quiz image from server
            delete_file_from_server($quiz_image->image_default);
            delete_file_from_server($quiz_image->image_small);
            $this->db->where('id', $id);
            $this->db->delete('quiz_images');
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    //upload file
    public function upload_file()
    {
        $this->load->model('upload_model');
        $file_array = $this->upload_model->upload_file('file');
        if (!empty($file_array)) {
            $this->insert_file($file_array);
        }
    }

    //add file to database
    function insert_file($data)
    {
        $ci =& get_instance();
        $ci->load->database();
        // Connect to the database
        $mysqli = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $ci->db->database);
        $mysqli->query("SET CHARACTER SET utf8");
        $mysqli->query("SET NAMES utf8");

        $file_name = $ci->security->xss_clean($data["file_name"]);
        $file_path = $ci->security->xss_clean($data["file_path"]);
        // Check for errors
        if (!mysqli_connect_errno()) {
            $mysqli->query("INSERT INTO `files` (`file_name`,`file_path`,`user_id`) VALUES (" . $ci->db->escape($file_name) . "," . $ci->db->escape($file_path) . "," . $this->auth_user->id . ");");
        }
        // Close the connection
        $mysqli->close();
    }

    //get files
    public function get_files($limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM files WHERE user_id = ? ORDER BY files.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM files ORDER BY files.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($limit)));
        }
        return $query->result();
    }

    //get file
    public function get_file($id)
    {
        $sql = "SELECT * FROM files WHERE files.id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get more files
    public function get_more_files($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM files WHERE files.id < ? AND user_id = ? ORDER BY files.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM files WHERE files.id < ? ORDER BY files.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($limit)));
        }
        return $query->result();
    }

    //search files
    public function search_files($search)
    {
        $like = '%' . $search . '%';
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM files WHERE user_id = ? AND files.file_name LIKE ? ORDER BY files.id DESC";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), $like));
        } else {
            $sql = "SELECT * FROM files WHERE files.file_name LIKE ? ORDER BY files.id DESC";
            $query = $this->db->query($sql, array($like));
        }
        return $query->result();
    }

    //delete file
    public function delete_file($id)
    {
        $file = $this->get_file($id);
        if (!empty($file)) {
            //delete file from server
            delete_file_from_server($file->file_path);
            $this->db->where('id', $id);
            $this->db->delete('files');
        }
    }


    /*
    *------------------------------------------------------------------------------------------
    * VIDEOS
    *------------------------------------------------------------------------------------------
    */

    //upload video
    public function upload_video()
    {
        $this->load->model('upload_model');
        $video_file = $this->upload_model->upload_video('file');
        if (!empty($video_file)) {
            $this->insert_video($video_file);
        }
    }

    //add video to database
    function insert_video($data)
    {
        $ci =& get_instance();
        $ci->load->database();
        // Connect to the database
        $mysqli = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $ci->db->database);
        $mysqli->query("SET CHARACTER SET utf8");
        $mysqli->query("SET NAMES utf8");

        $video_name = $ci->security->xss_clean($data["video_name"]);
        $video_path = $ci->security->xss_clean($data["video_path"]);
        // Check for errors
        if (!mysqli_connect_errno()) {
            $mysqli->query("INSERT INTO `videos` (`video_name`,`video_path`,`user_id`) VALUES (" . $ci->db->escape($video_name) . "," . $ci->db->escape($video_path) . "," . $this->auth_user->id . ");");
        }
        // Close the connection
        $mysqli->close();
    }

    //get videos
    public function get_videos($limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM videos WHERE user_id = ? ORDER BY videos.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM videos ORDER BY videos.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($limit)));
        }
        return $query->result();
    }

    //get video
    public function get_video($id)
    {
        $sql = "SELECT * FROM videos WHERE videos.id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get more videos
    public function get_more_videos($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM videos WHERE videos.id < ? AND user_id = ? ORDER BY videos.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM videos WHERE videos.id < ? ORDER BY videos.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($limit)));
        }
        return $query->result();
    }

    //search videos
    public function search_videos($search)
    {
        $like = '%' . $search . '%';
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM videos WHERE user_id = ? AND videos.video_name LIKE ? ORDER BY videos.id DESC";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), $like));
        } else {
            $sql = "SELECT * FROM videos WHERE videos.video_name LIKE ? ORDER BY videos.id DESC";
            $query = $this->db->query($sql, array($like));
        }
        return $query->result();
    }

    //delete video
    public function delete_video($id)
    {
        $video = $this->get_video($id);
        if (!empty($video)) {
            //delete from server
            delete_file_from_server($video->video_path);
            $this->db->where('id', $video->id);
            $this->db->delete('videos');
        }
    }


    /*
   *------------------------------------------------------------------------------------------
   * AUDIOS
   *------------------------------------------------------------------------------------------
   */

    //upload audio
    public function upload_audio()
    {
        $this->load->model('upload_model');
        $audio_path = $this->upload_model->upload_audio('file');
        if (!empty($audio_path)) {
            $data["audio_name"] = trim($this->input->post('audio_name', true));
            $data["download_button"] = $this->input->post('download_button', true);
            $data["audio_path"] = $audio_path;
            $this->insert_audio($data);
        }
    }

    //add audio to database
    function insert_audio($data)
    {
        $ci =& get_instance();
        $ci->load->database();
        // Connect to the database
        $mysqli = new mysqli($ci->db->hostname, $ci->db->username, $ci->db->password, $ci->db->database);
        $mysqli->query("SET CHARACTER SET utf8");
        $mysqli->query("SET NAMES utf8");

        $audio_name = $ci->security->xss_clean($data["audio_name"]);
        $audio_path = $ci->security->xss_clean($data["audio_path"]);
        $download_button = $ci->security->xss_clean($data["download_button"]);

        // Check for errors
        if (!mysqli_connect_errno()) {
            $mysqli->query("INSERT INTO `audios` (`audio_name`,`audio_path`,`download_button`,`user_id`) VALUES (" . $ci->db->escape($audio_name) . "," . $ci->db->escape($audio_path) . "," . $ci->db->escape($download_button) . "," . $this->auth_user->id . ");");
        }
        // Close the connection
        $mysqli->close();
    }

    //get audios
    public function get_audios($limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM audios WHERE user_id = ? ORDER BY audios.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM audios ORDER BY audios.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($limit)));
        }
        return $query->result();
    }

    //get audio
    public function get_audio($id)
    {
        $sql = "SELECT * FROM audios WHERE audios.id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get more audios
    public function get_more_audios($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM audios WHERE audios.id < ? AND user_id = ? ORDER BY audios.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($this->auth_user->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM audios WHERE audios.id < ? ORDER BY audios.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($limit)));
        }
        return $query->result();
    }

    //search audios
    public function search_audios($search)
    {
        $like = '%' . $search . '%';
        if ($this->general_settings->file_manager_show_files != 1) {
            $sql = "SELECT * FROM audios WHERE user_id = ? AND audios.audio_name LIKE ? ORDER BY audios.id DESC";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id), $like));
        } else {
            $sql = "SELECT * FROM audios WHERE audios.audio_name LIKE ? ORDER BY audios.id DESC";
            $query = $this->db->query($sql, array($like));
        }
        return $query->result();
    }

    //delete audio
    public function delete_audio($id)
    {
        $audio = $this->get_audio($id);
        if (!empty($audio)) {
            //delete from server
            delete_file_from_server($audio->audio_path);
            $this->db->where('id', $audio->id);
            $this->db->delete('audios');
        }
    }
}