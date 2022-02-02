<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ((isset($uri[2]) && $uri[2] != 'user' && $uri[2] != 'account' && $uri[2] != 'transaction') || !isset($uri[3])) {
    echo $uri[2];
    header("HTTP/1.1 404 Not Found");
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/AccountController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/TransactionController.php";

if($uri[2] == 'user'){
    $objFeedController = new UserController();

}

if($uri[2] == 'account'){
    $objFeedController = new AccountController();
}

if($uri[2] == 'transaction'){
    $objFeedController = new TransactionController();
}
$strMethodName = $uri[3] . 'Action';
$objFeedController->{$strMethodName}();
?>