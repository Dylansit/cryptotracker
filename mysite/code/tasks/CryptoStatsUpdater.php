<?php

class CryptoStatsUpdater extends CliController {
    private static $allowed_actions = array(
        'index'
    );

    
    public function process() {

        $currencies = new RestfulService("https://api.coinmarketcap.com/v1/ticker/?convert=USD", 1 );
		// $currencies->httpHeader("X-Mashape-Key:BoIfg5wCgEmshOcopE9K5Y1pu2kzp1JVzvVjsny9JqDTPcPYNZ");
		// $currencies->httpHeader("Accept:application/json");
 
        $request = $currencies->request();

        $json = $request->getBody();
        $priceArr = json_decode($json,true);
        echo '<pre>';
        print_r($priceArr);

        // [id] => bitcoin
        // [name] => Bitcoin
        // [symbol] => BTC
        // [rank] => 1
        // [price_usd] => 2575.1
        // [price_btc] => 1.0
        // [24h_volume_usd] => 1249050000.0
        // [market_cap_usd] => 42162884830.0
        // [available_supply] => 16373300.0
        // [total_supply] => 16373300.0
        // [percent_change_1h] => -0.08
        // [percent_change_24h] => 2.08
        // [percent_change_7d] => 17.09
        // [last_updated] => 1496663953

        foreach($priceArr as $cur) {
        	$currency = CurrencyType::get()->find('TLA', $cur['symbol']);
        	if(!$currency) {
                $currencies = CurrencyType::get()->filter('AlternativeTLAs:PartialMatch', $cur['symbol']);
                $currency = $currencies->first();
            }

            if($currency) {
	        	$currency->AvailableSupply = $cur['available_supply'];
	        	$currency->TotalSupply = $cur['total_supply'];
	        	$currency->write();
        	}
        }

    }
}