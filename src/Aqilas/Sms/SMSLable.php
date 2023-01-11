<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Sms;
	
	use JsonSerializable;
	
	interface SMSLable extends JsonSerializable
	{
		public static function from(string $senderId): self;
		
		public function to($to): self;
		
		public function content(string $message): self;
	}
