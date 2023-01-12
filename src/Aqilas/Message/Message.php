<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Message;
	
	use FasoDev\AqilasSmsSdk\Exceptions\MessageViolationConstraintException;
	use function preg_match;
	
	class Message
	{
		protected string $message;
		protected bool $rejectUnicode = false;
		protected bool $rejectEmojis = false;
		protected int $maxSMS = -1;
		
		public function __construct(string $message)
		{
			$this->message = $message;
		}
		
		public function rejectEmojis(): self
		{
			$this->rejectEmojis = true;
			
			return $this;
		}
		
		public function rejectUnicode(): self
		{
			$this->rejectUnicode = true;
			
			return $this;
		}
		
		public function maxSMS(int $max): self
		{
			$this->maxSMS = $max;
			
			return $this;
		}
		
		/**
		 * @throws MessageViolationConstraintException
		 */
		public function create(): string
		{
			if ($this->rejectUnicode && preg_match('/[\x{10000}-\x{10FFFF}]/u', $this->message)) {
				throw new MessageViolationConstraintException(
					'Your message contains unicode characters. Please remove them.'
				);
			}
			
			if ($this->rejectEmojis && preg_match('/[\x{1F600}-\x{1F64F}]/u', $this->message)) {
				throw new MessageViolationConstraintException(
					'Your message contains emojis. Please remove them.'
				);
			}
			
			if (-1 !== $this->maxSMS && ceil(mb_strlen($this->message, 'UTF-8') / 160) > $this->maxSMS) {
				throw new MessageViolationConstraintException(
					'Your message is too long. Max characters: ' . $this->maxSMS * 160
				);
			}
			
			return $this->message;
		}
	}
