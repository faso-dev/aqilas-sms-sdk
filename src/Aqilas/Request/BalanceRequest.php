<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Request;
	
	use FasoDev\AqilasSmsSdk\Aqilas\Response\BalanceResponse;
	use FasoDev\AqilasSmsSdk\Exceptions\RequestException;
	use FasoDev\SimpleCurlClient\Curl\CurlClientBuilder;
	use FasoDev\SimpleCurlClient\Curl\CurlRequestErrorException;
	
	class BalanceRequest
	{
		/**
		 * @throws CurlRequestErrorException
		 */
		public static function request(string $url, string $auth): BalanceResponse
		{
			$response = CurlClientBuilder::create()
			                             ->build()->get(
					$url,
					[],
					[
						'headers' => [
							'X-AUTH-TOKEN' => $auth,
							'Content-Type' => 'application/json',
						]
					]
				)
			;
			if ($response->status() === 200) {
				$data = $response->json();
				return new BalanceResponse(
					$data['success'],
					$data['credit'],
					$data['currency']
				);
			}
			throw new RequestException(
				$response->body(),
				$response->status()
			);
		}
	}
