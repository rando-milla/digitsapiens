# Assignment 

This project is regarding an assignment.

## Installation

<ol>
<li>Change the configuration on the src/inc/config.php</li>
<li>Run the setup.php file or import manually the db.sql</li>
<li>Run composer install (required for phpunit)</li>
</ol>

## API Endpoints

<h3> Users </h3>
<ul><li>http://domain.local/user/createuser</li></ul>

<h3> Account </h3>
<ul>
<li>http://domain.local/account/createaccount</li>
<li>http://domain.local/account/balance</li>
</ul>
<h3> Transaction </h3>
<ul>
<li>http://domain.local/transaction/transactions</li>
<li>http://domain.local/transaction/createtransaction</li>
</ul>

## Tests
Please run the tests at the following order:
<ol>
<li>UserTest</li>
<li>AccountTest</li>
<li>TransactionTest</li>
</ol>

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)