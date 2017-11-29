<?php
class TradeCreaterPage extends Page {

	private static $db = array(
	);

	private static $has_one = array(
	);

}
class TradeCreaterPage_Controller extends Page_Controller {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
		'AddEditTradeForm',
		'edit',
		'delete',
		'getCurrentCurrencyPrice'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
	}


	public function MemberTrades() {
		if(Member::currentUser()){
			return CurrencyTrade::get()->filter('MemberID', Member::currentUserID());
		}
	}

	public function AddEditTradeForm() {
		Requirements::customScript(<<<js
			$(document).ready(function(){
				UpdatePrice();

				$('#CurrencyID select').change(function() {
					UpdatePrice();
				});

				$('#Cost input, #Amount input, #TotalCostBtc input, #TotalCostUsd input').keyup(function() {
						UpdateCostings($(this));
				});

				function UpdatePrice() {
					if(!$('#Amount input').val()) {
						$('#Amount input').val(1);
					}


					if(!$('input[name="ID"]').val()) {

						var currencyId = $('#CurrencyID select').val();
						$.ajax({
						  url: window.location+"/getCurrentCurrencyPrice/"+currencyId,
						  context: document.body
						}).done(function( data ) {
						  console.log(data);

						  $('#Cost input').val(data);

						  UpdateCostings($('#Cost input'));

						});

					}
				}

				function UpdateCostings(updated) {
					var amount = $('input[name="Amount"]').val();
					var btcconversion = $('input[name="BTCPrice"]').val();

					if (updated.attr('name') == 'Cost' || updated.attr('name') == 'Amount') {
						var cost = $('input[name="Cost"]').val();
						var totalcost = cost * btcconversion * amount;
						$('input[name="TotalCostBtc"]').val(totalcost);
						$('input[name="TotalCostUsd"]').val(totalcost*1/btcconversion);

					}
					else if (updated.attr('name') == 'TotalCostBtc') {
						 var totalBtc = $('input[name="TotalCostBtc"]').val();
						 var cost = totalBtc/amount / btcconversion;
						 $('input[name="Cost"]').val(cost);
						 $('input[name="TotalCostUsd"]').val(totalBtc * 1/btcconversion);
					}
					else if (updated.attr('name') == 'TotalCostUsd') {
						 var totalUsd = $('input[name="TotalCostUsd"]').val();
							var totalBtc = totalUsd * btcconversion;
						 $('input[name="TotalCostBtc"]').val(totalBtc);
						 $('input[name="Cost"]').val((totalBtc / amount)*1/btcconversion);
					}
				}
			});
js
);

		$fields = singleton('CurrencyTrade')->getFrontEndFields();
		$fields->removeByName('CurrencyID');
		$fields->removeByName('MemberID');

		$comp = CompositeField::create();
		$fields->insertAfter($comp, 'Cost');

		$totalUSD = TextField::create('TotalCostUsd', 'Total USD Cost of all coins');
		$totalBTC = TextField::create('TotalCostBtc', 'Total BTC Cost of all coins');
		$cost = $fields->dataFieldByName('Cost');
		$fields->removeByName('Cost');
		$cost->addExtraClass('col-sm-3');
		$totalUSD->addExtraClass('col-sm-3');
		$totalUSD->BeforeField = 'USD';
		$cost->BeforeField = 'USD';
		$totalBTC->BeforeField = 'BTC';
		$totalBTC->addExtraClass('col-sm-3');

		$comp->push($cost);
		$comp->push(LiteralField::create('or', '<div class="col-sm-1 or-divider">OR</div>'));
		$comp->push($totalBTC);
		$comp->push(LiteralField::create('or', '<div class="col-sm-1 or-divider">OR</div>'));
		$comp->push($totalUSD);
		$comp->addExtraClass('row');

		// debug::show($currency);
		// die(print_r(CurrencyType::get()->map('ID','Name'),true));
		$currencyField = DropdownField::create('CurrencyID', 'Currency', CurrencyType::get()->sort('Name ASC')->map('ID', 'NameAndTLA'), $this->CurrencyID);
		$fields->insertBefore('Amount', $currencyField);
		$fields->fieldByName('Amount')->setTitle('Number of Coins you bought');

		$cost->Title = 'The price of one coin in USD';

		$fields->fieldByName('Date')
			->setConfig('dateformat', 'dd-MM-yyyy')
			->setConfig('showcalendar', true);

		$fields->fieldByName('Date')->Title = 'Date that you bought this currency';
		$fields->fieldByName('Date')->setValue(date('Y-m-d'));
		$actions = new FieldList(
			new FormAction('submit', 'Save')
		);
		$fields->push(HiddenField::create('BTCPrice', '', CurrencyType::get()->find('TLA', 'BTC')->currentPrice()));

		$required = RequiredFields::create();

		return new Form($this, 'AddEditTradeForm', $fields, $actions, $required);

	}

	public function getCurrentCurrencyPrice() {
		$id = $this->Request->Param('ID');
		if(!$id) {
			return "No ID";
		}
		$curency = CurrencyType::get()->byId($id);
		if(!$curency) {
			return "No Currency";
		}
		return $curency->PricePerUnit();
	}

	public function Edit() {
		$id = $this->Request->Param('ID');
		$trade = CurrencyTrade::get()->byId($id);
		if(!$trade) {
			return $this->redirectBack();
		}
		if($trade->MemberID != Member::currentUserID()) {
			return $this->redirectBack();
		}

		$form = $this->AddEditTradeForm();
		$form->fields()->push(HiddenField::create('ID'));
		$form->fields()->setValues($trade->toMap());
		return $this->customise(array(
			'AddEditTradeForm' => $form
		));
	}

	public function delete() {
		die($id);
		$id = $this->Request->Param('ID');
		$trade = CurrencyTrade::get()->byId($id);
		if(!$trade) {
			return $this->redirectBack();
		}
		if($trade->MemberID != Member::currentUserID()) {
			return $this->redirectBack();
		}
		$trade->delete();
		return $this->redirectBack();

	}

	public function submit($data, $form){
		$id = $data['ID'];
		if($id) {
			$trade = CurrencyTrade::get()->byId($id);
			if(!$trade) {
				return $this->redirectBack();
			}
			if($trade->MemberID != Member::currentUserID()) {
				return $this->redirectBack();
			}
		}
		else {
			$trade = CurrencyTrade::create();
		}

		// if($data['Amount'] <= 0) {
    //     $form->addErrorMessage('Amount', 'This must be a number greater than 0', 'bad');
    //     return $this->redirectBack();
    // }
		// if($data['Cost'] <= 0) {
    //     $form->addErrorMessage('Cost', 'This must be a number greater than 0', 'bad');
    //     return $this->redirectBack();
    // }


		$trade->update($data);
		$trade->MemberID = Member::currentUserID();
		$trade->write();
		$this->redirect(PortfolioPage::get()->first()->Link());
	}
}
