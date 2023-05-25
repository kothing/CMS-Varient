<?php namespace App\Models;

use CodeIgniter\Model;

class ReactionModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('reactions');
        $this->arrayReactions = ['like', 'dislike', 'love', 'funny', 'angry', 'sad', 'wow'];
        $this->cookieTime = time() + (86400 * 365);
    }

    //save reaction
    public function addReaction($postId, $reaction)
    {
        if (!in_array($reaction, $this->arrayReactions)) {
            return false;
        }
        if (!isReactionVoted($postId, $reaction)) {
            $this->increaseReactionVote($postId, $reaction);
            return ['reaction' => $reaction, 'operation' => 'increase'];
        } else {
            $this->decreaseReactionVote($postId, $reaction);
            return ['reaction' => $reaction, 'operation' => 'decrease'];
        }
    }

    //increase reaction vote
    public function increaseReactionVote($postId, $reaction)
    {
        $row = $this->getReaction($postId);
        if (!empty($row)) {
            $re = 're_' . $reaction;
            if ($this->builder->where('post_id', cleanNumber($postId))->update(['re_' . $reaction => $row->$re + 1])) {
                $keyTotalVotes = 'reaction_total_votes_' . $postId;
                $count = helperGetCookie($keyTotalVotes);
                if (empty($count)) {
                    $count = 0;
                }
                $count = $count + 1;
                helperSetCookie('reaction_' . $reaction . '_' . $postId, '1', $this->cookieTime);
                helperSetCookie($keyTotalVotes, $count, $this->cookieTime);
                setSession('reaction_' . $reaction . '_' . $postId, '1');
                setSession($keyTotalVotes, $count);
            }
        }
    }

    //decrease reaction vote
    public function decreaseReactionVote($postId, $reaction)
    {
        $row = $this->getReaction($postId);
        if (!empty($row)) {
            $re = 're_' . $reaction;
            if ($this->builder->where('post_id', cleanNumber($postId))->update(['re_' . $reaction => $row->$re - 1])) {
                $keyTotalVotes = 'reaction_total_votes_' . $postId;
                $count = helperGetCookie($keyTotalVotes);
                if (empty($count)) {
                    $count = 0;
                } else {
                    $count = $count - 1;
                }
                helperSetCookie('reaction_' . $reaction . '_' . $postId, '0', $this->cookieTime);
                helperSetCookie($keyTotalVotes, $count, $this->cookieTime);
                deleteSession('reaction_' . $reaction . '_' . $postId);
                setSession($keyTotalVotes, $count);
            }
        }
    }

    //get reaction
    public function getReaction($postId)
    {
        $row = $this->builder->where('post_id', cleanNumber($postId))->get()->getRow();
        if (empty($row)) {
            $data = [
                'post_id' => cleanNumber($postId),
                're_like' => 0,
                're_dislike' => 0,
                're_love' => 0,
                're_funny' => 0,
                're_angry' => 0,
                're_sad' => 0,
                're_wow' => 0
            ];
            $this->builder->insert($data);
            $row = $this->builder->where('post_id', cleanNumber($postId))->get()->getRow();
        }
        return $row;
    }
}