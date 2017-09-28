<?php
class Page extends SiteTree {

	private static $db = array(
	);

	private static $has_one = array(
	);

}
class Page_Controller extends ContentController {

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
		'ImportForm'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
		
		Requirements::css($this->ThemeDir().'/css/font-awesome.min.css');
		Requirements::css($this->ThemeDir().'/css/bootstrap.min.css');
		Requirements::css($this->ThemeDir().'/css/typography.css');
		Requirements::css($this->ThemeDir().'/css/form.css');
		Requirements::css($this->ThemeDir().'/css/layout.css');
		
		Requirements::block(THIRDPARTY_DIR.'/jquery/jquery.js');
		Requirements::javascript($this->ThemeDir().'/js/jquery-2.2.4.min.js');
		Requirements::javascript('https://code.jquery.com/jquery-migrate-1.4.1.js');

		Requirements::javascript($this->ThemeDir().'/js/bootstrap.min.js');
		Requirements::javascript($this->ThemeDir().'/js/jquery.tablesorter.min.js');

		Requirements::customScript(<<<js

			

			$(document).ready(function() { 
				$.tablesorter.addParser({ 
			        // set a unique id 
			        id: 'dollars', 
			        is: function(s) { 
			            // return false so this parser is not auto detected 
			            return false; 
			        }, 
			        format: function(s) { 
			            // format your data for normalization 
			            // console.log(s);
			            return s.replace(",","").replace("$",""); 
			            // console.log("new:"+s);

			        }, 
			        // set type, either numeric or text 
			        type: 'numeric' 
			    }); 

		        $("#raw-data").tablesorter({ 
		            headers: { 
		            	2: { 
		                    sorter:'dollars' 
		                }, 
		                3: { 
		                    sorter:'dollars' 
		                }, 
		                4: { 
		                    sorter:'dollars' 
		                }, 
		                5: { 
		                    sorter:'dollars' 
		                },
		                6: { 
		                    sorter:'dollars' 
		                },
		                7: { 
		                    sorter:'dollars' 
		                }  
		            } 
		        }); 

		        $("#coin-value").tablesorter({ 
			        // sort on the first column and third column, order asc 
			        sortList: [[4,1]]
			    });
		    });
js
); 
		
	}

	public function LastPrice() {
		return CurrencyPrice::get()->sort('Created DESC')->first();
	}


	public function	GetPage($page = 'MemberProfilePage') {
		return $page::get()->first();
	}

	public function GetCurrency($code = 'BTC') {
		return CurrencyType::get()->find('TLA', $code);
	}

	public function GetAllCrypto() {
		return CurrencyType::get()->filter('Crypto', 1);
	}

	public function isLive() {
		return Director::isLive();
	}

	public function getUserCurrency() {
		return MemberExtension::getUserCurrency();
	}

	public function ImportForm() {

		$uploadField = UploadField::create('PoloniexImportFile');

		$uploadField->setCanAttachExisting(false); // Block access to SilverStripe assets library
        $uploadField->setCanPreviewFolder(false); // Don't show target filesystem folder on upload field
        $uploadField->relationAutoSetting = false; 
        $uploadField->setAllowedExtensions(array('csv'));
		$uploadField->setAllowedMaxFileNumber(1);
		$uploadField->setFolderName('Member_'.Member::currentUserID());
		$uploadField->setRightTitle('Upload your poloniex trade history, no larger than 1 MB');
	    $size = 1 * 1024 * 1024; // 1 MB in bytes
	    $uploadField->getValidator()->setAllowedMaxFileSize($size);

		$fields = FieldList::create(
			$uploadField
		);

		$actions = FieldList::create(
			FormAction::create('process', 'Process')
		);

		$form = Form::create($this, 'ImportForm', $fields, $actions);
		return $form;
	}

	public function process($data, $form) {

		// die(print_r($data,true));

		$filesArray = $data['PoloniexImportFile'];
		if(!isset($filesArray)) {
			die('no files');
		}
		if(!isset($filesArray['Files'])) {
			die('no files');
		}
		if(!isset($filesArray['Files'][0])) {
			die('no files');
		}

		$fileID = $filesArray['Files'][0];

		CsvExportController::ProcessPoloniexImport($fileID);

		// $this->redirectBack();
	}

}
