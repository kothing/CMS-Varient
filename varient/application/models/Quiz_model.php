<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model
{

    /*
    *-------------------------------------------------------------------------------------------------
    * QUESTION
    *-------------------------------------------------------------------------------------------------
    */

    //add quiz questions
    public function add_quiz_questions($post_id)
    {
        $question_titles = $this->input->post('question_title', true);
        $question_images = $this->input->post('question_image', true);
        $question_descriptions = $this->input->post('question_description', false);
        $question_orders = $this->input->post('question_order', true);
        $question_unique_ids = $this->input->post('question_unique_id', true);
        $answer_formats = $this->input->post('answer_format', true);

        if (!empty($question_titles)) {
            for ($i = 0; $i < count($question_titles); $i++) {
                $data = array(
                    'post_id' => $post_id,
                    'question' => !empty($question_titles[$i]) ? $question_titles[$i] : '',
                    'image_path' => !empty($question_images[$i]) ? $question_images[$i] : '',
                    'description' => !empty($question_descriptions[$i]) ? $question_descriptions[$i] : '',
                    'question_order' => !empty($question_orders[$i]) ? $question_orders[$i] : '',
                    'answer_format' => !empty($answer_formats[$i]) ? $answer_formats[$i] : 'small_image'
                );
                //add to database
                if ($this->db->insert('quiz_questions', $data)) {
                    //add answers
                    $last_id = $this->db->insert_id();
                    $this->add_quiz_answers($post_id, $last_id, @$question_unique_ids[$i]);
                }
            }
        }
    }

    //add quiz question
    public function add_quiz_question($post_id)
    {
        //find max order value of questions
        $max_order = $this->get_quiz_question_max_order($post_id);
        if (empty($max_order)) {
            $max_order = 0;
        }
        $data = array(
            'post_id' => $post_id,
            'question' => "",
            'image_path' => "",
            'description' => "",
            'question_order' => $max_order + 1,
            'answer_format' => "small_image"
        );
        //add to database
        $this->db->insert('quiz_questions', $data);
        $last_id = $this->db->insert_id();
        //add two answers
        $this->add_quiz_question_answer($last_id);
        $this->add_quiz_question_answer($last_id);
        return $last_id;
    }

    //update quiz questions
    public function update_quiz_questions($post_id)
    {
        $questions = $this->get_quiz_questions($post_id);
        if (!empty($questions)) {
            foreach ($questions as $question) {
                $data = array(
                    'question' => $this->input->post('question_title_' . $question->id, true),
                    'image_path' => $this->input->post('question_image_' . $question->id, true),
                    'description' => $this->input->post('question_description_' . $question->id, false),
                    'question_order' => $this->input->post('question_order_' . $question->id, true),
                    'answer_format' => $this->input->post('answer_format_' . $question->id, true)
                );
                $this->db->where('id', $question->id);
                $this->db->update('quiz_questions', $data);

                //update quiz answers
                $this->update_quiz_answers($post_id, $question->id);
            }
        }

        //add new quiz questions
        $this->add_quiz_questions($post_id);
    }

    //get quiz questions
    public function get_quiz_questions($post_id)
    {
        $sql = "SELECT * FROM quiz_questions WHERE post_id = ? ORDER BY question_order";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->result();
    }

    //get quiz question
    public function get_quiz_question($question_id)
    {
        $sql = "SELECT * FROM quiz_questions WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($question_id)));
        return $query->row();
    }

    //get quiz question max order value
    public function get_quiz_question_max_order($post_id)
    {
        $sql = "SELECT MAX(question_order) AS max_order FROM quiz_questions WHERE post_id = ?";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->row()->max_order;
    }

    //delete quiz question
    public function delete_quiz_question($question_id)
    {
        $question = $this->get_quiz_question($question_id);
        if (!empty($question)) {
            //delete quiz question answers
            $this->delete_quiz_question_answers($question->id);
            //delete
            $this->db->where('id', $question->id);
            $this->db->delete('quiz_questions');
        }
    }

    //delete quiz questions
    public function delete_quiz_questions($post_id)
    {
        $questions = $this->get_quiz_questions($post_id);
        if (!empty($questions)) {
            foreach ($questions as $question) {
                $this->delete_quiz_question($question->id);
            }
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * ANSWER
    *-------------------------------------------------------------------------------------------------
    */

    //add quiz answers
    public function add_quiz_answers($post_id, $question_id, $question_element_id)
    {
        $post = $this->post_admin_model->get_post($post_id);
        if (!empty($post)) {
            if (!empty($question_id) && !empty($question_element_id)) {
                $answer_texts = $this->input->post('answer_text_question_' . $question_element_id, true);
                $answer_images = $this->input->post('answer_image_question_' . $question_element_id, true);
                $answer_unique_ids = $this->input->post('answer_unique_id_question_' . $question_element_id, true);
                $result_orders = $this->input->post('answer_selected_result_question_' . $question_element_id, true);
                $is_correct = 0;
                $assigned_result_id = 0;
                if (!empty($answer_texts)) {
                    for ($i = 0; $i < count($answer_texts); $i++) {
                        //find correct answer
                        if ($post->post_type == "trivia_quiz") {
                            $selected_answer = $this->input->post('correct_answer_question_' . $question_element_id, true);
                            $is_correct = !empty($answer_unique_ids[$i]) && ($answer_unique_ids[$i] == $selected_answer) ? 1 : 0;
                        }
                        //find selected result id
                        if ($post->post_type == "personality_quiz") {
                            if (!empty($result_orders[$i])) {
                                $result = $this->get_quiz_result_by_order_number($post->id, $result_orders[$i]);
                                if (!empty($result)) {
                                    $assigned_result_id = $result->id;
                                }
                            }
                        }
                        $data = array(
                            'question_id' => $question_id,
                            'image_path' => !empty($answer_images[$i]) ? $answer_images[$i] : '',
                            'answer_text' => !empty($answer_texts[$i]) ? $answer_texts[$i] : '',
                            'is_correct' => $is_correct,
                            'assigned_result_id' => $assigned_result_id
                        );

                        //add to database
                        $this->db->insert('quiz_answers', $data);
                    }
                }
            }
        }
    }

    //add quiz question answer
    public function add_quiz_question_answer($question_id)
    {
        $data = array(
            'question_id' => $question_id,
            'image_path' => "",
            'answer_text' => "",
            'is_correct' => 0,
        );
        //add to database
        $this->db->insert('quiz_answers', $data);
        return $this->db->insert_id();
    }

    //update quiz answers
    public function update_quiz_answers($post_id, $question_id)
    {
        $post = $this->post_admin_model->get_post($post_id);
        if (!empty($post)) {
            $answers = $this->get_quiz_question_answers($question_id);
            if (!empty($answers)) {
                foreach ($answers as $answer) {
                    $is_correct = 0;
                    $assigned_result_id = 0;
                    //find correct answer
                    if ($post->post_type == "trivia_quiz") {
                        $correct_answer_id = $this->input->post('correct_answer_q' . $question_id, true);
                        $is_correct = !empty($correct_answer_id) && ($correct_answer_id == $answer->id) ? 1 : 0;
                    }
                    //find selected result id
                    if ($post->post_type == "personality_quiz") {
                        $result_order = $this->input->post('answer_selected_result_' . $answer->id, true);
                        $result = $this->get_quiz_result_by_order_number($post->id, $result_order);
                        if (!empty($result)) {
                            $assigned_result_id = $result->id;
                        }
                    }
                    $data = array(
                        'image_path' => $this->input->post('answer_image_' . $answer->id, true),
                        'answer_text' => $this->input->post('answer_text_' . $answer->id, true),
                        'is_correct' => $is_correct,
                        'assigned_result_id' => $assigned_result_id
                    );
                    $this->db->where('id', $answer->id);
                    $this->db->update('quiz_answers', $data);
                }
            }
        }
    }

    //get quiz question answers
    public function get_quiz_question_answers($question_id)
    {
        $sql = "SELECT * FROM quiz_answers WHERE question_id = ? ORDER BY id";
        $query = $this->db->query($sql, array(clean_number($question_id)));
        return $query->result();
    }

    //get quiz question answer
    public function get_quiz_question_answer($answer_id)
    {
        $sql = "SELECT * FROM quiz_answers WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($answer_id)));
        return $query->row();
    }

    //get quiz question correct answer
    public function get_quiz_question_correct_answer($question_id)
    {
        $sql = "SELECT * FROM quiz_answers WHERE question_id = ? AND is_correct = 1";
        $query = $this->db->query($sql, array(clean_number($question_id)));
        return $query->row();
    }

    //delete quiz question answer
    public function delete_quiz_question_answer($answer_id)
    {
        $answer = $this->get_quiz_question_answer($answer_id);
        if (!empty($answer)) {
            $this->db->where('id', $answer->id);
            $this->db->delete('quiz_answers');
        }
    }

    //delete quiz question answers
    public function delete_quiz_question_answers($question_id)
    {
        $answers = $this->get_quiz_question_answers($question_id);
        if (!empty($answers)) {
            foreach ($answers as $answer) {
                $this->delete_quiz_question_answer($answer->id);
            }
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * RESULT
    *-------------------------------------------------------------------------------------------------
    */

    //add quiz results
    public function add_quiz_results($post_id)
    {
        $result_titles = $this->input->post('result_title', true);
        $result_images = $this->input->post('result_image', true);
        $result_descriptions = $this->input->post('result_description', false);
        $min_correct_counts = $this->input->post('min_correct_count', true);
        $max_correct_counts = $this->input->post('max_correct_count', true);
        $result_orders = $this->input->post('result_order', true);

        if (!empty($result_titles)) {
            for ($i = 0; $i < count($result_titles); $i++) {
                $data = array(
                    'post_id' => $post_id,
                    'result_title' => !empty($result_titles[$i]) ? $result_titles[$i] : '',
                    'image_path' => !empty($result_images[$i]) ? $result_images[$i] : '',
                    'description' => !empty($result_descriptions[$i]) ? $result_descriptions[$i] : '',
                    'min_correct_count' => !empty($min_correct_counts[$i]) ? $min_correct_counts[$i] : '',
                    'max_correct_count' => !empty($max_correct_counts[$i]) ? $max_correct_counts[$i] : '',
                    'result_order' => !empty($result_orders[$i]) ? $result_orders[$i] : 1
                );
                //add to database
                $this->db->insert('quiz_results', $data);
            }
        }
    }

    //add quiz result
    public function add_quiz_result($post_id)
    {
        $data = array(
            'post_id' => $post_id,
            'result_title' => "",
            'image_path' => "",
            'description' => "",
            'min_correct_count' => 1,
            'max_correct_count' => 2
        );
        //add to database
        $this->db->insert('quiz_results', $data);
        return $this->db->insert_id();
    }

    //update quiz results
    public function update_quiz_results($post_id)
    {
        $results = $this->get_quiz_results($post_id);
        if (!empty($results)) {
            foreach ($results as $result) {
                $data = array(
                    'result_title' => $this->input->post('result_title_' . $result->id, true),
                    'image_path' => $this->input->post('result_image_' . $result->id, true),
                    'description' => $this->input->post('result_description_' . $result->id, false),
                    'min_correct_count' => $this->input->post('min_correct_count_' . $result->id, true),
                    'max_correct_count' => $this->input->post('max_correct_count_' . $result->id, true),
                    'result_order' => $this->input->post('result_order_' . $result->id, true)
                );
                $this->db->where('id', $result->id);
                $this->db->update('quiz_results', $data);
            }
        }
    }

    //get quiz results
    public function get_quiz_results($post_id)
    {
        $sql = "SELECT * FROM quiz_results WHERE post_id = ? ORDER BY id";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->result();
    }

    //get quiz result
    public function get_quiz_result($result_id)
    {
        $sql = "SELECT * FROM quiz_results WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($result_id)));
        return $query->row();
    }

    //get quiz result by order number
    public function get_quiz_result_by_order_number($post_id, $order)
    {
        $sql = "SELECT * FROM quiz_results WHERE post_id = ? AND result_order = ?";
        $query = $this->db->query($sql, array(clean_number($post_id), clean_number($order)));
        return $query->row();
    }

    //delete quiz result
    public function delete_quiz_result($result_id)
    {
        $result = $this->get_quiz_result($result_id);
        if (!empty($result)) {
            $this->db->where('id', $result->id);
            $this->db->delete('quiz_results');
        }
    }

    //delete quiz results
    public function delete_quiz_results($post_id)
    {
        $results = $this->get_quiz_results($post_id);
        if (!empty($results)) {
            foreach ($results as $result) {
                $this->delete_quiz_result($result->id);
            }
        }
    }

}