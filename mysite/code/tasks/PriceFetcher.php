<?php

class PriceFetcher extends CliController {

	private static $allowed_actions = array(
      'index'
  );


  public function process() {
		$apikey = Siteconfig::current_site_config()->ApiKey;
		if(!$apikey) {
			die('No API key set, get one from https://www.worldcoinindex.com/apiservice');
		}
		date_default_timezone_set('Pacific/Auckland');
		RestfulService::set_default_curl_option( CURLOPT_SSL_VERIFYHOST, false );
		RestfulService::set_default_curl_option( CURLOPT_SSL_VERIFYPEER, false );
		$currencies = new RestfulService("https://www.worldcoinindex.com/apiservice/json?key=".$apikey, 1 );
    $request = $currencies->request();
    $json = $request->getBody();
		$prices = json_decode($json,true);
    // print_r($prices);

		foreach($prices['Markets'] as $price) {
			$tla = substr($price['Label'], 0, strpos($price['Label'], '/'));
			$currencies = CurrencyType::get()->filter('TLA', $tla);
			$currency = null;
			if($currencies->count() == 0){
				$currency = CurrencyType::create();
				$currency->TLA = $tla;
				$currency->Name = $price['Name'];
				$currency->write();
				echo "************** New ".$price['Name'].' @ '.$price['Price_btc']."<br />\r\n";

			}
			else {
				$currency = $currencies->first();
			}
			$curprice = CurrencyPrice::create();
			$curprice->PriceBTC = $price['Price_btc'];
			$curprice->PriceUSD = $price['Price_usd'];
			$curprice->CurrencyID = $currency->ID;
			$curprice->write();
			echo "Updated ".$price['Name'].' @ '.$price['Price_btc']."<br />\r\n";

		}
	}
}
