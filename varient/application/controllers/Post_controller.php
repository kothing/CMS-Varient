<?php defined('BASEPATH') or exit('No direct script access allowed');

class Post_controller extends Admin_Core_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status == 0 && $this->auth_user->role != "admin") {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url('settings'));
        }
    }

    /**
     * Post Format
     */
    public function post_format()
    {
        check_permission('add_post');
        $data['title'] = trans("choose_post_format");
        $data['admin_settings'] = $this->post_admin_model;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/post_format', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Post
     */
    public function add_post()
    {
        check_permission('add_post');
        $type = $this->input->get('type', true);
        if ($type != 'article' && $type != 'gallery' && $type != 'sorted_list' && $type != 'video' && $type != 'audio' && $type != 'trivia_quiz' && $type != 'personality_quiz') {
            redirect(admin_url() . 'post-format');
            exit();
        }
        $post_format = "post_format_" . $type;
        if ($this->general_settings->$post_format != 1) {
            redirect(admin_url() . 'post-format');
            exit();
        }
        $title = "add_" . $type;
        $data['title'] = trans($title);
        $data['post_type'] = $type;
        $data['parent_categories'] = $this->category_model->get_parent_categories_by_lang($this->selected_lang->id);

        $view = $title;
        if ($type == 'trivia_quiz' || $type == 'personality_quiz') {
            $view = 'quiz/' . $title;
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/' . $view, $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Post Post
     */
    public function add_post_post()
    {
        check_permission('add_post');
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');
        $this->form_validation->set_rules('summary', trans("summary"), 'xss_clean|max_length[5000]');
        $this->form_validation->set_rules('category_id', trans("category"), 'required');
        $this->form_validation->set_rules('optional_url', trans("optional_url"), 'xss_clean|max_length[1000]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->post_admin_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $post_type = $this->input->post('post_type', true);
            //if post added
            if ($this->post_admin_model->add_post($post_type)) {
                //last id
                $last_id = $this->db->insert_id();
                //update slug
                $this->post_admin_model->update_slug($last_id);
                //insert post tags
                $this->tag_model->add_post_tags($last_id);

                //post types
                if ($post_type == 'gallery') {
                    //insert gallery items
                    $this->post_item_model->add_post_list_items($last_id, 'gallery');
                } elseif ($post_type == "sorted_list") {
                    //insert sorted list items
                    $this->post_item_model->add_post_list_items($last_id, 'sorted_list');
                } elseif ($post_type == "audio") {
                    $this->post_file_model->add_post_audios($last_id);
                } elseif ($post_type == "article") {
                    $this->post_file_model->add_post_additional_images($last_id);
                } elseif ($post_type == 'trivia_quiz') {
                    $this->quiz_model->add_quiz_questions($last_id);
                    $this->quiz_model->add_quiz_results($last_id);
                } elseif ($post_type == 'personality_quiz') {
                    $this->quiz_model->add_quiz_results($last_id);
                    $this->quiz_model->add_quiz_questions($last_id);
                }
                //add post files
                if ($post_type != 'gallery' && $post_type != 'sorted_list') {
                    $this->post_file_model->add_post_files($last_id);
                }

                //send post
                $send_post_to_subscribes = $this->input->post('send_post_to_subscribes', true);
                if ($send_post_to_subscribes) {
                    $this->send_to_all_subscribers($last_id);
                }
                $this->session->set_flashdata('success', trans("post") . " " . trans("msg_suc_added"));
                reset_cache_data_on_change();
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->post_admin_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Update Post
     */
    public function update_post($id)
    {
        check_permission('add_post');

        //get post
        $data['post'] = $this->post_admin_model->get_post($id);
        if (empty($data['post'])) {
            redirect($this->agent->referrer());
        }
        if (!check_post_ownership($data['post']->user_id)) {
            redirect($this->agent->referrer());
        }

        $data['title'] = trans("update_" . $data['post']->post_type);
        $data['tags'] = $this->tag_model->get_post_tags_string($id);
        $data['post_images'] = $this->post_file_model->get_post_additional_images($id);
        $data['users'] = $this->auth_model->get_active_users();
        $data['admin_settings'] = $this->post_admin_model;
        //define category ids
        $category = $this->category_model->get_category($data["post"]->category_id);
        $data['parent_category_id'] = $data["post"]->category_id;
        $data['subcategory_id'] = 0;
        if (!empty($category) && $category->parent_id != 0) {
            $parent_category = $this->category_model->get_category($category->parent_id);
            if (!empty($parent_category)) {
                $data['parent_category_id'] = $parent_category->id;
                $data['subcategory_id'] = $category->id;
            }
        }

        $data['categories'] = $this->category_model->get_parent_categories_by_lang($data['post']->lang_id);
        $data['subcategories'] = $this->category_model->get_subcategories_by_parent_id($data['parent_category_id']);

        $data['post_list_items'] = $this->post_item_model->get_post_list_items($data['post']->id, $data['post']->post_type);

        $view = "update_" . $data['post']->post_type;

        if ($data['post']->post_type == 'trivia_quiz' || $data['post']->post_type == 'personality_quiz') {
            $data['title'] = trans("update_" . $data['post']->post_type);
            $view = "quiz/update_" . $data['post']->post_type;
            $data['quiz_questions'] = $this->quiz_model->get_quiz_questions($data['post']->id);
            $data['quiz_results'] = $this->quiz_model->get_quiz_results($data['post']->id);
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/' . $view, $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Post Post
     */
    public function update_post_post()
    {
        check_permission('add_post');
        //post id
        $post_id = $this->input->post('id', true);
        $post = $this->post_model->get_post_by_id($post_id);
        if (empty($post)) {
            redirect($this->agent->referrer());
        }
        if (!check_post_ownership($post->user_id)) {
            redirect($this->agent->referrer());
        }

        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');
        $this->form_validation->set_rules('summary', trans("summary"), 'xss_clean|max_length[5000]');
        $this->form_validation->set_rules('category_id', trans("category"), 'required');
        $this->form_validation->set_rules('optional_url', trans("optional_url"), 'xss_clean|max_length[1000]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->post_admin_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $post_type = $this->input->post('post_type', true);
            if ($this->post_admin_model->update_post($post_id, $post_type)) {
                //update slug
                $this->post_admin_model->update_slug($post_id);
                //update post tags
                $this->tag_model->update_post_tags($post_id);
                //post types
                if ($post_type == 'gallery') {
                    //insert gallery items
                    $this->post_item_model->update_post_list_items($post_id, 'gallery');
                } elseif ($post_type == "sorted_list") {
                    //insert sorted list items
                    $this->post_item_model->update_post_list_items($post_id, 'sorted_list');
                } elseif ($post_type == "audio") {
                    $this->post_file_model->add_post_audios($post_id);
                } elseif ($post_type == "article") {
                    $this->post_file_model->add_post_additional_images($post_id);
                } elseif ($post_type == 'trivia_quiz') {
                    $this->quiz_model->update_quiz_questions($post_id);
                    $this->quiz_model->update_quiz_results($post_id);
                } elseif ($post_type == 'personality_quiz') {
                    $this->quiz_model->update_quiz_results($post_id);
                    $this->quiz_model->update_quiz_questions($post_id);
                }

                //add post files
                if ($post_type != 'gallery' && $post_type != 'sorted_list') {
                    $this->post_file_model->add_post_files($post_id);
                }

                $this->session->set_userdata('msg_success', trans("post") . " " . trans("msg_suc_updated"));
                reset_cache_data_on_change();
            } else {
                $this->session->set_userdata('msg_error', trans("msg_error"));
            }
        }

        redirect($this->agent->referrer());
    }

    /**
     * Delete Additional Image
     */
    public function delete_post_additional_image()
    {
        check_permission('add_post');
        $file_id = $this->input->post('file_id', true);
        $this->post_file_model->delete_post_additional_image($file_id);
    }

    /**
     * Delete Post Item List Item Post
     */
    public function delete_post_list_item_post()
    {
        check_permission('add_post');
        $item_id = $this->input->post('item_id', true);
        $post_type = $this->input->post('post_type', true);
        $this->post_item_model->delete_post_list_item($item_id, $post_type);
    }

    /**
     * Get List Item HTML
     */
    public function get_list_item_html()
    {
        check_permission('add_post');
        $vars = array('new_item_order' => $this->input->post('new_item_order', true));
        $data = array(
            'result' => 1,
            'html' => $this->load->view('admin/post/_post_list_item', $vars, true)
        );
        echo json_encode($data);
    }

    /**
     * Add List Item
     */
    public function add_list_item()
    {
        check_permission('add_post');
        $post_id = $this->input->post('post_id', true);
        $post_type = $this->input->post('post_type', true);
        $list_item_id = $this->post_item_model->add_post_list_item($post_id, $post_type);
        $list_item = $this->post_item_model->get_post_list_item($list_item_id, $post_type);
        if (!empty($list_item)) {
            $vars = array('post_list_item' => $list_item);
            $data = array(
                'result' => 1,
                'html' => $this->load->view('admin/post/_post_list_item', $vars, true)
            );
        } else {
            $data = array(
                'result' => 0,
                'html' => ""
            );
        }
        echo json_encode($data);
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * AUDIO
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Delete Post Audio
     */
    public function delete_post_audio()
    {
        $post_audio_id = $this->input->post('post_audio_id', true);
        $this->post_file_model->delete_post_audio($post_audio_id);
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * VIDEO
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Get Video from URL
     */
    public function get_video_from_url()
    {
        $url = $this->input->post('url', true);
        $this->load->model('video_model');
        $data = array(
            'video_embed_code' => $this->video_model->get_video_embed_code($url),
            'video_thumbnail' => $this->video_model->get_video_thumbnail($url),
        );
        echo json_encode($data);
    }

    /**
     * Get Video Thumbnail
     */
    public function get_video_thumbnail()
    {
        $url = $this->input->post('url', true);
        echo $this->file_model->get_video_thumbnail($url);
    }

    /**
     * Delete Video
     */
    public function delete_post_video()
    {
        $post_id = $this->input->post('post_id', true);
        $this->post_file_model->delete_post_video($post_id);
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * QUIZ
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Get Quiz Question HTML
     */
    public function get_quiz_question_html()
    {
        $post_type = $this->input->post('post_type', true);
        $new_question_order = $this->input->post('new_question_order', true);
        $vars = array('post_type' => $post_type, 'new_question_order' => $new_question_order);
        $data = array(
            'result' => 1,
            'html' => $this->load->view('admin/post/quiz/_add_question', $vars, true)
        );
        echo json_encode($data);
    }

    /**
     * Add Quiz Question
     */
    public function add_quiz_question()
    {
        $post_id = $this->input->post('post_id', true);
        $post_type = $this->input->post('post_type', true);
        $question_id = $this->quiz_model->add_quiz_question($post_id);
        $question = $this->quiz_model->get_quiz_question($question_id);
        if (!empty($question)) {
            $vars = array('post_type' => $post_type, 'question' => $question);
            $data = array(
                'result' => 1,
                'html' => $this->load->view('admin/post/quiz/_update_question', $vars, true)
            );
        } else {
            $data = array(
                'result' => 0,
                'html' => ""
            );
        }
        echo json_encode($data);
    }

    /**
     * Delete Quiz Question
     */
    public function delete_quiz_question()
    {
        $question_id = $this->input->post('question_id', true);
        $this->quiz_model->delete_quiz_question($question_id);
    }

    /**
     * Get Quiz Result HTML
     */
    public function get_quiz_result_html()
    {
        $post_type = $this->input->post('post_type', true);
        $vars = array('post_type' => $post_type);
        $data = array(
            'result' => 1,
            'html' => $this->load->view('admin/post/quiz/_add_result', $vars, true)
        );
        echo json_encode($data);
    }

    /**
     * Add Quiz Result
     */
    public function add_quiz_result()
    {
        $post_id = $this->input->post('post_id', true);
        $post_type = $this->input->post('post_type', true);
        $result_id = $this->quiz_model->add_quiz_result($post_id);
        $result = $this->quiz_model->get_quiz_result($result_id);
        if (!empty($result)) {
            $vars = array('result' => $result, 'post_type' => $post_type);
            $data = array(
                'result' => 1,
                'html' => $this->load->view('admin/post/quiz/_update_result', $vars, true)
            );
        } else {
            $data = array(
                'result' => 0,
                'html' => ""
            );
        }
        echo json_encode($data);
    }

    /**
     * Delete Quiz Result
     */
    public function delete_quiz_result()
    {
        $result_id = $this->input->post('result_id', true);
        $this->quiz_model->delete_quiz_result($result_id);
    }

    /**
     * Get Quiz Answer HTML
     */
    public function get_quiz_answer_html()
    {
        $post_type = $this->input->post('post_type', true);
        $vars = array('post_type' => $post_type, 'question_id' => $this->input->post('question_id', true));
        $data = array(
            'result' => 1,
            'html' => $this->load->view('admin/post/quiz/_add_answer', $vars, true)
        );
        echo json_encode($data);
    }

    /**
     * Add Quiz Question Answer
     */
    public function add_quiz_question_answer()
    {
        $question_id = $this->input->post('question_id', true);
        $post_type = $this->input->post('post_type', true);
        $answer_id = $this->quiz_model->add_quiz_question_answer($question_id);
        $answer = $this->quiz_model->get_quiz_question_answer($answer_id);
        if (!empty($answer)) {
            $vars = array('post_type' => $post_type, 'answer' => $answer);
            $data = array(
                'result' => 1,
                'html' => $this->load->view('admin/post/quiz/_update_answer', $vars, true)
            );
        } else {
            $data = array(
                'result' => 0,
                'html' => ""
            );
        }
        echo json_encode($data);
    }

    /**
     * Delete Quiz Question Answer
     */
    public function delete_quiz_question_answer()
    {
        $answer_id = $this->input->post('answer_id', true);
        $this->quiz_model->delete_quiz_question_answer($answer_id);
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * COMMON
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Publish Draft
     */
    public function publish_draft_post()
    {
        check_permission('add_post');
        $post_id = $this->input->post('post_id', true);
        if ($this->post_admin_model->publish_draft($post_id)) {
            $this->session->set_flashdata('success', trans("post") . " " . trans("msg_suc_added"));
            $this->session->set_flashdata('msg_post_published', 1);
            reset_cache_data_on_change();
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Send to All  Subscribers
     */
    public function send_to_all_subscribers($post_id)
    {
        $post = $this->post_admin_model->get_post($post_id);
        if ($this->selected_lang->id == $post->lang_id) {
            $link = base_url() . $post->title_slug;
        } else {
            $lang = get_language($post->lang_id);
            $link = base_url() . $lang->short_form . "/" . $post->title_slug;
        }
        if (!empty($post) && $post->status == 1) {
            $post_img_url = base_url() . $post->image_big;
            if (empty($post->image_big)) {
                $post_img_url = $post->image_url;
            }
            $subject = $post->title;
            $message = "<p>" . $post->summary . "</p><p style='text-align: center'><a href='" . $link . "'><img src='" . $post_img_url . "' alt='' style='max-width: 100%; height: auto;'></a></p><br><br>" . $post->content;
            $this->load->model("email_model");
            $data['subscribers'] = $this->newsletter_model->get_subscribers();
            foreach ($data['subscribers'] as $item) {
                $this->email_model->send_email_newsletter($item, $subject, $message);
            }
        }
    }

    /**
     * Posts
     */
    public function posts()
    {
        check_permission('add_post');
        $data['title'] = trans('posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "posts";
        $data['list_type'] = "posts";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'posts', $this->post_admin_model->get_paginated_posts_count('posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Slider Posts
     */
    public function slider_posts()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('slider_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "slider-posts";
        $data['list_type'] = "slider_posts";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'slider-posts', $this->post_admin_model->get_paginated_posts_count('slider_posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'slider_posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Posts
     */
    public function featured_posts()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('featured_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "featured-posts";
        $data['list_type'] = "featured_posts";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'featured-posts', $this->post_admin_model->get_paginated_posts_count('featured_posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'featured_posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Breaking news
     */
    public function breaking_news()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('breaking_news');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "breaking-news";
        $data['list_type'] = "breaking_news";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'breaking-news', $this->post_admin_model->get_paginated_posts_count('breaking_news'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'breaking_news');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Recommended Posts
     */
    public function recommended_posts()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('recommended_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "recommended-posts";
        $data['list_type'] = "recommended_posts";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'recommended-posts', $this->post_admin_model->get_paginated_posts_count('recommended_posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'recommended_posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Posts
     */
    public function pending_posts()
    {
        check_permission('add_post');
        $data['title'] = trans('pending_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "pending-posts";
        $data['list_type'] = "pending_posts";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'pending-posts', $this->post_admin_model->get_paginated_pending_posts_count());
        $data['posts'] = $this->post_admin_model->get_paginated_pending_posts($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/pending_posts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Scheduled Posts
     */
    public function scheduled_posts()
    {
        check_permission('add_post');
        $data['title'] = trans('scheduled_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "scheduled-posts";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'scheduled-posts', $this->post_admin_model->get_paginated_scheduled_posts_count());
        $data['posts'] = $this->post_admin_model->get_paginated_scheduled_posts($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/scheduled_posts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Drafts
     */
    public function drafts()
    {
        check_permission('add_post');
        $data['title'] = trans('drafts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "drafts";
        $data['admin_settings'] = $this->post_admin_model;

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'drafts', $this->post_admin_model->get_paginated_drafts_count());
        $data['posts'] = $this->post_admin_model->get_paginated_drafts($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/drafts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Post Options Post
     */
    public function post_options_post()
    {
        $option = $this->input->post('option', true);
        $id = $this->input->post('id', true);

        $data["post"] = $this->post_admin_model->get_post($id);

        //check if exists
        if (empty($data['post'])) {
            redirect($this->agent->referrer());
        }

        //if option add remove from slider
        if ($option == 'add-remove-from-slider') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_slider($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_slider"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_slider"));
            }
        } elseif ($option == 'add-remove-from-featured') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_featured($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_featured"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_featured"));
            }
        } elseif ($option == 'add-remove-from-breaking') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_breaking($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_breaking"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_breaking"));
            }
        } elseif ($option == 'add-remove-from-recommended') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_recommended($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_recommended"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_recommended"));
            }
        } elseif ($option == 'approve') {
            check_permission('manage_all_posts');
            if ($this->post_admin_model->approve_post($id)) {
                $this->session->set_flashdata('success', trans("msg_post_approved"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        } elseif ($option == 'publish') {
            check_permission('add_post');
            if ($this->post_admin_model->publish_post($id)) {
                $this->session->set_flashdata('success', trans("msg_published"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        } elseif ($option == 'publish_draft') {
            check_permission('add_post');
            if ($this->post_admin_model->publish_draft($id)) {
                $this->session->set_flashdata('success', trans("msg_published"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        reset_cache_data_on_change();
        redirect($this->agent->referrer());
    }

    /**
     * Delete Post
     */
    public function delete_post()
    {
        check_permission('add_post');
        $id = $this->input->post('id', true);
        $data["post"] = $this->post_admin_model->get_post($id);
        //check if exists
        if (empty($data['post'])) {
            $this->session->set_flashdata('error', trans("msg_error"));
        } else {
            if ($this->post_admin_model->delete_post($id)) {
                //delete post tags
                $this->tag_model->delete_post_tags($id);
                $this->session->set_flashdata('success', trans("post") . " " . trans("msg_suc_deleted"));
                reset_cache_data_on_change();
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Post Buld Options
     */
    public function post_bulk_options()
    {
        check_permission('manage_all_posts');
        $operation = $this->input->post('operation', true);
        $post_ids = $this->input->post('post_ids', true);
        $this->post_admin_model->post_bulk_options($operation, $post_ids);
        reset_cache_data_on_change();
    }

    /**
     * Delete Selected Posts
     */
    public function delete_selected_posts()
    {
        check_permission('manage_all_posts');
        $post_ids = $this->input->post('post_ids', true);
        $this->post_admin_model->delete_multi_posts($post_ids);
        reset_cache_data_on_change();
    }

    /**
     * Save Featured Post Order
     */
    public function featured_posts_order_post()
    {
        check_permission('manage_all_posts');
        $post_id = $this->input->post('id', true);
        $order = $this->input->post('featured_order', true);
        $this->post_admin_model->save_featured_post_order($post_id, $order);
        reset_cache_data_on_change();
        redirect($this->agent->referrer());
    }

    /**
     * Save Home Slider Post Order
     */
    public function home_slider_posts_order_post()
    {
        check_permission('manage_all_posts');
        $post_id = $this->input->post('id', true);
        $order = $this->input->post('slider_order', true);
        $this->post_admin_model->save_home_slider_post_order($post_id, $order);
        reset_cache_data_on_change();
        redirect($this->agent->referrer());
    }

    /**
     * Delete Post Main Image
     */
    public function delete_post_main_image()
    {
        $post_id = $this->input->post('post_id', true);
        $this->post_file_model->delete_post_main_image($post_id);
    }

    /**
     * Delete Rss Post Main Image
     */
    public function delete_rss_post_main_image()
    {
        $post_id = $this->input->post('post_id', true);
        $this->post_file_model->delete_rss_post_main_image($post_id);
    }

    /**
     * Delete Post File
     */
    public function delete_post_file()
    {
        $id = $this->input->post('id', true);
        $this->post_file_model->delete_post_file($id);
    }

    /*
     * Set Pagination Per Page
     */
    public function set_pagination_per_page($count)
    {
        $_SESSION['pagination_per_page'] = $count;
        redirect($this->agent->referrer());
    }
}
