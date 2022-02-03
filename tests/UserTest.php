<?php

use PHPUnit\Framework\TestCase;
require __DIR__ . "/../src/inc/bootstrap.php";
class UserTest extends TestCase
{

    private $http;

    public function setUp() :void
    {
        $this->http = new GuzzleHttp\Client();
    }

    public function testGet()
    {
        $response = $this->http->post(PROJECT_URL.'/index.php/user/createuser',[ 'form_params' => ['email'=>'test_php@test.com','name'=>'test123', 'pass'=> 123]]);
        $this->assertEquals(200, $response->getStatusCode());

        $response = json_decode($response->getBody());

        $this->assertIsObject($response);

        $id = $response->id;
        $userModel = new UserModel();
        $user = $userModel->getUser('test_php@test.com', 123);
        $this->assertEquals($user[0]['ID'], $id);
    }

    public function tearDown(): void {
        $this->http = null;
    }
}