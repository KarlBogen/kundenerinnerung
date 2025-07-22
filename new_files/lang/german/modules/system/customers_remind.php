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

define('MODULE_CUSTOMERS_REMIND_TEXT_TITLE', 'Kundenerinnerung bei ausverkauften Artikeln');
define('MODULE_CUSTOMERS_REMIND_TEXT_DESCRIPTION', 'Dieses Modul bietet Ihren angemeldeten Kunden die M&ouml;glichkeit, sich eine Erinnerungs-E-Mail schicken zu lassen, sobald ein Artikel wieder auf Lager ist.<br /><br />Sobald ein Artikel nicht mehr auf Lager ist, erscheint auf der Produktdetail-Seite ein Button, womit der Kunde sich in die Erinnerungsliste eintragen kann.<br /><br />Ist ein Artikel (in ausreichender Anzahl) wieder auf Lager, bekommt der Kunde automatisch eine Erinnerungsmail mit einem Link, der direkt zum Produkt im Shop f&uuml;hrt.');
define('MODULE_CUSTOMERS_REMIND_STATUS_TITLE', 'Modul aktivieren?');
define('MODULE_CUSTOMERS_REMIND_STATUS_DESC', 'Kundenerinnerung aktivieren');
define('MODULE_CUSTOMERS_REMIND_DOUBLE_OPT_IN_TITLE','Double-Opt-In f&uuml;r Kundenerinnerung');
define('MODULE_CUSTOMERS_REMIND_DOUBLE_OPT_IN_DESC','Bei "Ja" wird eine E-Mail an den Kunden geschickt, in der die Anmeldung best&auml;tigt werden muss. Es muss hierf&uuml;r in den E-Mail Optionen das Senden von E-Mails aktiviert sein.');
define('MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED_TITLE', 'Erinnerung nur f&uuml;r angemeldete Kunden?');
define('MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED_DESC', 'Diesen Dienst nur f&uuml;r angemeldete Kunden erlauben, dann stellen Sie diesen Schalter auf "Ja".');
define('MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED_TITLE', 'Unterzeichnen des Datenschutzes auch f&uuml;r angemeldete Kunden?');
define('MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED_DESC', 'Soll die Datenschutz-Checkbox auch Pflichtangabe f&uuml;r angemeldete Kunden sein, dann stellen Sie diesen Schalter auf "Ja".<br>(Gilt nur wenn Erw. Konfiguration -> Zusatzmodule - Unterzeichnen des Datenschutzes = "Ja"!)');
define('MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP_TITLE', 'Mailversand sofort?');
define('MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP_DESC', 'Abgleich der Tabelle "Kundenerinnerung" mit dem "Lagerbestand" und anschlie&szlig;ender <strong>Mailversand gem&auml;&szlig; den Einstellungen im <a style="color: #e67e22; font-size: 12px; font-weight: bold;" href="'.((function_exists('xtc_href_link')) ? xtc_href_link(FILENAME_SCHEDULED_TASKS) : '#').'">Hilfsprogramme -> Geplante Aufgaben</a> -> Aufgabe: "Kundenerinnerung bei ausverkauften Artikeln"</strong>, dann Schalter auf "Nein" (empfohlene Einstellung).<br>Wenn bei jedem Seitenaufruf die Tabelle "Kundenerinnerung" mit dem "Lagerbestand" abgeglichen werden soll, dann stellen Sie diesen Schalter auf "Ja".');
define('MODULE_CUSTOMERS_REMIND_SENDMAIL_MINSTOCK_STATUS_TITLE', 'Benachrichtigung ab prozentualem Mindestlagerbestand.');
define('MODULE_CUSTOMERS_REMIND_SENDMAIL_MINSTOCK_STATUS_DESC', 'Soll die Benachrichtigung ab prozentualem Mindestlagerbestand aktivieren werden?');
define('MODULE_CUSTOMERS_REMIND_SENDMAIL_MINSTOCK_TITLE', 'Benachrichtigung ab prozentualem Mindestlagerbestand <span style="font-weight:normal;">(Angabe in Prozent)</span>.');
define('MODULE_CUSTOMERS_REMIND_SENDMAIL_MINSTOCK_DESC', 'Hier k&ouml;nnen Sie einstellen, ab welchem Verh&auml;ltnis vom Lagerbestand zu Verf&uuml;gbarkeitsanfragen, eine Benachrichtigung verschickt werden soll.<br>
    Gespeicherte Prozentangabe soll in folgenden Beispielen <strong>80%</strong> sein.<br>
    - In der Erinnerungsliste stehen 3 Kunden mit jeweils 1 St&uuml;ck - Mailversand (3 x 80% = 2,4 => abgerundet 2) bei Lagerbestand 2 St&uuml;ck.<br>
    - In der Erinnerungsliste steht nur 1 Kunden mit 3 St&uuml;ck - Mailversand (3 x 80% = 2,4) ab Lagerbestand 3 St&uuml;ck, weil nur 1 Kunde eingetragen ist.<br>
    - In der Erinnerungsliste stehen 4 Kunden mit jeweils 50 St&uuml;ck - Mailversand (200 x 80% = 160) ab Lagerbestand 160 St&uuml;ck.');
define('MODULE_CUSTOMERS_REMIND_BUTTON_IMAGE_TITLE', 'Welches Bild soll als Button verwendet werden?');
define('MODULE_CUSTOMERS_REMIND_BUTTON_IMAGE_DESC', 'Mit "remind.gif" kann, in Verbindung mit der Templatedatei "/source/inc/css_button.inc.php", ein eigener CSS-Button gestaltet werden.');
define('MODULE_CUSTOMERS_REMIND_BUTTON_TEXT_TITLE', 'Individueller Button-Text');
define('MODULE_CUSTOMERS_REMIND_BUTTON_TEXT_DESC', 'Hier kann ein individueller Button-Text festgelegt werden, wenn das Feld leer bleibt wird ein Standardtext verwendet.');
define('MODULE_CUSTOMERS_REMIND_SHOW_ADDTOCART_TITLE', 'Soll zum Erinnerungs-Button auch der Warenkorb-Button angezeigt werden?');
define('MODULE_CUSTOMERS_REMIND_SHOW_ADDTOCART_DESC', '<br><div style="display:flex"><div style="width:15%"><strong>nein = Nein</strong></div><div style="width:85%"><u>Tipp:</u> Im Template "tpl_modified_nova" sollte, falls das Systemmodul "Merkzettel" installiert ist, diese CSS-Anweisung hinzugef&uuml;gt werden:<br><strong>.pd_addtobasket_row {align-items: end !important;}</strong></div></div><br><div style="display:flex"><div style="width:15%"><strong>oben = top</strong></div><div style="width:85%"><u>Tipp:</u> Im Template "tpl_modified_nova" sollte diese CSS-Anweisung hinzugef&uuml;gt werden:<br><strong>.pd_addtobasket_row {align-items: start !important;}</strong></div></div><br><div style="display:flex"><div style="width:15%"><strong>unten = bottom</strong></div><div style="width:85%"><u>Tipp:</u> Im Template "tpl_modified_nova" sollte diese CSS-Anweisung hinzugef&uuml;gt werden:<br><strong>.pd_addtobasket_row {align-items: end !important;}</strong></div></div>');
define('MODULE_CUSTOMERS_REMIND_VERSION_ERROR', '<div class="error_message div_header">Die Modulversion ist nicht mehr aktuell!<br /><br />Klicken Sie auf den grünen Button "Update"!<br /></div>');
define('MODULE_CUSTOMERS_REMIND_DELETE_CONFIRM', 'Sollen alle Moduldateien wirklich l&ouml;scht werden?<br /><br />Es werden alle Datenbankeintr&auml;ge und alle zugeh&ouml;rigen Dateien entfernt!<br />');
define('MODULE_CUSTOMERS_REMIND_DELETE_BUTTON', 'Moduldateien l&ouml;schen');
define('MODULE_CUSTOMERS_REMIND_DELETE_ERR', ' konnte nicht vom Programm gel&ouml;scht werden, oder existiert nicht!');
