<?php
require_once PROJECT_ROOT_PATH . "/../Model/Database.php";

class TransactionModel extends Database
{
    public function addTransaction($sender, $receiver, $amount = 0){
        return $this->create("INSERT INTO `transactions` (`sender`, `receiver` , `amount`) VALUES
(?, ?, ?)","iid", [$sender, $receiver, $amount]);
    }

    public function getTransactions($account_id){
        return $this->select("SELECT * FROM `transactions` WHERE `sender` = ? OR `receiver` = ? ORDER BY `timestamp` ASC","ii", [$account_id,$account_id]);
    }
}