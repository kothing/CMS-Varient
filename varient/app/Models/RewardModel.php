<?php namespace App\Models;

use CodeIgniter\Model;

class RewardModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builderUsers = $this->db->table('users');
        $this->builderPayouts = $this->db->table('payouts');
        $this->builderPayoutAccounts = $this->db->table('user_payout_accounts');
        $this->builderGeneral = $this->db->table('general_settings');
        $this->builderPageviews = $this->db->table('post_pageviews_month');
    }

    //get page views counts by date
    public function getPageViewsCountByDate($userId)
    {
        return $this->builderPageviews->select('COUNT(id) AS count, SUM(reward_amount) as total_amount, DATE(created_at) AS date')
            ->where('post_user_id', cleanNumber($userId))->where('reward_amount > 0')->where('MONTH(created_at)', date('m'))->groupBy('date')->get()->getResult();
    }

    //update settings
    public function updateSettings()
    {
        $amount = inputPost('reward_amount');
        if ($amount < 0.01) {
            $amount = 0.01;
        }
        $data = [
            'reward_system_status' => inputPost('reward_system_status'),
            'reward_amount' => $amount
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update payout methods
    public function updatePayoutMethods()
    {
        $data = [
            'payout_paypal_status' => inputPost('payout_paypal_status'),
            'payout_iban_status' => inputPost('payout_iban_status'),
            'payout_swift_status' => inputPost('payout_swift_status')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update currency
    public function updateCurrency()
    {
        $data = [
            'currency_name' => inputPost('currency_name'),
            'currency_symbol' => inputPost('currency_symbol'),
            'currency_format' => inputPost('currency_format'),
            'currency_symbol_format' => inputPost('currency_symbol_format')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //get earnings
    public function getEarnings()
    {
        return $this->builderUsers->where('reward_system_enabled', 1)->orWhere('balance >', 0)->orderBy('balance DESC')->get()->getResult();
    }

    //get earnings count
    public function getEarningsCount()
    {
        $this->filterEarnings();
        return $this->builderUsers->countAllResults();
    }

    //get earnings paginated
    public function getEarningsPaginated($perPage, $offset)
    {
        $this->filterEarnings();
        return $this->builderUsers->orderBy('balance DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //earnings filter
    public function filterEarnings()
    {
        $q = cleanStr(inputGet('q'));
        if (!empty($q)) {
            $this->builderUsers->groupStart()->like('users.username', $q)->orLike('users.email', $q)->groupEnd();
        }
        $this->builderUsers->groupStart()->where('reward_system_enabled', 1)->orWhere('balance >', 0)->groupEnd();
    }

    //get payout
    public function getPayout($id)
    {
        return $this->builderPayouts->where('id', cleanNumber($id))->get()->getRow();
    }

    //get payouts count
    public function getPayoutsCount()
    {
        $this->filterPayouts();
        return $this->builderPayouts->countAllResults();
    }

    //get payouts paginated
    public function getPayoutsPaginated($perPage, $offset)
    {
        $this->filterPayouts();
        return $this->builderPayouts->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //payouts filter
    public function filterPayouts()
    {
        $q = cleanStr(inputGet('q'));
        if (!empty($q)) {
            $this->builderPayouts->groupStart()->like('username', $q)->orLike('email', $q)->orLike('payout_method', $q)->groupEnd();
        }
    }

    //add payout
    public function addPayout($user, $amount)
    {
        if (!empty($user)) {
            $data = [
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'payout_method' => inputPost('payout_method'),
                'amount' => $amount,
                'created_at' => date('Y-m-d H:i:s')
            ];
            if ($this->builderPayouts->insert($data)) {
                $balance = $user->balance - $amount;
                if ($balance < 0) {
                    $balance = 0;
                }
                $this->builderUsers->where('id', $user->id)->update(['balance' => $balance]);
                return true;
            }
        }
        return false;
    }

    //delete payout
    public function deletePayout($id)
    {
        $payout = $this->getPayout($id);
        if (!empty($payout)) {
            return $this->builderPayouts->where('id', $payout->id)->delete();
        }
        return false;
    }

    //get user payouts count
    public function geUserPayoutsCount($userId)
    {
        return $this->builderPayouts->where('user_id', cleanNumber($userId))->countAllResults();
    }

    //get paginated user payouts
    public function getUserPayoutsPaginated($userId, $perPage, $offset)
    {
        return $this->builderPayouts->where('user_id', cleanNumber($userId))->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //get user payout account
    public function getUserPayoutAccount($userId)
    {
        $row = $this->db->table('user_payout_accounts')->where('user_id', cleanNumber($userId))->get()->getRow();
        if (!empty($row)) {
            return $row;
        }
        $user = getUserById($userId);
        if (!empty($user)) {
            $data = [
                'user_id' => $user->id,
                'payout_paypal_email' => '',
                'iban_full_name' => '',
                'iban_country' => '',
                'iban_bank_name' => '',
                'iban_number' => '',
                'swift_full_name' => '',
                'swift_address' => '',
                'swift_state' => '',
                'swift_city' => '',
                'swift_postcode' => '',
                'swift_country' => '',
                'swift_bank_account_holder_name' => '',
                'swift_iban' => '',
                'swift_code' => '',
                'swift_bank_name' => '',
                'swift_bank_branch_city' => '',
                'swift_bank_branch_country' => '',
                'default_payout_account' => ''
            ];
            $this->db->table('user_payout_accounts')->insert($data);
            return $this->db->table('user_payout_accounts')->where('user_id', $user->id)->get()->getRow();
        }
        return false;
    }

    //set paypal payout account
    public function setPaypalPayoutAccount()
    {
        $data = [
            'payout_paypal_email' => inputPost('payout_paypal_email')
        ];
        if (inputPost('default_payout_account') == 'paypal') {
            $data['default_payout_account'] = 'paypal';
        }
        return $this->builderPayoutAccounts->where('user_id', cleanNumber(user()->id))->update($data);
    }

    //set iban payout account
    public function setIbanPayoutAccount()
    {
        $data = [
            'iban_full_name' => inputPost('iban_full_name'),
            'iban_country' => inputPost('iban_country'),
            'iban_bank_name' => inputPost('iban_bank_name'),
            'iban_number' => inputPost('iban_number')
        ];
        if (inputPost('default_payout_account') == 'iban') {
            $data['default_payout_account'] = 'iban';
        }
        return $this->builderPayoutAccounts->where('user_id', cleanNumber(user()->id))->update($data);
    }

    //set swift payout account
    public function setSwiftPayoutAccount()
    {
        $data = [
            'swift_full_name' => inputPost('swift_full_name'),
            'swift_address' => inputPost('swift_address'),
            'swift_state' => inputPost('swift_state'),
            'swift_city' => inputPost('swift_city'),
            'swift_postcode' => inputPost('swift_postcode'),
            'swift_country' => inputPost('swift_country'),
            'swift_bank_account_holder_name' => inputPost('swift_bank_account_holder_name'),
            'swift_iban' => inputPost('swift_iban'),
            'swift_code' => inputPost('swift_code'),
            'swift_bank_name' => inputPost('swift_bank_name'),
            'swift_bank_branch_city' => inputPost('swift_bank_branch_city'),
            'swift_bank_branch_country' => inputPost('swift_bank_branch_country')
        ];
        if (inputPost('default_payout_account') == 'swift') {
            $data['default_payout_account'] = 'swift';
        }
        return $this->builderPayoutAccounts->where('user_id', cleanNumber(user()->id))->update($data);
    }

    //get paginated pageviews count
    public function getPageviewsCount()
    {
        $this->filterPageviews();
        return $this->builderPageviews->join('users', 'users.id = post_pageviews_month.post_user_id')
            ->select('post_pageviews_month.*, users.username AS author_username, users.slug AS author_slug')->countAllResults();
    }

    //get paginated pageviews
    public function getPageviewsPaginated($perPage, $offset)
    {
        $this->filterPageviews();
        return $this->builderPageviews->join('users', 'users.id = post_pageviews_month.post_user_id')
            ->select('post_pageviews_month.*, users.username AS author_username, users.slug AS author_slug')->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //pageviews filter
    public function filterPageviews()
    {
        $q = cleanStr(inputGet('q'));
        if (!empty($q)) {
            $this->builderPageviews->groupStart()->like('users.username', $q)->orLike('ip_address', $q)->orLike('user_agent', $q)->groupEnd();
        }
    }

    //enable disable reward system
    public function enableDisableRewardSystem($user)
    {
        if (!empty($user)) {
            if ($user->reward_system_enabled == 1) {
                $data['reward_system_enabled'] = 0;
            } else {
                $data['reward_system_enabled'] = 1;
            }
            return $this->db->table('users')->where('id', $user->id)->update($data);
        }
        return false;
    }
}