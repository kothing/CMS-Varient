<?php namespace App\Models;

use CodeIgniter\Model;

class NewsletterModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('subscribers');

    }

    //add to subscriber
    public function addSubscriber($email)
    {
        $data = [
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->builder->insert($data);
    }

    //update subscriber token
    public function updateSubscriberToken($email)
    {
        $subscriber = $this->getSubscriber($email);
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $this->builder->where('email', cleanStr($email))->update(['token' => generateToken()]);
            }
        }
    }

    //get subscribers
    public function getSubscribers()
    {
        return $this->builder->orderBy('id DESC')->get()->getResult();
    }

    //get subscriber
    public function getSubscriber($email)
    {
        return $this->builder->where('email', cleanStr($email))->get()->getRow();
    }

    //delete from subscribers
    public function deleteSubscriber($id)
    {
        return $this->builder->where('id', cleanNumber($id))->delete();
    }

    //get subscriber by token
    public function getSubscriberByToken($token)
    {
        return $this->builder->where('token', cleanStr($token))->get()->getRow();
    }

    //unsubscribe email
    public function unsubscribeEmail($email)
    {
        return $this->builder->where('email', cleanStr($email))->delete();
    }

    //update settings
    public function updateSettings()
    {
        $data = [
            'newsletter_status' => inputPost('newsletter_status'),
            'newsletter_popup' => inputPost('newsletter_popup')
        ];
        return $this->db->table('general_settings')->where('id', 1)->update($data);
    }

    //send email
    public function sendEmail()
    {
        $emailModel = new EmailModel();
        $email = inputPost('email');
        $subject = inputPost('subject');
        $body = inputPost('body');
        $submit = inputPost('submit');
        if ($submit == "subscribers") {
            $subscriber = $this->getSubscriber($email);
            if (!empty($subscriber)) {
                if ($emailModel->sendEmailNewsletter($subscriber, $subject, $body)) {
                    return true;
                }
            }
        } else {
            $data = [
                'subject' => $subject,
                'message' => $body,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => $subscriber,
            ];
            return $emailModel->sendEmail($data);
        }
        return false;
    }
}