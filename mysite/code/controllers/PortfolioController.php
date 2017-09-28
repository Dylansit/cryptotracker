<?php


class PortfolioController extends Page_Controller {

	private static $allowed_actions = array (
		'view'
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

	public function view() {
		$hash = $this->request->Param('ID');

		$member =	Member::Get()->find('ProfileHash', $hash);
		CurrencyTrade::$ViewMember = $member;

		if(!$member) {
			return "Member does not exist";
		}

		if (!$member->MakeMyPortfolioPublic) {
			return "Member profile not public";
		}

		
		return $this->customise(array(
			'ViewMember' => $member)
		)->renderWith(array('PortfolioViewPage', 'Page'));
	}
}
