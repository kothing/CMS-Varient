<?php namespace App\Models;

require APPPATH . "ThirdParty/swiftmailer/vendor/autoload.php";
require APPPATH . "ThirdParty/phpmailer/vendor/autoload.php";
require APPPATH . "ThirdParty/mailjet/vendor/autoload.php";

use CodeIgniter\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \Mailjet\Resources;

class EmailModel extends BaseModel
{
    //send text email
    public function sendTestEmail($email, $subject, $message)
    {
        if (!empty($email)) {
            $data = [
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            ];
            return $this->sendEmail($data);
        }
    }

    //send email activation
    public function sendEmailActivation($userId)
    {
        $user = getUserById($userId);
        if (!empty($user)) {
            $token = $user->token;
            if (empty($token)) {
                $token = generateToken();
                $this->db->table('users')->where('id', $user->id)->update(['token' => $token]);
            }
            $data = [
                'subject' => trans("confirm_your_email"),
                'to' => $user->email,
                'template_path' => "email/email_activation",
                'token' => $token
            ];
            $this->sendEmail($data);
        }
    }

    //send email contact message
    public function sendEmailContactMessage($name, $email, $message)
    {
        $data = [
            'subject' => trans("contact_message"),
            'to' => $this->generalSettings->mail_contact,
            'template_path' => "email/email_contact_message",
            'message_name' => $name,
            'message_email' => $email,
            'message_text' => $message
        ];
        $this->sendEmail($data);
    }

    //send email newsletter
    public function sendEmailNewsletter($subscriber, $subject, $message)
    {
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $modelNewsletter = new NewsletterModel();
                $modelNewsletter->updateSubscriberToken($subscriber->email);
                $subscriber = $modelNewsletter->getSubscriber($subscriber->email);
            }
            $data = [
                'subject' => $subject,
                'message' => $message,
                'to' => $subscriber->email,
                'template_path' => "email/email_newsletter",
                'subscriber' => $subscriber,
            ];
            return $this->sendEmail($data);
        }
    }

    //send email reset password
    public function sendEmailResetPassword($userId)
    {
        $user = getUserById($userId);
        if (!empty($user)) {
            $token = $user->token;
            if (empty($token)) {
                $token = generateToken();
                $this->db->table('users')->where('id', $user->id)->update(['token' => $token]);
            }
            $data = [
                'subject' => trans("reset_password"),
                'to' => $user->email,
                'template_path' => "email/email_reset_password",
                'token' => $token
            ];
            $this->sendEmail($data);
        }
    }

    //send email
    public function sendEmail($data)
    {
        $protocol = $this->generalSettings->mail_protocol;
        if ($protocol != 'smtp' && $protocol != 'mail') {
            $protocol = 'smtp';
        }
        $encryption = $this->generalSettings->mail_encryption;
        if ($encryption != 'tls' && $encryption != 'ssl') {
            $encryption = 'tls';
        }
        if ($this->generalSettings->mail_service == 'mailjet') {
            return $this->sendEmailMailjet($data);
        } elseif ($this->generalSettings->mail_service == 'swift') {
            return $this->sendEmailSwift($encryption, $data);
        } else {
            return $this->sendEmailPHPMailer($protocol, $encryption, $data);
        }
    }

    //send email with swift mailer
    public function sendEmailSwift($encryption, $data)
    {
        try {
            // Create the Transport
            $transport = (new \Swift_SmtpTransport($this->generalSettings->mail_host, $this->generalSettings->mail_port, $encryption))
                ->setUsername($this->generalSettings->mail_username)
                ->setPassword($this->generalSettings->mail_password);
            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);
            // Create a message
            $message = (new \Swift_Message($this->generalSettings->mail_title))
                ->setFrom(array($this->generalSettings->mail_reply_to => $this->generalSettings->mail_title))
                ->setTo([$data['to'] => ''])
                ->setSubject($data['subject'])
                ->setBody(view($data['template_path'], $data), 'text/html');
            //Send the message
            $result = $mailer->send($message);
            if ($result) {
                return true;
            }
        } catch (\Swift_TransportException $Ste) {
            $this->session->setFlashdata('error', $Ste->getMessage());
            return false;
        } catch (\Swift_RfcComplianceException $Ste) {
            $this->session->setFlashdata('error', $Ste->getMessage());
            return false;
        }
    }

    //send email with php mailer
    public function sendEmailPHPMailer($protocol, $encryption, $data)
    {
        $mail = new PHPMailer(true);
        try {
            if ($protocol == "mail") {
                $mail->isMail();
                $mail->setFrom($this->generalSettings->mail_reply_to, $this->generalSettings->mail_title);
                $mail->addAddress($data['to']);
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = $data['subject'];
                $mail->Body = view($data['template_path'], $data);
            } else {
                $mail->isSMTP();
                $mail->Host = $this->generalSettings->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = $this->generalSettings->mail_username;
                $mail->Password = $this->generalSettings->mail_password;
                $mail->SMTPSecure = $encryption;
                $mail->CharSet = 'UTF-8';
                $mail->Port = $this->generalSettings->mail_port;
                $mail->setFrom($this->generalSettings->mail_reply_to, $this->generalSettings->mail_title);
                $mail->addAddress($data['to']);
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body = view($data['template_path'], $data);
            }
            $mail->send();
            return true;
        } catch (Exception $e) {
            $this->session->setFlashdata('error', $mail->ErrorInfo);
            return false;
        }
        return false;
    }

    //send email with Mailjet
    public function sendEmailMailjet($data)
    {
        $mj = new \Mailjet\Client($this->generalSettings->mailjet_api_key, $this->generalSettings->mailjet_secret_key, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->generalSettings->mailjet_email_address,
                        'Name' => $this->generalSettings->mail_title
                    ],
                    'To' => [
                        [
                            'Email' => $data['to'],
                            'Name' => $this->generalSettings->mail_title
                        ]
                    ],
                    'Subject' => $data['subject'],
                    'HTMLPart' => view($data['template_path'], $data)
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        if ($response->success()) {
            return true;
        }
        return false;
    }
}