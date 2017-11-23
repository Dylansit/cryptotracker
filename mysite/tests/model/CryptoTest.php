<?php
class CryptoTest extends FunctionalTest {

	protected static $fixture_file = 'CryptoTest.yml';

	protected $orig = array();

	protected $tmpAssetsPath = '';

  public function testPricePerUnit() {
    $btc = $this->objFromFixture('CurrencyType', 'BTC');
    $this->assertEquals('7000', $btc->PricePerUnit());
  }

	public function testCryptoTradeProfit() {
		//set up the currency trade object with cost and amount
		$trade = new CurrencyTrade();
		$trade->CurrencyID = $this->objFromFixture('CurrencyType', 'BTC')->ID;
		$trade->Cost = 3000;
		$trade->Amount = 3;

		//calculate the profit that this trade has generated.
		$profit = $trade->Profit()->getAmount();

		//@TODO: Update the assert statement to make sure the profit
		// is what you expect from the system
		// (remember that the test data has the current price of a bitcoin at 7000)
		$this->assertEquals(123, $profit);
  }

	public function testCryptoTradeProfitPercent() {
		$trade = new CurrencyTrade();
		$trade->CurrencyID = $this->objFromFixture('CurrencyType', 'BTC')->ID;
		$trade->Cost = 3000;
		$trade->Amount = 3;

		$profitpercent = $trade->ProfitPercent();

		//@TODO: Update the assert statement to make sure the profit percentage
		// is what you expect from the system
		// (remember that the test data has the current price of a bitcoin at 7000)
		$this->assertEquals(123, $profitpercent);
	}

	public function testCryptoTradeLoss() {
		$trade = new CurrencyTrade();
		$trade->CurrencyID = $this->objFromFixture('CurrencyType', 'BTC')->ID;
		$trade->Cost = 10000;
		$trade->Amount = 3;
		$profit = $trade->Profit()->getAmount();
		$profitpercent = $trade->ProfitPercent();

		//@TODO: Update the assert statement to make sure the loss
		// is what you expect from the system
		// (remember that the test data has the current price of a bitcoin at 7000)
		$this->assertEquals(123, $profit);
		$this->assertEquals(123, $profitpercent);
  }

	public function testCryptoTradeLossPercent() {
		$trade = new CurrencyTrade();
		$trade->CurrencyID = $this->objFromFixture('CurrencyType', 'BTC')->ID;
		$trade->Cost = 10000;
		$trade->Amount = 3;
		$profitpercent = $trade->ProfitPercent();

		//@TODO: Update the assert statement to make sure the loss percentage
		// is what you expect from the system
		// (remember that the test data has the current price of a bitcoin at 7000)
		$this->assertEquals(123, $profitpercent);
  }

	public function testMemberCost() {
		$this->assertEquals('3200',  $this->objFromFixture('Member', '1')->TotalCost());
	}

	public function testMemberCurrentValue() {
		$this->assertEquals('27000',  $this->objFromFixture('Member', '1')->TotalCurrentValue());
	}

	public function testMemberProfit() {
		$this->assertEquals('23800',  $this->objFromFixture('Member', '1')->TotalProfit());
	}



}
