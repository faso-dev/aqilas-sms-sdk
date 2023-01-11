<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Config;
	
	class Config
	{
		protected string $apiKey;
		protected string $apiBaseUrl = 'https://www.aqilas.com/api/';
		protected string $apiVersion = 'v1';
		protected string $smsEndpoint = '/sms';
		
		private function __construct(string $apiKey)
		{
			$this->apiKey = $apiKey;
		}
		
		public static function defineApiKey(string $apiKey): self
		{
			return new self($apiKey);
		}
		
		public function defineBaseUrl(string $apiBaseUrl): self
		{
			$this->apiBaseUrl = $apiBaseUrl;
			
			return $this;
		}
		
		public function defineVersion(string $apiVersion): self
		{
			$this->apiVersion = $apiVersion;
			
			return $this;
		}
		
		public function defineSmsEndpoint(string $smsEndpoint): self
		{
			$this->smsEndpoint = $smsEndpoint;
			
			return $this;
		}
		
		public function apiKey(): string
		{
			return $this->apiKey;
		}
		
		public function apiBaseUrl(): string
		{
			return $this->apiBaseUrl;
		}
		
		public function apiVersion(): string
		{
			return $this->apiVersion;
		}
		
		public function smsEndpoint(): string
		{
			return $this->smsEndpoint;
		}
		
		public function smsEndpointUrl(): string
		{
			return $this->apiBaseUrl . $this->apiVersion . $this->smsEndpoint;
		}
		
	}
