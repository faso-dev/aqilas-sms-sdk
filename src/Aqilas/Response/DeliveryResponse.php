<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Response;
	
	class DeliveryResponse
	{
		protected array $data;
		
		public function __construct(array $data)
		{
			$this->data = $data;
		}
		
		public function data(): array
		{
			return $this->data;
		}
		
		public function phone(string $phoneNumber): string
		{
			foreach ($this->data as $smsState) {
				if ($smsState['to'] === $phoneNumber) {
					return [
						'DELIVERY_SMSC_SUCCESS' => 'success',
						'DELIVERY_PENDING' => 'pending',
						'DELIVERY_FAILURE' => 'fail'
					][$smsState['status']] ?? 'unknow';
				}
			}
			return 'unknow';
		}
	}
