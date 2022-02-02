<?php
class TransactionController extends BaseController
{
    protected  $strErrorDesc = '';
    protected $requestMethod;
    protected $arrQueryStringParams;

    public function __construct()
    {
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->arrQueryStringParams = $_POST;
    }

    public function createTransactionAction(){
        if(strtoupper($this->requestMethod) == 'POST'){
            try{
                $userModel = new UserModel();
                $accountModel = new AccountModel();
                $transactionModel = new TransactionModel();
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

                if (isset($this->arrQueryStringParams['sender']) && $this->arrQueryStringParams['sender']) {
                    $sender = $this->arrQueryStringParams['sender'];
                }
                else{
                    throw new Error('Sender Account Not Provided');
                }

                if (isset($this->arrQueryStringParams['receiver']) && $this->arrQueryStringParams['receiver']) {
                    $receiver = $this->arrQueryStringParams['receiver'];
                }
                else{
                    throw new Error('Receiver Account Not Provided');
                }

                $user = $userModel->getUser($email, $pass);
                if(empty($user)){
                    throw new Error('User Does Not Exist');
                }

                $senderAccount = $accountModel->getAccount($user[0]['ID'],(integer)$sender);
                if(empty($senderAccount) || $senderAccount[0]['balance'] < $amount){
                    throw new Error('Account does not exist or Not enough money');
                }

                $receiverAccount = $accountModel->getAccountWithoutCreds((integer) $receiver);
                if(empty($receiverAccount)){
                    throw new Error('Receiver Account does not exist');
                }

                $transaction = $transactionModel->addTransaction($sender, $receiver, $amount);
                $accountModel->updateFunds($receiver,$receiverAccount[0]['balance'] + $amount);
                $accountModel->updateFunds($sender,$senderAccount[0]['balance'] - $amount);
                $responseData = json_encode($transaction);
            }
            catch(Error $e){
                $this->strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }  else {
            $this->strErrorDesc = 'Method not supported';
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

    public function transactionsAction(){
        if(strtoupper($this->requestMethod) == 'POST'){
            try{
                $userModel = new UserModel();
                $transactionModel = new TransactionModel();
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

                $senderAccount = $accountModel->getAccount($user[0]['ID'],(integer)$account_id);
                if(empty($senderAccount)){
                    throw new Error('Account does not exist');
                }

                $transactions = $transactionModel->getTransactions($account_id);
                $responseData = json_encode($transactions);
            }
            catch(Error $e){
                $this->strErrorDesc = $e->getMessage().' Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }  else {
            $this->strErrorDesc = 'Method not supported';
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