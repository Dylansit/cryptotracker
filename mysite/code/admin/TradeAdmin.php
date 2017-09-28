<?php

class TradeAdmin extends ModelAdmin {
  private static $managed_models = array('CurrencyTrade'); // Can manage multiple models
  private static $url_segment = 'trades'; // Linked as /admin/products/
  private static $menu_title = 'Trades';

}