<?php

/* ------------------------------------------------------------
	Module "Kundenerinnerung Modified Shop 3.0.2 mit Opt-in" made by Karl

	Based on: Kundenerinnerung_Multilingual_advanced_modified-shop-1.06
	Based on: xt-module.de customers remind
	erste Anpassung von: Fishnet Services - Gemsjäger 30.03.2012
	Zusatzfunktionen eingefügt sowie Fehler beseitigt von Ralph_84
	Aufgearbeitet für die Modified 1.06 rev4356 von Ralph_84

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

class customers_remind {  //Important same name as filename

    //--- BEGIN DEFAULT CLASS METHODS ---//
    function __construct()
    {
        $this->code = 'customers_remind'; //Important same name as class name
        $this->title = 'Kundenerinnerung';
        $this->description = 'Kundenerinnerung';
        $this->name = 'MODULE_PRODUCT_'.strtoupper($this->code);
        $this->enabled = defined($this->name.'_STATUS') && constant($this->name.'_STATUS') == 'true' ? true : false;
        $this->sort_order = defined($this->name.'_SORT_ORDER') ? constant($this->name.'_SORT_ORDER') : '';

        $this->translate();
    }

    function translate() {
        switch ($_SESSION['language_code']) {
          case 'de':
            $this->description = '<strong>Dieses Modul geh&ouml;rt zum Systemmodul "Kundenerinnerung"</strong><br />Es wird automatisch konfiguriert mit dem Systemmodul.<br />Aufgabe: Entfernt den Warenkorb-Button in Produktlisten sobald der Bestand kleiner 1 ist.';
            break;
          default:
            $this->description = '<strong>This module is part of the systemmodule "Customers remind"</strong><br />It is automatically configured with the system module.<br />Function: Remove the add-to-cart button in productlisting views, if the quantity is lower than 1.';
            break;
        }
    }

    function check() {
        if (!isset($this->_check)) {
          $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = '".$this->name."_STATUS'");
          $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }

    function keys() {
//        define($this->name.'_STATUS_TITLE', TEXT_DEFAULT_STATUS_TITLE);
//        define($this->name.'_STATUS_DESC', TEXT_DEFAULT_STATUS_DESC);
        define($this->name.'_SORT_ORDER_TITLE', TEXT_DEFAULT_SORT_ORDER_TITLE);
        define($this->name.'_SORT_ORDER_DESC', TEXT_DEFAULT_SORT_ORDER_DESC);

        return array(
//            $this->name.'_STATUS',
            $this->name.'_SORT_ORDER'
        );
    }

    function install() {
    }

    function remove() {
    }


  /**
   * buildDataArray
   *
   * @param array $array
   * @return array
   */
  function buildDataArray($productData,$array,$image='thumbnail') {

	if (defined('MODULE_CUSTOMERS_REMIND_STATUS') && MODULE_CUSTOMERS_REMIND_STATUS == 'true') {

		if ($array["products_quantity"] < 1){

	        $productData['PRODUCTS_BUTTON_BUY_NOW'] = '';

		}
		return $productData;
	}

 }

}
