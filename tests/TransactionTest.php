<?php

use PHPUnit\Framework\TestCase;
require __DIR__ . "/../src/inc/bootstrap.php";
class TransactionTest extends TestCase
{

    private $http;

    public function setUp() :void
    {
        $this->http = new GuzzleHttp\Client();
    }

    public function testGet()
    {
        $userModel = new UserModel();
        $user = $userModel->getUser('test_php@test.com', 123);

        $accountModel = new AccountModel();
        $account = $accountModel->getAccounById($user[0]['ID']);

        $response = $this->http->post(PROJECT_URL.'/index.php/transaction/createtransaction',[ 'form_params' => ['email'=>'test_php@test.com','amount'=>5, 'pass'=> 123, 'sender'=> $account[0]['id'], 'receiver'=> 1]]);
        $this->assertEquals(200, $response->getStatusCode());

        $response = json_decode($response->getBody());

        $this->assertIsObject($response);

        $id = $response->id;
        $transactionModel = new TransactionModel();
        $transaction = $transactionModel->getTransactions($account[0]['id']);
        $this->assertEquals($transaction[0]['id'], $id);
    }

    public function tearDown(): void {
        $this->http = null;
    }
}