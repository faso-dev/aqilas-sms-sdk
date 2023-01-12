<?php
	
	namespace FasoDev\AqilasSmsSdk\Aqilas\Response;
	
	use function number_format;
	
	class BalanceResponse
	{
		protected bool $success;
		protected int $solde;
		protected string $currency;
		
		public function __construct(bool $success, int $solde, string $currency)
		{
			$this->success = $success;
			$this->solde = $solde;
			$this->currency = $currency;
		}
		
		public function success(): bool
		{
			return $this->success;
		}
		
		public function solde(): int
		{
			return $this->solde;
		}
		
		public function currency(): string
		{
			return $this->currency;
		}
		
		public function formatedSolde(): string
		{
			return $this->getCurrentyNumberFormat($this->solde);
		}
		
		public function formatedCurrency(): string
		{
			return $this->getHumanReadableCurrency();
		}
		
		private function getCurrentyNumberFormat(int $value): string
		{
			return [
				'USD' => '$' . number_format($value, 2, '.', ','),
				'EUR' => '€' . number_format($value, 2, '.', ','),
				'XOF' => number_format($value, 0, '.', ',') . ' F CFA',
			][$this->currency] ?? $value;
		}
		
		
		public function __toString(): string
		{
			return "Votre solde est de {$this->solde} {$this->getHumanReadableCurrency()}";
		}
		
		private function getHumanReadableCurrency(): string
		{
			return [
				'XOF' => 'Franc CFA',
				'XAF' => 'Franc CFA',
				'EUR' => 'Euro',
				'USD' => 'Dollar',
			][$this->currency] ?? $this->currency;
		}
	}
