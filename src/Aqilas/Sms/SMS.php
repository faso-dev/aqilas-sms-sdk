<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Sms;
	
	use JsonSerializable;
	use function is_string;
	
	class SMS implements SMSLable
	{
		private string $senderId;
		private array $to;
		private string $message;
		
		private function __construct(string $senderId)
		{
			$this->senderId = $senderId;
		}
		
		public static function from(string $senderId): self
		{
			return new self($senderId);
		}
		
		public function to($to): self
		{
			$this->to = is_string($to) ? [$to] : $to;
			
			return $this;
		}
		
		public function content(string $message): self
		{
			$this->message = $message;
			
			return $this;
		}
		
		public function jsonSerialize(): array
		{
			return [
				'from' => $this->senderId,
				'to' => $this->to,
				'text' => $this->message,
			];
		}
	}
