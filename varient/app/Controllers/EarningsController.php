<?php

namespace App\Controllers;

use App\Models\RewardModel;

class EarningsController extends BaseController
{
    protected $rewardModel;
    protected $perPage;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if (!authCheck()) {
            redirectToUrl(langBaseUrl());
            exit();
        }
        if (user()->reward_system_enabled != 1) {
            redirectToUrl(langBaseUrl());
            exit();
        }
        $this->rewardModel = new RewardModel();
        $this->perPage = 15;
    }

    /**
     * Earnings Page
     */
    public function earnings()
    {
        $data['title'] = trans("earnings");
        $data['description'] = trans("earnings") . ' - ' . $this->settings->site_title;
        $data['keywords'] = trans("earnings") . ', ' . $this->settings->application_name;
        $data['activeTab'] = 'earnings';
        $data['userPostsCount'] = $this->postModel->getUserPostsCount(user()->id);
        $data['pageViewsCounts'] = $this->rewardModel->getPageViewsCountByDate(user()->id);
        $data['numberOfDays'] = date('t');
        if (empty($data['numberOfDays'])) {
            $data['numberOfDays'] = 30;
        }
        $data['today'] = date('d');

        echo loadView('partials/_header', $data);
        echo loadView('earnings/earnings', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Payouts Page
     */
    public function payouts()
    {
        $data['title'] = trans("payouts");
        $data['description'] = trans("payouts") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("payouts") . ', ' . $this->settings->application_name;
        $data['activeTab'] = 'payouts';
        $data['userPostsCount'] = $this->postModel->getUserPostsCount(user()->id);
        $data['numRows'] = $this->rewardModel->geUserPayoutsCount(user()->id);
        $pager = paginate($this->perPage, $data['numRows']);
        $data['payouts'] = $this->rewardModel->getUserPayoutsPaginated(user()->id, $this->perPage, $pager->offset);

        echo loadView('partials/_header', $data);
        echo loadView('earnings/payouts', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Set Payout Account
     */
    public function setPayoutAccount()
    {
        $data['title'] = trans("set_payout_account");
        $data['description'] = trans("set_payout_account") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("set_payout_account") . "," . $this->settings->application_name;
        $data['activeTab'] = 'setPayoutAccount';
        $data['userPostsCount'] = $this->postModel->getUserPostsCount(user()->id);
        $data['userPayout'] = $this->rewardModel->getUserPayoutAccount(user()->id);
        $data['selectedPayout'] = inputGet('payout');
        if ($data['selectedPayout'] != 'paypal' && $data['selectedPayout'] != 'iban' && $data['selectedPayout'] != 'swift') {
            $data['selectedPayout'] = 'paypal';
        }

        echo loadView('partials/_header', $data);
        echo loadView('earnings/set_payout_account', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Set Paypal Payout Account Post
     */
    public function setPaypalPayoutAccountPost()
    {
        if ($this->rewardModel->setPaypalPayoutAccount()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        redirectToBackURL();
    }

    /**
     * Set IBAN Payout Account Post
     */
    public function setIbanPayoutAccountPost()
    {
        if ($this->rewardModel->setIbanPayoutAccount()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        redirectToBackURL();
    }

    /**
     * Set SWIFT Payout Account Post
     */
    public function setSwiftPayoutAccountPost()
    {
        if ($this->rewardModel->setSwiftPayoutAccount()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        redirectToBackURL();
    }
}
