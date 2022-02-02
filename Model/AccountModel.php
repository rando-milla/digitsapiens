<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class AccountModel extends Database
{
    public function createAccount($user_id, $amount = 0){
        return $this->executeStatement("INSERT INTO `accounts` (`user_id`, `balance`) VALUES
(?, ?)","id", [$user_id, $amount]);
    }

    public function getBalance($user_id, $account_id)
    {
        return $this->select("SELECT `balance` as `Balance` FROM `accounts` WHERE `user_id` = ? AND `id` = ? LIMIT 1","ii", [$user_id,$account_id]);
    }

    public function getAccount($user_id, $account_id){
        return $this->select("SELECT * FROM `accounts` WHERE `user_id` = ? AND `id` = ? LIMIT 1","ii", [$user_id,$account_id]);
    }

    public function getAccountWithoutCreds($account_id){
        return $this->select("SELECT * FROM `accounts` WHERE  `id` = ? LIMIT 1","i", [$account_id]);
    }

    public function updateFunds($account_id, $amount){
        return $this->executeStatement("UPDATE `accounts` SET `balance` = ?  WHERE  `id` = ? LIMIT 1","di", [$amount, $account_id]);
    }
}