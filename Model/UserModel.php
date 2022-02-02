<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM users ORDER BY id ASC LIMIT ?","i", [ $limit]);
    }

    public function getUser($email, $pass)
    {
        return $this->select("SELECT `id` as `ID` FROM `users` WHERE `user_email` = ? AND `password` = ? LIMIT 1","ss", [$email, md5($pass)]);
    }

    public function createUser($email, $fullname, $pass){
        return $this->executeStatement("INSERT INTO `users` (`name`, `user_email`, `user_status`, `password`) VALUES
(?, ?, 1, ?)","sss", [$fullname, $email, md5($pass)]);
    }
}