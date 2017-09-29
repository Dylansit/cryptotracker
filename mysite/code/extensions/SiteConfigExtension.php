<?php

class SiteConfigExtension extends DataExtension {

    private static $db = array(
        'ApiKey' => 'Varchar(128)'
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main",
            TextField::create("ApiKey")->setRightTitle('Get an API key from https://www.worldcoinindex.com/apiservice')
        );
    }
}
