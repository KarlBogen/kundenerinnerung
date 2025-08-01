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

define('HEADING_TITLE', 'Customer remind when articles arrive again');

define('TABLE_HEADING_CUSTOMER', 'Customer');
define('TABLE_HEADING_CUSTOMER_MAIL', 'Email');
define('TABLE_HEADING_PRODUCT', 'Products name');
define('TABLE_HEADING_DATE_ADDED', 'Date Added');
define('TABLE_HEADING_PRODUCT_MODEL' , 'EAN');
define('TABLE_HEADING_REMOVE_REMINDER' , 'Delete');
define('TABLE_HEADING_PRODUCT_BILD' , 'Image');
define('TABLE_HEADING_PRODUCT_MINSTOCK' , 'Percentage<br>minimum stock');
define('TABLE_HEADING_PRODUCT_ST' , 'Pieces');
define('TABLE_HEADING_PRODUCT_DAT' , 'Products Model Edit');
define('TABLE_HEADING_PRODUCT_CUPO' , 'E-Mail / Coupon / Discount');
define('TABLE_HEADING_DEL', 'Delete Entry?');
define('KD_REG', 'Registered Customer [Customer No.]<br>Email<span class="colorRed"> (n.a. = not activated)</span>');
define('FOOTER_INFO', 'Your customers get a reminder mail sent as soon as an article is sufficient back in stock.');

define('CUSTOMERS_ADVERTISING_DELETE_CONFIRM', 'Are you sure you want to permanently delete this advertiser?');

define('LINK_SEND_REMIND', 'Send remindmail');
define('BUTTON_SEND_RABATT', 'Send discount');

defined('TEXT_SORT_ASC') or define('TEXT_SORT_ASC','ascending');
defined('TEXT_SORT_DESC') or define('TEXT_SORT_DESC','descending');
defined('TEXT_IMAGE_NONEXISTENT') or define('TEXT_IMAGE_NONEXISTENT', 'Image does not exist');
