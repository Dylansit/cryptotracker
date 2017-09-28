<?php

class PriceFetcher extends CliController {

	private static $allowed_actions = array(
      'index'
  );


  public function process() {
		$apikey = Siteconfig::current_site_config()->ApiKey;
		date_default_timezone_set('Pacific/Auckland');
		$currencies = new RestfulService("https://www.worldcoinindex.com/apiservice/json?key=".$apikey, 1 );
		// $currencies->httpHeader("Accept:application/json");

    $request = $currencies->request();

    $json = $request->getBody();
		echo "https://www.worldcoinindex.com/apiservice/json?key=".$apikey;
		print_r($request);

		echo substr($json, 0, 100);
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
