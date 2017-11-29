<?php

class CurrencyTrade extends DataObject {


	private static $db = array(
		'Amount' => 'Decimal(16,8)',
		'Cost' => 'Decimal(16,8)',
		'Date' => 'Date',
	);

	private static $has_one = array(
		'Currency' => 'CurrencyType',
		'Member' => 'Member'
	);

	private static $summary_fields = array(
		'Currency.TLA',
		'Currency.Name',
		'Amount',
		'Cost'

	);

	private static $casting = array(
		'Cost' => 'Money',
		'CostMyCurrency' => 'Money',
		'TotalCost' => 'Money',
		'CurrentValue' => 'Money',
		'Profit' => 'Money',
	);

	public function Amount1DP() {
		return number_format ($this->Amount, 1);
	}

	public function CurrencyTitle() {
		return $this->Currency()->Name;
	}

	public function CreateUSD() {
		$usd = CurrencyType::create();
		$usd->TLA = 'USD';
		$usd->CurrentPrice = 1;
		return $usd;
	}

	public function getCurrentCurrency(){
		if(!$member = Member::currentUser()) $member = self::$ViewMember;
		if(!$member) return $this->CreateUSD();
		return $member->ShowPricesIn();
	}

  public static $ViewMember = false;
	public function PricePerUnitMyCurrency() {
		if(!$member = Member::currentUser()){
			$member = self::$ViewMember;
		}
		if(!$member) {
			$myCurrency = $this->CreateUSD();
		}
		else {
			$myCurrency = $member->ShowPricesIn();
		}
		return Cash::make($myCurrency->TLA, $this->Currency()->PricePerUnit()->getAmount() * $myCurrency->currentPrice()->getAmount());
	}

	public function currentPriceMyCurrency() {
		if(!$member = Member::currentUser()){
			$member = self::$ViewMember;
			//return Cash::make($myCurrency->TLA, $this->Currency()->currentPrice());
		}

		$myCurrency = $member->ShowPricesIn();
		return Cash::make($myCurrency->TLA, $this->Currency()->currentPrice()->getAmount() * $myCurrency->currentPrice());
	}

  public function CostMyCurrency() {
  	$myCurrency = $this->getCurrentCurrency();
  	return Cash::make($myCurrency->TLA, $this->Cost * $myCurrency->currentPrice()->getAmount());
  }

	public function TotalCost() {
		$myCurrency = $this->getCurrentCurrency();
		return Cash::make($myCurrency->TLA,
			$this->Amount *
			$this->CostMyCurrency()->getAmount());
	}

	public function CurrentValue() {
		$myCurrency = $this->getCurrentCurrency();
		return Cash::make($myCurrency->TLA, $this->Amount * $this->PricePerUnitMyCurrency()->getAmount() * 0.8);
	}

	public function ProfitPercent() {
		//$myCurrency = MemberExtension::getUserCurrency();
		if($this->TotalCost()->getAmount() == 0) {
			return '&#x221e;';
		}
		$diff = $this->currentValue()->getAmount() - $this->TotalCost()->getAmount();
		return round($diff / $this->TotalCost()->getAmount()*100);
	}

	public function Profit() {
		$myCurrency = $this->getCurrentCurrency();
		return Cash::make($myCurrency->TLA, $this->currentValue()->getAmount() - $this->TotalCost()->getAmount());
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('CurrencyID');

		$currencyField = DropdownField::create('CurrencyID', 'Currency', CurrencyType::get()->map('ID', 'Name'), $this->CurrencyID);
		$fields->insertBefore('Amount', $currencyField);


		return $fields;
	}
}
