# aqilas-sms-sdk

An unofficial SDK to conciliate AQILAS SMS REST API integration in php project by providing a set of classes and
functions to interact with the API.
The goal of this package is to simplify the use of the AQILAS SMS API without having to deal with the HTTP requests
and the JSON responses in your code.

## Requirements

Before using this package, you need to have a valid <strong>API KEY</strong> from AQILAS SMS(https://www.aqilas.com).
You also need to have theses requirements installed:

- PHP 7.4 or higher
- composer
- ext-json
- ext-curl

## Installation

You can install the package using composer:

```bash
composer require faso-dev/aqilas-sms-sdk
```

## Usage

When you have installed the package, you can use it in your code:

```php
<?php
	
	use FasoDev\AqilasSmsSdk\Aqilas\AqilasSMS;
	use FasoDev\AqilasSmsSdk\Aqilas\Config\Config;
	use FasoDev\AqilasSmsSdk\Aqilas\Sms\SMS;
	
	$config = Config::defineApiKey('YOUR_API_KEY')
	                ->defineBaseUrl('https://www.aqilas.com/api/')
	                ->defineVersion('v1')
	                ->defineSmsEndpoint('/sms')
	;
	
	$aqilas = AqilasSMS::loadConfig($config);
	
	
	$sms = SMS::from('56000')
	          ->to('702000000')
	          ->content('Hello world')
	;
	
	$response = $aqilas->send($sms);

```

- The `Config` class is used to configure the client such as defining the API KEY, the base URL, the version and the SMS
  endpoint.
- The `AqilasSMS` class is used to load the configuration and to interact with the API.
- The `SMS` class is used to define the SMS to send.
- The `send()` method is used to send the SMS.
  This method takes an instance of `SMS` as parameter and
  returns an instance of `FasoDev\AqilasSmsSdk\Aqilas\Response\SMSResponse` which contains the response from the API.

## AqilasSMS

The `AqilasSMS` class is used to load the configuration and allows you to interact with the API with theses methods:

- `send(SMS $sms)`: This method is used to send the SMS.
  This method takes an instance of `SMS` as parameter and
  returns an instance of `FasoDev\AqilasSmsSdk\Aqilas\Response\SMSResponse` which contains the response from the API.
- `balance()`: This method is used to get the balance of the account.
  This method returns an instance of `FasoDev\AqilasSmsSdk\Aqilas\Response\BalanceResponse` which contains the response
  from the API.
- `deliveryStatus(string $bulkId)`: This method is used to get the status of a SMS.
  This method takes the bulk_id of the SMS as parameter and returns an instance of
  `FasoDev\AqilasSmsSdk\Aqilas\Response\DeliveryResponse` which contains the response from the API.

## Message

Some times, you may want to validate the content of a message before it sending.
If you want to do that, you can use the `FasoDev\AqilasSmsSdk\Aqilas\Message\Message` class:

```php
<?php
    
	use FasoDev\AqilasSmsSdk\Aqilas\Message\Message;
	use FasoDev\AqilasSmsSdk\Exceptions\MessageViolationConstraintException;
	
    try {
        $message = (new Message('Hello world'))
            ->rejectUnicode() // if you want only ASCII characters
            ->rejectEmojis() // if you don't allow emojis in your messages
            ->maxSMS(2) // if you want to limit the number of SMS from the message
            ->create()
        ;
  
    } catch (MessageViolationConstraintException $e) {
        echo $e->getMessage();
    }
```

The `Message` class have theses methods:

- `rejectUnicode()` : Rejects the message if it contains unicode characters.
- `rejectEmojis()` : Rejects the message if it contains emojis.
- `maxSMS(int $max)` : Rejects the message if it contains more than `$max` SMS.
- `create()` : Creates the message and return the content as a string.
  Please note that thise method will throw a `MessageViolationConstraintException` if the message doesn't respect the
  constraints.

## Response

- The `FasoDev\AqilasSmsSdk\Aqilas\Response\SMSResponse` class is used to represent the response from the API when you
  send a SMS.
  You can get theses informations from the response:
    - `bulkId()` : The bulk ID of the SMS.
    - `cost()` : The cost of the SMS.
    - `currency()` : The currency of the cost.
    - `message()` : The message of the response.
    - `status()` : The status of the response.

- The `FasoDev\AqilasSmsSdk\Aqilas\Response\BalanceResponse` class is used to represent the response from the API when
  you want to get your balance.
  You can get theses informations from the response:
    - `success()` : The success status of the response.
    - `solde()` : The balance of your account.
    - `currency()` : The currency of the balance.
    - `formatedSolde()` : The balance of your account formatted with the currency.
    - `formatedCurrency()` : The currency of your account formatted in the form `currency (symbol)`.

- The `FasoDev\AqilasSmsSdk\Aqilas\Response\DeliveryResponse` class is used to represent the response from the API when
  you want to get the delivery status of a SMS.
  You can get theses informations from the response:
    - `data()` : The data of the response.
    - `phone(string $phoneNumber)` : The delivery status of the SMS sent to the phone number `$phoneNumber`.

## Contributing

Contributions are welcome! Feel free to open an issue or a pull request.

## License

[MIT](https://choosealicense.com/licenses/mit/)
