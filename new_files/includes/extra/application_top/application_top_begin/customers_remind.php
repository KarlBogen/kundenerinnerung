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

if (defined('MODULE_CUSTOMERS_REMIND_STATUS') && MODULE_CUSTOMERS_REMIND_STATUS == 'true') {
// verhindert, dass die customers_remind.php nach dem Login als "letzte aufgerufen Seite" behandelt wird - Danke fiveBytes
	if (!isset($forbidden_history_sites) || !is_array($forbidden_history_sites)) {
		$forbidden_history_sites = array('customers_remind.php');
	} else {
		$forbidden_history_sites[] = 'customers_remind.php';
	}
}
