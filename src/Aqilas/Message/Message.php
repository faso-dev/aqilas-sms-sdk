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
			if ($this->rejectUnicode && $this->isUnicodeLetter($this->message)) {
				throw new MessageViolationConstraintException(
					'Your message contains unicode characters. Please remove them.'
				);
			}
			
			if ($this->rejectEmojis && preg_match('([*#0-9](?>\\xEF\\xB8\\x8F)?\\xE2\\x83\\xA3|\\xC2[\\xA9\\xAE]|\\xE2..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?(?>\\xEF\\xB8\\x8F)?|\\xE3(?>\\x80[\\xB0\\xBD]|\\x8A[\\x97\\x99])(?>\\xEF\\xB8\\x8F)?|\\xF0\\x9F(?>[\\x80-\\x86].(?>\\xEF\\xB8\\x8F)?|\\x87.\\xF0\\x9F\\x87.|..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?|(((?<zwj>\\xE2\\x80\\x8D)\\xE2\\x9D\\xA4\\xEF\\xB8\\x8F\k<zwj>\\xF0\\x9F..(\k<zwj>\\xF0\\x9F\\x91.)?|(\\xE2\\x80\\x8D\\xF0\\x9F\\x91.){2,3}))?))', $this->message)) {
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
		
		private function isUnicodeLetter(string $char): bool
		{
			return preg_match('/[^\x00-\x7F]/', $char);
		}
	}
