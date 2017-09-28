<?php

class CurrencyType extends DataObject {


	private static $db = array(
		'Name' => 'Varchar(255)',
		'TLA' => 'Varchar(20)',
		'AlternativeTLAs' => 'Varchar(20)',
		'Crypto' => 'Boolean',
		'AvailableSupply' => 'Decimal(20,1)',
		'TotalSupply' => 'Decimal(20,1)'
	);

	private static $has_one = array(
		'Logo' => 'Image'
	);

	private static $has_many = array(
		"Prices" => 'CurrencyPrice',
		"Trades" => 'CurrencyTrade'
	);

	private static $summary_fields = array(
		'Name',
		'Logo',
		'TLA',
		'AlternativeTLAs',
		'PricePerUnit'

	);

	private static $casting = array(
		'currentPrice' => 'Money',
		'PricePerUnit' => 'Money',
		'currentPriceMyCurrency' => 'Money',
		'PricePerUnitMyCurrency' => 'Money',
	);

	public function Logo() {
		return '<img src="https://bravenewcoin.com/images/coins/'.$this->TLALower().'.png" />';
	}

	public function TLALower() {
		return strtolower($this->TLA);
	}

	public function NameAndTLA() {
		return $this->Name.' ('.$this->TLA.')';
	}

	public function getTitle() {
		return $this->Name;
	}

	public function onBeforeDelete() {
		parent::onBeforeDelete();
		foreach($this->Prices() as $price) {
			$price->delete();
		}
	}

	/**
	 * $1 currently buys how many of these coins
	 *
	 */
	public function currentPrice() {
		$prices = $this->Prices();
		if($prices->count() > 0){
			// die('prices'.$prices->count());
			return Cash::make('USD', 1/$this->PricePerUnit()->getAmount());
		}
		if (!Member::currentUser() || Member::currentUser()->ShowPricesInID == 0) {
			return Cash::make('USD', 1);
		}
		return Cash::make('USD', 0);
	}


	/**
	 * How many $ is one of these coins
	 *
	 */
	public function PricePerUnit() {
		$prices = $this->Prices();
		if ($prices->count() == 0){
			return Cash::make('USD', 0);
		}
		$price = $prices->sort('Created DESC')->first()->PriceUSD;
		return Cash::make('USD', $price);

	}

	public function PriceDaysAgo($days = 1) {
		$hours = $days * 24;
		$prices = $this->Prices();
		if($prices->count() > 0){
			$allprices = $prices->filter('Created:LessThan', date('Y-m-d h:i:s', strtotime('-'.$hours.' hours')) )->sort('Created DESC');
			// debug::show($allprices);
			if($allprices->count()) {
				return Cash::make('USD', $allprices->first()->PriceUSD);
			}
		}
		return Cash::make('USD', 0);
	}

	public function PricePerUnitDaysAgo($days = 1) {
		$price = $this->PriceDaysAgo($days);
		if ($price->getAmount() == 0){
			return Cash::make('USD', 0);
		}
		return Cash::make('USD', 1/$price->getAmount());
	}

	public function PercentageChangeSince($days = 1) {
		$pricePerUnit = $this->PricePerUnit();
		$pricePerUnitAgo = $this->PricePerUnitDaysAgo($days);
		if($pricePerUnitAgo->getAmount() == 0) return '0.00';
		$percent = $pricePerUnit->getAmount() / $pricePerUnitAgo->getAmount() * 100 - 100;
		return number_format((float)$percent, 1, '.', '');
	}

	public function PercentageChangeNiceSince($days = 1) {
		$percent = $this->PercentageChangeSince($days);
		if($percent < 0) {
			return '<span class="price-decrease"><i class="fa fa-caret-down" aria-hidden="true"></i>'.$percent.'%</span>';
		}
		return '<span class="price-increase"><i class="fa fa-caret-up" aria-hidden="true"></i>'.$percent.'%</span>';
	}

	public function GetPricesSince($days = 7){
		$allprices = $this->Prices()->filter('Created:GreaterThan', date('Y-m-d h:i:s', strtotime('-'.$days.' days')) )->sort('Created ASC');
		return $allprices;
	}

	public static $btcMultiplier = false;
	public $ActualValuePerUnitCached = false;
	public function ActualValuePerUnit(){

		if($this->ActualValuePerUnitCached) return $this->ActualValuePerUnitCached;
		if($this->TotalSupply == 0) return 0;

		if(!self::$btcMultiplier){
			$btc = CurrencyType::get()->find('TLA', 'BTC');
			self::$btcMultiplier = 1/($btc->PricePerUnit()->getAmount()/$btc->TotalSupply);
		}

		$this->ActualValuePerUnitCached = number_format (($this->PricePerUnit()->getAmount()/$this->TotalSupply) * self::$btcMultiplier,15);
		return $this->ActualValuePerUnitCached;
	}

	public function ActualValueWholeNumber(){
		$val = $this->ActualValuePerUnit();
		return substr($val, 0, strpos($val, '.'));
	}

	public function ActualValueWholeDecimals(){
		$val = $this->ActualValuePerUnit();
		return substr($val, strpos($val, '.')+1);
	}

	public function AvailableMarketCap(){
		return $this->PricePerUnit()->getAmount()*$this->AvailableSupply;
	}
	public function TotalMarketCap(){
		return $this->PricePerUnit()->getAmount()*$this->TotalSupply;
	}
}
