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

define('MODULE_CUSTOMERS_REMIND_TEXT_TITLE', 'Customer reminder for sold out items');
define('MODULE_CUSTOMERS_REMIND_TEXT_DESCRIPTION', 'This module offers your logged customers the possibility to have a reminder e-mail sent as soon as an article (in sufficient number) is back in stock.');
define('MODULE_CUSTOMERS_REMIND_STATUS_TITLE', 'Activate Module?');
define('MODULE_CUSTOMERS_REMIND_STATUS_DESC', 'Activate Customers Remind');
define('MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED_TITLE', 'Reminder only for registered customers?');
define('MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED_DESC', 'If you only allow this service for registered customers, then set this switch to “Yes”.');
define('MODULE_CUSTOMERS_REMIND_BUTTON_IMAGE_TITLE', 'Which image should be used as a button?');
define('MODULE_CUSTOMERS_REMIND_BUTTON_IMAGE_DESC', 'With "remind.gif" you can design your own CSS-Button, have a look at the template file "/source/inc/css_button.inc.php".');
define('MODULE_CUSTOMERS_REMIND_BUTTON_TEXT_TITLE', 'Custom button text');
define('MODULE_CUSTOMERS_REMIND_BUTTON_TEXT_DESC', 'An individual button text can be specified here; if the field remains empty, a standard text is used.');
define('MODULE_CUSTOMERS_REMIND_SHOW_ADDTOCART_TITLE', 'Should the shopping cart button also be displayed?');
define('MODULE_CUSTOMERS_REMIND_SHOW_ADDTOCART_DESC', '<br><div style="display:flex"><div style="width:10%"><strong>No</strong></div><div style="width:90%"><u>Tip:</u>  In the template "tpl_modified_nova" this CSS style should be added, if the system module "Wishlist" is installed:<br><strong>.pd_addtobasket_row {align-items: end !important;}</strong></div></div><br><div style="display:flex"><div style="width:10%"><strong>top</strong></div><div style="width:90%"><u>Tip:</u> In the template "tpl_modified_nova" this CSS style should be added:<br><strong>.pd_addtobasket_row {align-items: start !important;}</strong></div></div><br><div style="display:flex"><div style="width:10%"><strong>bottom</strong></div><div style="width:90%"><u>Tip:</u>  In the template "tpl_modified_nova" this CSS style should be added:<br><strong>.pd_addtobasket_row {align-items: end !important;}</strong></div></div>');
define('MODULE_CUSTOMERS_REMIND_DELETE_CONFIRM', 'Should all module files really be deleted?<br /><br />This removes all database entries and all related files!<br />');
define('MODULE_CUSTOMERS_REMIND_DELETE_BUTTON', 'Delete module files');
define('MODULE_CUSTOMERS_REMIND_DELETE_ERR', ' could not be deleted by the program, or does not exist!');
