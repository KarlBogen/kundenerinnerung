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

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

if (defined('MODULE_CUSTOMERS_REMIND_STATUS') && MODULE_CUSTOMERS_REMIND_STATUS == 'true') {

	// Listenpunkt unter 'Kunden'
	$add_contents[BOX_HEADING_CUSTOMERS][BOX_CUSTOMERS_REMIND][] = array(
    	'admin_access_name' => 'customers_remind',   //Eintrag fuer Adminrechte
    	'filename' => '',	//Dateiname der neuen Admindatei
    	'boxname' => BOX_CUSTOMERS_REMIND,     	//Anzeigename im Menue
    	'parameters' => '',                 	//zusaetzliche Parameter z.B. 'set=export'
    	'ssl' => '',                         	//SSL oder NONSSL, kein Eintrag = NONSSL
	    'has_subs' => 1                     //wenn Menueeintrag Unterpunkte hat
  	);

	$add_contents[BOX_HEADING_CUSTOMERS][BOX_CUSTOMERS_REMIND][] = array(
    	'admin_access_name' => 'customers_remind',   //Eintrag fuer Adminrechte
    	'filename' => FILENAME_CUSTOMERS_REMIND,	//Dateiname der neuen Admindatei
    	'boxname' => BOX_CUSTOMERS_REMIND_SUB1,     	//Anzeigename im Menue
    	'parameters' => '',                 	//zusaetzliche Parameter z.B. 'set=export'
    	'ssl' => ''                         	//SSL oder NONSSL, kein Eintrag = NONSSL
  	);

	$add_contents[BOX_HEADING_CUSTOMERS][BOX_CUSTOMERS_REMIND][] = array(
    	'admin_access_name' => 'customers_remind',   //Eintrag fuer Adminrechte
    	'filename' => FILENAME_CUSTOMERS_REMIND_RECIPIENTS,	//Dateiname der neuen Admindatei
    	'boxname' => BOX_CUSTOMERS_REMIND_SUB2,     	//Anzeigename im Menue
    	'parameters' => '',                 	//zusaetzliche Parameter z.B. 'set=export'
    	'ssl' => ''                         	//SSL oder NONSSL, kein Eintrag = NONSSL
  	);
}