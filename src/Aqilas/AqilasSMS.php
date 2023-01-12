<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas;
	
	use FasoDev\AqilasSmsSdk\Aqilas\Config\Config;
	use FasoDev\AqilasSmsSdk\Aqilas\Request\BalanceRequest;
	use FasoDev\AqilasSmsSdk\Aqilas\Request\DeliveryRequest;
	use FasoDev\AqilasSmsSdk\Aqilas\Request\SendSMSRequest;
	use FasoDev\AqilasSmsSdk\Aqilas\Response\BalanceResponse;
	use FasoDev\AqilasSmsSdk\Aqilas\Response\DeliveryResponse;
	use FasoDev\AqilasSmsSdk\Aqilas\Sms\SMSLable;
	use FasoDev\AqilasSmsSdk\Exceptions\RequestException;
	use FasoDev\SimpleCurlClient\Curl\CurlClientBuilder;
	use FasoDev\SimpleCurlClient\Curl\CurlRequestErrorException;
	use FasoDev\SimpleCurlClient\Http\ClientResponseInterface;
	use function var_dump;
	
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
		public function send(SMSLable $sms): Response\SMSResponse
		{
			return SendSMSRequest::request(
				$this->config->smsEndpointUrl(),
				$sms->jsonSerialize(),
				$this->config->apiKey()
			);
		}
		
		/**
		 * @throws CurlRequestErrorException
		 */
		public function balance(): BalanceResponse
		{
			return BalanceRequest::request($this->config->balanceEndpointUrl(), $this->config->apiKey());
		}
		
		/**
		 * @throws CurlRequestErrorException
		 * @throws RequestException
		 */
		public function deliveryStatus(string $bulkId): DeliveryResponse
		{
			return DeliveryRequest::request(
				$this->config->smsEndpointUrl() . '/' . $bulkId,
				$this->config->apiKey()
			);
		}
	}
