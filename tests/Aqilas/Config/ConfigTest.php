<?php
	
	namespace FasoDev\AqilasSmsSdk\Tests\Aqilas\Config;
	
	use FasoDev\AqilasSmsSdk\Aqilas\Config\Config;
	use PHPUnit\Framework\TestCase;
	
	class ConfigTest extends TestCase
	{
		public function testCanInstantiateConfig()
		{
			$this->assertInstanceOf(
				Config::class,
				Config::defineApiKey('foo')
			);
		}
		
		public function testCanDefineConfig()
		{
			$config = Config::defineApiKey('foo')
			                ->defineBalanceEndpoint('/foo/bar')
			                ->defineSmsEndpoint('/foo/bar')
			                ->defineVersion('v1')
			                ->defineBaseUrl('https://foo.bar')
			;
			
			$this->assertEquals('foo', $config->apiKey());
			$this->assertEquals('/foo/bar', $config->balanceEndpoint());
			$this->assertEquals('/foo/bar', $config->smsEndpoint());
			$this->assertEquals('v1', $config->apiVersion());
			$this->assertEquals('https://foo.bar', $config->apiBaseUrl());
		}
	}
