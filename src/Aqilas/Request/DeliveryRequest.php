<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Request;
	
	use FasoDev\AqilasSmsSdk\Aqilas\Response\DeliveryResponse;
	use FasoDev\AqilasSmsSdk\Exceptions\RequestException;
	use FasoDev\SimpleCurlClient\Curl\CurlClientBuilder;
	use FasoDev\SimpleCurlClient\Curl\CurlRequestErrorException;
	
	class DeliveryRequest
	{
		/**
		 * @throws CurlRequestErrorException
		 * @throws RequestException
		 */
		public static function request(string $url, string $auth): DeliveryResponse
		{
			$response = CurlClientBuilder::create()
			                             ->build()
			                             ->get($url, [], [
				                             'headers' => [
					                             'Accept' => 'application/json',
					                             'Content-type' => 'application/json',
					                             'X-AUTH-TOKEN' => $auth
				                             ]
			                             ])
			;
			if ($response->status() === 200) {
				return new DeliveryResponse($response->json());
			}
			throw new RequestException(
				$response->body(),
				$response->status()
			);
		}
	}
