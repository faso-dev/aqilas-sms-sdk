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
  returns an instance of `FasoDev\AqilasSmsSdk\Aqilas\Response\Response` which contains the response from the API.

## Contributing

Contributions are welcome! Feel free to open an issue or a pull request.

## License

[MIT](https://choosealicense.com/licenses/mit/)
