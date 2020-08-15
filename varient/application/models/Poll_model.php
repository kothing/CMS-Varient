<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Poll_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'question' => $this->input->post('question', true),
            'option1' => $this->input->post('option1', true),
            'option2' => $this->input->post('option2', true),
            'option3' => $this->input->post('option3', true),
            'option4' => $this->input->post('option4', true),
            'option5' => $this->input->post('option5', true),
            'option6' => $this->input->post('option6', true),
            'option7' => $this->input->post('option7', true),
            'option8' => $this->input->post('option8', true),
            'option9' => $this->input->post('option9', true),
            'option10' => $this->input->post('option10', true),
            'status' => $this->input->post('status', true),
            'vote_permission' => $this->input->post('vote_permission', true)
        );
        return $data;
    }

    //add poll
    public function add()
    {
        $data = $this->input_values();
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('polls', $data);
    }

    //update poll
    public function update($id)
    {
        $data = $this->input_values();
        $this->db->where('id', clean_number($id));
        return $this->db->update('polls', $data);
    }

    //poll options query string
    public function options_query_string()
    {
        $sql = "(SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option1') AS option1_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option2') AS option2_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option3') AS option3_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option4') AS option4_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option5') AS option5_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option6') AS option6_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option7') AS option7_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option8') AS option8_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option9') AS option9_vote_count,
       (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option10') AS option10_vote_count ";
        return $sql;
    }

    //get polls
    public function get_polls()
    {
        $sql = "SELECT polls.*," . $this->options_query_string() . "FROM polls WHERE polls.lang_id = ? ORDER BY polls.id DESC";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
        return $query->result();
    }

    //get all polls
    public function get_all_polls()
    {
        $sql = "SELECT polls.*," . $this->options_query_string() . "FROM polls ORDER BY polls.id DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //get poll
    public function get_poll($id)
    {
        $sql = "SELECT polls.*," . $this->options_query_string() . "FROM polls WHERE polls.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get user vote
    public function get_user_vote($poll_id, $user_id)
    {
        $sql = "SELECT * FROM poll_votes WHERE poll_id =  ? AND user_id = ?";
        $query = $this->db->query($sql, array(clean_number($poll_id), clean_number($user_id)));
        return $query->row();
    }

    //add registered vote
    public function add_registered_vote($poll_id, $user_id, $option)
    {
        if (empty($this->poll_model->get_user_vote($poll_id, $user_id))) {
            $data = array(
                'poll_id' => $poll_id,
                'user_id' => $user_id,
                'vote' => $option
            );
            $this->db->insert('poll_votes', $data);
            return "success";
        } else {
            return "voted";
        }
    }

    //add unregistered vote
    public function add_unregistered_vote($poll_id, $option)
    {
        if (isset($_COOKIE["vr_cookie_poll_" . $poll_id])) {
            return "voted";
        } else {
            $data = array(
                'poll_id' => $poll_id,
                'user_id' => 0,
                'vote' => $option
            );
            $this->db->insert('poll_votes', $data);
            helper_setcookie('vr_cookie_poll_' . $poll_id, '1');
            return "success";
        }
    }

    //delete poll
    public function delete($id)
    {
        $poll = $this->get_poll($id);
        if (!empty($poll)) {

            //delete poll votes
            $this->db->where('poll_id', $poll->id);
            $this->db->delete('poll_votes');

            $this->db->where('id', $poll->id);
            return $this->db->delete('polls');
        }
        return false;
    }
}