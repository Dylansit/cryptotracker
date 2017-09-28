<?php

class SiteConfigExtension extends DataExtension {

    private static $db = array(
        'ApiKey' => 'Varchar(128)'
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Main",
            new TextField("ApiKey")
        );
    }
}
