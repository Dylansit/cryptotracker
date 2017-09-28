<?php

class CurrencyPrice extends DataObject {


	private static $db = array(
		'PriceBTC' => 'Decimal(16,8)',
		'PriceUSD' => 'Decimal(16,8)'
	);

	private static $has_one = array(
		'Currency' => 'CurrencyType'
	);

	private static $summary_fields = array(
		'Created.Nice',
		'Created.Ago',
		'Currency.TLA',
		'Currency.Name',
		'Price'
	);

	public static $default_sort = 'Created DESC';

	public function InvertedPrice() {
		return 1/$this->PriceUSD;
	}

}
