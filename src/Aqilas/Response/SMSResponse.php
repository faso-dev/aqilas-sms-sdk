<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Response;
	
	class SMSResponse
	{
		protected bool $success;
		protected string $message;
		protected string $bulkId;
		protected int $cost;
		protected string $currency;
		
		public function __construct(bool   $success,
		                            string $message,
		                            string $bulkId,
		                            int    $cost,
		                            string $currency
		)
		{
			$this->success = $success;
			$this->bulkId = $bulkId;
			$this->cost = $cost;
			$this->currency = $currency;
			$this->message = $message;
		}
		
		public function success(): bool
		{
			return $this->success;
		}
		
		public function bulkId(): string
		{
			return $this->bulkId;
		}
		
		public function cost(): int
		{
			return $this->cost;
		}
		
		public function message(): string
		{
			return $this->message;
		}
		
		public function currency(): string
		{
			return $this->currency;
		}
	}
