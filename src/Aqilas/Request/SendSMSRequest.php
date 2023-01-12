<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Request;
	
	use FasoDev\AqilasSmsSdk\Aqilas\Response\SMSResponse;
	use FasoDev\AqilasSmsSdk\Exceptions\RequestException;
	use FasoDev\SimpleCurlClient\Curl\CurlClientBuilder;
	use FasoDev\SimpleCurlClient\Curl\CurlRequestErrorException;
	use function json_encode;
	
	class SendSMSRequest
	{
		/**
		 * @throws CurlRequestErrorException
		 */
		public static function request(string $url, array $data, string $auth): SMSResponse
		{
			$response = CurlClientBuilder::create()
			                             ->build()
			                             ->post(
				                             $url,
				                             json_encode($data), [
					                             'headers' => [
						                             'X-AUTH-TOKEN' => $auth,
						                             'Content-Type' => 'application/json',
					                             ]
				                             ]
			                             )
			;
			if ($response->status() == 200) {
				$data = $response->json();
				return new SMSResponse(
					$data['success'],
					$data['message'],
					$data['bulk_id'],
					$data['cost'],
					$data['currency'],
				);
			}
			throw new RequestException(
				$response->body(),
				$response->status()
			);
		}
	}
