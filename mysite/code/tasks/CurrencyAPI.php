<?php

class CurrencyAPI extends CliController {
    private static $allowed_actions = array(
        'index'
    );


    public function process() {

        $currencies = new RestfulService("https://www.worldcoinindex.com/apiservice/json?key=U2wL3a1dzKcJ98wkAGqB7X5Ay", 1 );
				$currencies->httpHeader("Accept:application/json");

        $request = $currencies->request();

        $json = $request->getBody();
        $priceArr = json_decode($json,true);

        print_r($priceArr,true);

        if (isset($_REQUEST['flush'])) {
	        foreach(CurrencyType::get() as $img) {
	        	if ($img->Logo()->ID) {
	        		$img->Logo()->delete();
	        	}
	        	$img->delete();
	        }
        }
        echo "Make folder: ".ASSETS_PATH.'/coins'."\r\n";
				FileSystem::makeFolder(ASSETS_PATH.'/coins');
        if($priceArr['success'] == 1){
        	foreach($priceArr['digital_currencies'] as $curItem) {
        		foreach($curItem as $cur => $name) {
	        		if(CurrencyType::get()->filter('TLA', $cur)->count() == 0) {
	        			$currency = CurrencyType::create();
	        			$currency->Name = $name;
	        			$currency->TLA = $cur;
	        			$currency->write();
	        		}
	        		if($currency = CurrencyType::get()->filter('TLA', $cur)->first()) {
	        			echo "got currency ".$cur."<br />\r\n";
	        			echo ASSETS_PATH.'/coins/'.$currency->Logo()->Filename."<br />\r\n";
	        			echo file_exists(ASSETS_PATH.'/coins/'.$currency->Logo()->Filename);
	        			if(!$currency->LogoID || !file_exists(ASSETS_PATH.'/coins/'.$currency->Logo()->Filename)){
	        				echo "getting logo ".$cur."\r\n";

		        			$logofile = file_get_contents("http://bravenewcoin.com/images/coins/".strtolower($currency->TLA).".png");
		        			file_put_contents (ASSETS_PATH.'/coins/'.$currency->TLA.'.png', $logofile);
	        			}
	        			if(!$currency->LogoID){
	        				$image = Image::create();
		        			$image->Title = $currency->TLA.'.png';
		        			$image->Filename = ASSETS_DIR.'/coins/'.$currency->TLA.'.png';
		        			$image->write();
	        				$currency->LogoID=$image->ID;
	        				$currency->write();
	        			}
	        		}
        		}
        	}
        }

        //update the site config with the latest values
        // $siteconfig = SiteConfig::current_site_config();
        // $siteconfig->last = $priceArr["last"];
        // $siteconfig->date = SS_DateTime::now()->Value;
        // $siteconfig->write();
    }


	// $response = Unirest\Request::get("https://bravenewcoin-v1.p.mashape.com/digital-currency-symbols",
	//   array(
	//     "X-Mashape-Key" => "BoIfg5wCgEmshOcopE9K5Y1pu2kzp1JVzvVjsny9JqDTPcPYNZ",
	//     "Accept" => "application/json"
	//   )
	// );




}
