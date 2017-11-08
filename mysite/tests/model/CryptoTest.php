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
		//@TODO: Add a test that creates a profit making crypto trade and tests the profit and percentage
  }

	public function testCryptoTradeLoss() {
		//@TODO: Add a test that creates a loss making crypto trade and tests the loss and percentage
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
