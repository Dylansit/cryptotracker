<?php


class CurrencyController extends Page_Controller {

	private static $allowed_actions = array (
		'view'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
		
	}

	public function view() {
		$currencyTLA = $this->request->Param('ID');
		if ($currencyTLA || $currencyTLA != '') {
			$currency = CurrencyType::get()->find('TLA', $currencyTLA);
			if($currency) {

				$days = $this->request->getVar('days');
				if(!$days || $days > 30 || $days < 0) {
					$days = 30;
				}
				
				$allPrices = $currency->GetPricesSince($days);

				return $this->customise(new ArrayData(array(
					'Title' => $currency->Title.' ('.$currency->TLA.')',
					'Content' => '',
					'Prices' => $allPrices
				)))->renderWith(array('CurrencyPage', 'Page'));
			}
		}
		$this->httpError(404);
	}

	public function Link($action = NULL) {
		return 'currency/view/'. $this->request->Param('ID');
	}

}
