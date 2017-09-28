<?php

class MemberExtension extends DataExtension {

	private static $db = array(
		'Username' => 'Varchar(63)',
		'ProfileHash' => 'Varchar(63)',
		'MakeMyPortfolioPublic' => 'Boolean(0)'
	);

	private static $has_one = array(
		'ShowPricesIn' => 'CurrencyType'
	);

	private static $has_many = array(
		'CurrencyTrades' => 'CurrencyTrade',
	);

  private static $many_many = array(
  );

  public static $many_many_extraFields = array(

  );


	private static $summary_fields = array(
		'Username',
    'MakeMyPortfolioPublic',
    'Created',
    'CurrencyTrades.Count',
    'TotalCurrentValue',
	);

	public static $default_sort = 'Created DESC';

  public function PortfolioPublicLink() {
    if ($this->owner->MakeMyPortfolioPublic){
      return 'portfolio/view/'.$this->owner->ProfileHash;
    }
  }

	public function onBeforeDelete() {
		foreach($this->CurrencyTrades() as $trade) {
			$trade->delete();
		}
	}

	public function TotalCost() {
		$total = 0;
		foreach($this->owner->CurrencyTrades() as $trade) {
			$total += $trade->TotalCost()->getAmount();
		}
		$myCurrency = $this->owner->ShowPricesIn();

		return Cash::make($myCurrency->TLA, $total);
	}

	public function TotalCurrentValue() {
		$total = 0;
		foreach($this->owner->CurrencyTrades() as $trade) {
			$total += $trade->CurrentValue()->getAmount();
		}
		$myCurrency = $this->owner->ShowPricesIn();
		return Cash::make($myCurrency->TLA,$total);
	}

	public function TotalProfit() {
		$profit = $this->TotalCurrentValue()->getAmount() - $this->TotalCost()->getAmount();
		$myCurrency = $this->owner->ShowPricesIn();
		return Cash::make($myCurrency->TLA,$profit);
	}

  public function TotalProfitPercent() {

    if($this->owner->TotalCost()->getAmount() == 0) {
      return '&#x221e;';
    }
    return round($this->owner->TotalCurrentValue()->getAmount() / $this->owner->TotalCost()->getAmount()*100);
  }

}
