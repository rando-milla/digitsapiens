<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/");
require_once PROJECT_ROOT_PATH . '/inc/config.php';
require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class Setup extends Database
{
    public function __construct()
    {
        parent::__construct();
        $templine = '';
        $lines = file(DB_BACKUP);
        foreach ($lines as $line) {
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                $this->executeStatement($templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
        return true;
    }
}

new Setup();