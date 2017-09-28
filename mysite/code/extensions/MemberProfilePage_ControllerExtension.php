<?php

class MemberProfilePage_ControllerExtension extends Extension {


	public function updateProfileFields($fields) {

		$fields->removeByName('ShowPricesInID');
		$fields->push($currency = DropdownField::create('ShowPricesInID', 'Show Prices In',  CurrencyType::get()->filter('Crypto', 0)->sort('Name ASC')->map('ID', 'Name'), $this->owner->ShowCurrencyInID));
		$currency->setEmptyString('USD');
	}

}