<?php
class AccountController extends BaseController
{
    protected  $strErrorDesc = '';
    protected $requestMethod;
    protected $arrQueryStringParams;
    protected $responseData = '';
    protected $strErrorHeader = '';

    public function __construct()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->arrQueryStringParams = $_POST;
    }

    public function createAccountAction(){

        if(strtoupper($this->requestMethod) == 'POST'){
            try{
                $userModel = new UserModel();
                $accountModel = new AccountModel();
                if (isset($this->arrQueryStringParams['email']) && $this->arrQueryStringParams['email']) {
                    $email = $this->arrQueryStringParams['email'];
                }
                else{
                    throw new Error('Email Not Provided');
                }

                if (isset($this->arrQueryStringParams['pass']) && $this->arrQueryStringParams['pass']) {
                    $pass = $this->arrQueryStringParams['pass'];
                }
                else{
                    throw new Error('Password Not Provided');
                }

                if (isset($this->arrQueryStringParams['amount']) && $this->arrQueryStringParams['amount']) {
                    $amount = $this->arrQueryStringParams['amount'];
                }
                else{
                    throw new Error('Amount Not Provided');
                }

                $user = $userModel->getUser($email, $pass);
                if(empty($user)){
                    throw new Error('User Does Not Exist');
                }
                $arrUsers = $accountModel->createAccount($user[0]['ID'], (float) $amount);
                $this->responseData =json_encode(['id' => $arrUsers]);
            }
            catch(Error $e){
                $this->strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $this->strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }  else {
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if (!$this->strErrorDesc) {
            $this->sendOutput(
                $this->responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $this->strErrorDesc)),
                array('Content-Type: application/json', $this->strErrorHeader)
            );
        }
    }

    public function balanceAction(){
        if(strtoupper($this->requestMethod) == 'POST'){
            try{
                $userModel = new UserModel();
                $accountModel = new AccountModel();
                if (isset($this->arrQueryStringParams['email']) && $this->arrQueryStringParams['email']) {
                    $email = $this->arrQueryStringParams['email'];
                }
                else{
                    throw new Error('Email Not Provided');
                }

                if (isset($this->arrQueryStringParams['pass']) && $this->arrQueryStringParams['pass']) {
                    $pass = $this->arrQueryStringParams['pass'];
                }
                else{
                    throw new Error('Password Not Provided');
                }

                if (isset($this->arrQueryStringParams['account_id']) && $this->arrQueryStringParams['account_id']) {
                    $account_id = $this->arrQueryStringParams['account_id'];
                }
                else{
                    throw new Error('Account ID Not Provided');
                }

                $user = $userModel->getUser($email, $pass);
                if(empty($user)){
                    throw new Error('User Does Not Exist');
                }
                $balance = $accountModel->getBalance($user[0]['ID'], $account_id);
                $this->responseData = json_encode($balance);
            }
            catch(Error $e){
                $this->strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $this->strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }  else {
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output
        if (!$this->strErrorDesc) {
            $this->sendOutput(
                $this->responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $this->strErrorDesc)),
                array('Content-Type: application/json', $this->strErrorHeader)
            );
        }
    }
}