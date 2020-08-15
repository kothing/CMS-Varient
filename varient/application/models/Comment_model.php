<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model
{
    //add comment
    public function add_comment()
    {
        $data = array(
            'parent_id' => $this->input->post('parent_id', true),
            'post_id' => $this->input->post('post_id', true),
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'comment' => $this->input->post('comment', true),
            'status' => 1,
            'ip_address' => 0,
        );
        if (!empty($data['post_id']) && !empty(trim($data['comment']))) {
            $data['user_id'] = 0;
            if ($this->auth_check) {
                $data['user_id'] = $this->auth_user->id;
                $data['name'] = $this->auth_user->username;
                $data['email'] = $this->auth_user->email;
            }
            $ip = $this->input->ip_address();
            if (!empty($ip)) {
                $data['ip_address'] = $ip;
            }
            if ($this->general_settings->comment_approval_system == 1) {
                $data["status"] = 0;
            }
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('comments', $data);
            $last_id = $this->db->insert_id();
            setcookie('vr_added_comment_id_' . $last_id, 1, time() + (86400 * 60), "/");
        }
    }

    //like comment
    public function like_comment($comment_id)
    {
        $comment_id = clean_number($comment_id);
        //check comment owner
        if (isset($_COOKIE['vr_added_comment_id_' . $comment_id])) {
            return false;
        }

        $cookie_vote = 'vr_comment_vote_' . $comment_id;
        if (!isset($_COOKIE[$cookie_vote])) {
            $comment = $this->get_comment($comment_id);
            if (!empty($comment)) {
                $data = array(
                    'like_count' => $comment->like_count + 1
                );
                $this->db->where('id', $comment->id);
                if ($this->db->update('comments', $data)) {
                    setcookie($cookie_vote, 'plus', time() + (86400 * 60), "/");
                    return true;
                }
            }
        } else {
            if ($_COOKIE[$cookie_vote] == 'minus') {
                $comment = $this->get_comment($comment_id);
                if (!empty($comment)) {
                    $data = array(
                        'like_count' => $comment->like_count + 1
                    );
                    $this->db->where('id', $comment->id);
                    if ($this->db->update('comments', $data)) {
                        setcookie($cookie_vote, "", time() - 3600, "/");
                        return true;
                    }
                }
            }
        }
        return false;
    }

    //dislike comment
    public function dislike_comment($comment_id)
    {
        $comment_id = clean_number($comment_id);
        //check comment owner
        if (isset($_COOKIE['vr_added_comment_id_' . $comment_id])) {
            return false;
        }

        $cookie_vote = 'vr_comment_vote_' . $comment_id;
        if (!isset($_COOKIE[$cookie_vote])) {
            $comment = $this->get_comment($comment_id);
            if (!empty($comment)) {
                $data = array(
                    'like_count' => $comment->like_count - 1
                );
                $this->db->where('id', $comment->id);
                if ($this->db->update('comments', $data)) {
                    setcookie($cookie_vote, 'minus', time() + (86400 * 60), "/");
                    return true;
                }
            }
        } else {
            if ($_COOKIE[$cookie_vote] == 'plus') {
                $comment = $this->get_comment($comment_id);
                if (!empty($comment)) {
                    $data = array(
                        'like_count' => $comment->like_count - 1
                    );
                    $this->db->where('id', $comment->id);
                    if ($this->db->update('comments', $data)) {
                        setcookie($cookie_vote, "", time() - 3600, "/");
                        return true;
                    }
                }
            }
        }
        return false;
    }

    //get comment
    public function get_comment($id)
    {
        $sql = "SELECT * FROM comments WHERE comments.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get comments
    public function get_comments($post_id, $limit)
    {
        $sql = "SELECT comments.* FROM comments 
                INNER JOIN posts ON posts.id = comments.post_id
                WHERE comments.post_id = ? AND comments.parent_id = 0 AND comments.status = 1 ORDER BY comments.id DESC LIMIT ?";
        $query = $this->db->query($sql, array(clean_number($post_id), clean_number($limit)));
        return $query->result();
    }

    //get all comments
    public function get_all_comments()
    {
        $sql = "SELECT comments.*, posts.title as post_title FROM comments 
                INNER JOIN posts ON posts.id = comments.post_id
                ORDER BY comments.id DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //get last comments
    public function get_last_comments($limit)
    {
        $sql = "SELECT comments.*, posts.title_slug as post_slug FROM comments 
                INNER JOIN posts ON posts.id = comments.post_id WHERE comments.status = 1
                ORDER BY comments.id DESC LIMIT ?";
        $query = $this->db->query($sql, array(clean_number($limit)));
        return $query->result();
    }

    //get last pending comments
    public function get_last_pending_comments($limit)
    {
        $sql = "SELECT comments.*, posts.title_slug as post_slug FROM comments 
                INNER JOIN posts ON posts.id = comments.post_id WHERE comments.status = 0
                ORDER BY comments.id DESC LIMIT ?";
        $query = $this->db->query($sql, array(clean_number($limit)));
        return $query->result();
    }

    //get all approved comments
    public function get_all_approved_comments()
    {
        $sql = "SELECT comments.*, posts.title_slug as post_slug FROM comments 
                INNER JOIN posts ON posts.id = comments.post_id WHERE comments.status = 1
                ORDER BY comments.id DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //get all pending comments
    public function get_all_pending_comments()
    {
        $sql = "SELECT comments.*, posts.title_slug as post_slug FROM comments 
                INNER JOIN posts ON posts.id = comments.post_id WHERE comments.status = 0
                ORDER BY comments.id DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //get subcomments
    public function get_subcomments($comment_id)
    {
        $sql = "SELECT comments.* FROM comments 
                INNER JOIN posts ON posts.id = comments.post_id
                WHERE comments.parent_id = ? AND comments.status = 1 ORDER BY comments.id DESC";
        $query = $this->db->query($sql, array(clean_number($comment_id)));
        return $query->result();
    }

    //get comment count by post id
    public function get_comment_count_by_post_id($post_id)
    {
        $sql = "SELECT COUNT(comments.id) AS count FROM comments WHERE comments.post_id = ? AND parent_id = 0 AND status = 1";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->row()->count;
    }

    //approve comment
    public function approve_comment($id)
    {
        $comment = $this->get_comment($id);
        if (!empty($comment)) {
            $data = array(
                'status' => 1
            );
            $this->db->where('id', $comment->id);
            return $this->db->update('comments', $data);
        }
        return false;
    }

    //approve multi comments
    public function approve_multi_comments($comment_ids)
    {
        if (!empty($comment_ids)) {
            foreach ($comment_ids as $id) {
                $this->approve_comment($id);
            }
        }
    }

    //delete comment
    public function delete_comment($id)
    {
        $comment = $this->get_comment($id);
        if (!empty($comment)) {
            $subcomments = $this->get_subcomments($id);
            if (!empty($subcomments)) {
                foreach ($subcomments as $subcomment) {
                    $this->db->where('id', $subcomment->id);
                    $this->db->delete('comments');
                }
            }
            $this->db->where('id', $comment->id);
            return $this->db->delete('comments');
        }
        return false;
    }

    //delete multi comments
    public function delete_multi_comments($comment_ids)
    {
        if (!empty($comment_ids)) {
            foreach ($comment_ids as $id) {
                $this->delete_comment($id);
            }
        }
    }
}
