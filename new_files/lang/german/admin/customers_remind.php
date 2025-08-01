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

define('HEADING_TITLE', 'Kundenerinnerungen bei erneutem Eintreffen von Artikeln');

define('TABLE_HEADING_CUSTOMER', 'Kunde');
define('TABLE_HEADING_CUSTOMER_MAIL', 'E-Mail');
define('TABLE_HEADING_PRODUCT', 'Produktname');
define('TABLE_HEADING_DATE_ADDED', 'Hinzugef&uuml;gt am');
define('TABLE_HEADING_PRODUCT_MODEL' , 'EAN.Nr.');
define('TABLE_HEADING_REMOVE_REMINDER' , 'Entfernen');
define('TABLE_HEADING_PRODUCT_BILD' , 'Bild');
define('TABLE_HEADING_PRODUCT_MINSTOCK' , 'Prozentualer<br>Mindestlagerbestand');
define('TABLE_HEADING_PRODUCT_ST' , 'St&uuml;ck');
define('TABLE_HEADING_PRODUCT_DAT' , 'Art.Nr. Bearbeiten');
define('TABLE_HEADING_PRODUCT_CUPO' , 'E-Mail / Gutschein / Rabatt senden');
define('TABLE_HEADING_DEL', 'Eintrag l&ouml;schen?');
define('KD_REG', 'registrierter Kunde [Kundennummer]<br>E-Mail<span class="colorRed"> (n.a. = nicht aktiviert)</span>');
define('FOOTER_INFO', 'Kunden, die sich f&uuml;r eine Produkterinnerung eingetragen haben<br>bekommen eine automatische E-Mail-Benachrichtigung,<br>sobald der gew&uuml;nschte Artikel wieder auf Lager ist.');

define('CUSTOMERS_ADVERTISING_DELETE_CONFIRM', 'Sind Sie sicher, dass Sie diese Kundenwerbung unwiderruflich l&ouml;schen wollen?');

define('LINK_SEND_REMIND', 'Erinnerungsmail senden');
define('BUTTON_SEND_RABATT', 'Rabatt senden');

defined('TEXT_SORT_ASC') or define('TEXT_SORT_ASC','aufsteigend');
defined('TEXT_SORT_DESC') or define('TEXT_SORT_DESC','absteigend');
defined('TEXT_IMAGE_NONEXISTENT') or define('TEXT_IMAGE_NONEXISTENT', 'Kein Bild');
