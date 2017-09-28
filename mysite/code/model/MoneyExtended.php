<?php

class MoneyExtended extends Money {


	public function WholeNice($options = array()) {
		$amount = round($this->getAmount());
		if(!isset($options['display'])) $options['display'] = Zend_Currency::USE_SYMBOL;
		if(!isset($options['currency'])) $options['currency'] = $this->getCurrency();
		if(!isset($options['symbol'])) {
			$options['symbol'] = $this->currencyLib->getSymbol($this->getCurrency(), $this->getLocale());
		}
		return (is_numeric($amount)) ? $this->currencyLib->toCurrency($amount, $options) : '';
	}


}