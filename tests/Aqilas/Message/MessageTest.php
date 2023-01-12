<?php
	
	namespace FasoDev\AqilasSmsSdk\Tests\Aqilas\Message;
	
	use FasoDev\AqilasSmsSdk\Aqilas\Message\Message;
	use FasoDev\AqilasSmsSdk\Exceptions\MessageViolationConstraintException;
	use PHPUnit\Framework\TestCase;
	
	class MessageTest extends TestCase
	{
		public function testCanCreateValidMessage()
		{
			$message = (new Message('foo'))
				->create()
			;
			
			$this->assertEquals('foo', $message);
			$this->assertNotEmpty($message);
		}
		
		public function testCannotCreateMessageWithEmoji()
		{
			$this->expectException(MessageViolationConstraintException::class);
			$this->expectExceptionMessage('Your message contains emojis. Please remove them.');
			
			(new Message('foo👍'))->rejectEmojis()->create();
		}
		
		public function testCannotCreateMessageWithUnicode()
		{
			$this->expectException(MessageViolationConstraintException::class);
			$this->expectExceptionMessage('Your message contains unicode characters. Please remove them.');
			
			(new Message('La tête'))->rejectUnicode()->create();
		}
	}
