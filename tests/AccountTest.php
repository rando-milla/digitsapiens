<?php

use PHPUnit\Framework\TestCase;
require __DIR__ . "/../src/inc/bootstrap.php";
class AccountTest extends TestCase
{

    private $http;

    public function setUp() :void
    {
        $this->http = new GuzzleHttp\Client();
    }

    public function testGet()
    {
        $response = $this->http->post(PROJECT_URL.'/index.php/account/createaccount',[ 'form_params' => ['email'=>'test_php@test.com','amount'=>5, 'pass'=> 123]]);
        $this->assertEquals(200, $response->getStatusCode());

        $response = json_decode($response->getBody());

        $this->assertIsObject($response);

        $id = $response->id;
        $accountModel = new AccountModel();
        $user = $accountModel->getBalanaceById($id);
        $this->assertEquals($user[0]['Balance'], 5);
    }

    public function tearDown(): void {
        $this->http = null;
    }
}