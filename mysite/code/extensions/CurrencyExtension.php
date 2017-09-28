<?php


class CurrencyExtension extends Extension {
	public static $currency_symbol = false;

	
	public function getMyCurrencySymbol() {
  	if(self::$currency_symbol) return self::$currency_symbol; 
  	else {
			$symbol_array = Zend_Locale::getTranslationList('CurrencySymbol');
  		self::$currency_symbol = $symbol_array[Member::currentUser()->ShowPricesIn()->TLA];
  		return self::$currency_symbol;
  	}
		
	}


}