<?php
class UserController extends BaseController
{
    protected  $strErrorDesc = '';
    protected $requestMethod;
    protected $arrQueryStringParams;

    public function __construct()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->arrQueryStringParams = $_POST;
    }

    public function createUserAction(){
        if(strtoupper($this->requestMethod) == 'POST'){
            try{
                $userModel = new UserModel();
                if (isset($this->arrQueryStringParams['email']) && $this->arrQueryStringParams['email']) {
                    $email = $this->arrQueryStringParams['email'];
                }
                else{
                    throw new Error('Email Not Provided');
                }

                if (isset($this->arrQueryStringParams['name']) && $this->arrQueryStringParams['name']) {
                    $fullname = $this->arrQueryStringParams['name'];
                }
                else{
                    throw new Error('Name Not Provided');
                }

                if (isset($this->arrQueryStringParams['pass']) && $this->arrQueryStringParams['pass']) {
                    $pass = $this->arrQueryStringParams['pass'];
                }
                else{
                    throw new Error('Password Not Provided');
                }
                $arrUsers = $userModel->createUser($email, $fullname, $pass);
                $responseData = json_encode($arrUsers);
            }
            catch(Error $e){
                $this->strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }  else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$this->strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $this->strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

}