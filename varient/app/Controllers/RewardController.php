<?php

namespace App\Controllers;

use App\Models\RewardModel;

class RewardController extends BaseAdminController
{
    protected $rewardModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        if (!isAdmin()) {
            redirectToUrl(adminUrl());
            exit();
        }
        $this->rewardModel = new RewardModel();
    }

    /**
     * Reward System
     */
    public function rewardSystem()
    {
        $data['title'] = trans("reward_system");

        echo view('admin/includes/_header', $data);
        echo view('admin/reward/reward_system', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Update Settings Post
     */
    public function updateSettingsPost()
    {
        if ($this->rewardModel->updateSettings()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('reward-system'));
    }

    /**
     * Update Payout Post
     */
    public function updatePayoutPost()
    {
        if ($this->rewardModel->updatePayoutMethods()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('reward-system'));
    }

    /**
     * Update Currency Post
     */
    public function updateCurrencyPost()
    {
        if ($this->rewardModel->updateCurrency()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        return redirect()->to(adminUrl('reward-system'));
    }

    /**
     * Earnings
     */
    public function earnings()
    {
        $data['title'] = trans("earnings");
        $numRows = $this->rewardModel->getEarningsCount();
        $pager = paginate($this->perPage, $numRows);
        $data['earnings'] = $this->rewardModel->getEarningsPaginated($this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/reward/earnings', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Payouts
     */
    public function payouts()
    {
        $data['title'] = trans("payouts");
        $numRows = $this->rewardModel->getPayoutsCount();
        $pager = paginate($this->perPage, $numRows);
        $data['payouts'] = $this->rewardModel->getPayoutsPaginated($this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/reward/payouts', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Payout
     */
    public function addPayout()
    {
        $data['title'] = trans("add_payout");
        $data['users'] = $this->rewardModel->getEarnings();

        echo view('admin/includes/_header', $data);
        echo view('admin/reward/add_payout', $data);
        echo view('admin/includes/_footer');
    }

    /**
     * Add Payout Post
     */
    public function addPayoutPost()
    {
        $userId = inputPost('user_id');
        $amount = inputPost('amount');
        $user = getUserById($userId);
        if (!empty($user)) {
            if ($user->balance < $amount) {
                $this->session->setFlashdata('error', trans("insufficient_balance"));
            } else {
                if ($this->rewardModel->addPayout($user, $amount)) {
                    $this->session->setFlashdata('success', trans("msg_payout_added"));
                } else {
                    $this->session->setFlashdata('error', trans("msg_error"));
                }
            }
        }
        return redirect()->to(adminUrl('reward-system/add-payout'));
    }

    /**
     * Delete Payout Post
     */
    public function deletePayoutPost()
    {
        $id = inputPost('id');
        if ($this->rewardModel->deletePayout($id)) {
            $this->session->setFlashdata('success', trans("msg_deleted"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
    }

    /**
     * Pageviews
     */
    public function pageviews()
    {
        $data['title'] = trans("pageviews");
        $numRows = $this->rewardModel->getPageviewsCount();
        $pager = paginate($this->perPage, $numRows);
        $data['pageviews'] = $this->rewardModel->getPageviewsPaginated($this->perPage, $pager->offset);

        echo view('admin/includes/_header', $data);
        echo view('admin/reward/pageviews', $data);
        echo view('admin/includes/_footer');
    }
}
