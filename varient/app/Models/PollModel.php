<?php namespace App\Models;

use CodeIgniter\Model;

class PollModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('polls');
        $this->builderVotes = $this->db->table('poll_votes');
    }

    //input values
    public function inputValues()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'question' => inputPost('question'),
            'option1' => inputPost('option1'),
            'option2' => inputPost('option2'),
            'option3' => inputPost('option3'),
            'option4' => inputPost('option4'),
            'option5' => inputPost('option5'),
            'option6' => inputPost('option6'),
            'option7' => inputPost('option7'),
            'option8' => inputPost('option8'),
            'option9' => inputPost('option9'),
            'option10' => inputPost('option10'),
            'status' => inputPost('status'),
            'vote_permission' => inputPost('vote_permission')
        ];
    }

    //add poll
    public function addPoll()
    {
        $data = $this->inputValues();
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->builder->insert($data);
    }

    //edit poll
    public function editPoll($id)
    {
        $poll = $this->getPoll($id);
        if (!empty($poll)) {
            $data = $this->inputValues();
            return $this->builder->where('id', $poll->id)->update($data);
        }
        return false;
    }

    //poll options query string
    public function buildQueryPoll()
    {
        $sqlSelect = "";
        for ($i = 1; $i <= 10; $i++) {
            $sqlSelect .= ", (SELECT COUNT(poll_votes.id) FROM poll_votes WHERE poll_votes.poll_id = polls.id AND poll_votes.vote = 'option" . $i . "') AS option" . $i . "_vote_count";
        }
        $this->builder->select('polls.*' . $sqlSelect);
    }

    //get polls by active language
    public function getPollsByActiveLang()
    {
        $this->buildQueryPoll();
        return $this->builder->where('polls.lang_id', cleanNumber($this->activeLang->id))->orderBy('polls.id DESC')->get()->getResult();
    }

    //get all polls
    public function getPolls()
    {
        $this->buildQueryPoll();
        return $this->builder->orderBy('polls.id DESC')->get()->getResult();
    }

    //get poll
    public function getPoll($id)
    {
        $this->buildQueryPoll();
        return $this->builder->where('polls.id', cleanNumber($id))->get()->getRow();
    }

    //get user vote
    public function getUserVote($pollId, $userId)
    {
        return $this->builderVotes->where('poll_id', cleanNumber($pollId))->where('user_id', cleanNumber($userId))->get()->getRow();
    }

    //add registered user vote
    public function addVoteRegistered($pollId, $option)
    {
        if (authCheck()) {
            if (empty($this->getUserVote($pollId, user()->id))) {
                $data = [
                    'poll_id' => $pollId,
                    'user_id' => user()->id,
                    'vote' => $option
                ];
                $this->builderVotes->insert($data);
                return 'success';
            }
            return 'voted';
        }
    }

    //add unregistered user vote
    public function addVoteUnRegistered($pollId, $option)
    {
        if (empty(helperGetCookie('poll_' . $pollId))) {
            $data = [
                'poll_id' => $pollId,
                'user_id' => 0,
                'vote' => $option
            ];
            $this->builderVotes->insert($data);
            helperSetCookie('poll_' . $pollId, 1);
            return 'success';
        }
        return 'voted';
    }

    //delete poll
    public function deletePoll($id)
    {
        $poll = $this->getPoll($id);
        if (!empty($poll)) {
            $this->builderVotes->where('poll_id', $poll->id)->delete();
            return $this->builder->where('id', $poll->id)->delete();
        }
        return false;
    }
}
