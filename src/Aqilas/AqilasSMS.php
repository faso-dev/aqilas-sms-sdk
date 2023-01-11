<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas;
	
	use FasoDev\AqilasSmsSdk\Aqilas\Config\Config;
	use FasoDev\AqilasSmsSdk\Aqilas\Sms\SMSLable;
	use FasoDev\SimpleCurlClient\Curl\CurlClientBuilder;
	use FasoDev\SimpleCurlClient\Curl\CurlRequestErrorException;
	use FasoDev\SimpleCurlClient\Http\ClientResponseInterface;
	
	class AqilasSMS
	{
		private Config $config;
		
		private function __construct(Config $config)
		{
			$this->config = $config;
		}
		
		public static function loadConfig(Config $config): self
		{
			return new self($config);
		}
		
		/**
		 * @throws CurlRequestErrorException
		 */
		public function send(SMSLable $sms): ClientResponseInterface
		{
			 return CurlClientBuilder::create()
				 ->build()->post(
					 $this->config->smsEndpointUrl(),
					 $sms->jsonSerialize(),[
						 'headers' => [
							 'X-AUTH-TOKEN' => $this->config->apiKey(),
							 'Content-Type' => 'application/json',
						 ]
					 ]
				 );
			 
		}
	}
