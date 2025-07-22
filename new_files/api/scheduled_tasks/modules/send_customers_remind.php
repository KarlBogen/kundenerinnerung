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

function cron_send_customers_remind()
{

  if (defined('MODULE_CUSTOMERS_REMIND_STATUS') && MODULE_CUSTOMERS_REMIND_STATUS == 'true' &&
      defined('MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP') && MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP != 'true'
      )
 {
    // include needed functions
    require_once (DIR_FS_INC.'xtc_date_short.inc.php');

    include_once(DIR_WS_INCLUDES . 'modules/customers_remind.php');
    sendremindmails();
  }
  return true;
}
