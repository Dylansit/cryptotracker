<?php

class CurrencyTypeAdmin extends ModelAdmin {
  private static $managed_models = array('CurrencyType'); // Can manage multiple models
  private static $url_segment = 'currencies'; // Linked as /admin/products/
  private static $menu_title = 'Currencies';

}