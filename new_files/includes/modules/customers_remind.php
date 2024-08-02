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

$sendmail_asap = defined('MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP') ? MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP : 'false'; // true - wenn bei jedem Seitenaufruf die Tabelle "Kundenerinnerung" mit dem "Lagerbestand" abgeglichen werden soll

if ($sendmail_asap === 'false') {
	// Thanks to noRiddle - simulated cron job (code from https://trac.modified-shop.org/ticket/2252)
	$last_exec = NULL;
	$mas_act = false;

	$mas_last_exec_qu_str = "SELECT last_executed FROM ".TABLE_SIMULATED_CRON_RECORDS." WHERE application = 'customers_remind' AND last_executed IS NOT NULL";
	$mas_last_exec_qu = xtc_db_query($mas_last_exec_qu_str);
	if(xtc_db_num_rows($mas_last_exec_qu) == 1) {
		$mas_last_exec_arr = xtc_db_fetch_array($mas_last_exec_qu);
		$last_exec = $mas_last_exec_arr['last_executed'];

		//do it only once a day
		if(strtotime($last_exec) < strtotime(date('Y-m-d', time())))
			$mas_act = true;
	} else {
		if ($_SESSION['customers_status']['customers_status_id'] == 0) {
			echo '<div class="errormessage shopsystem">Check Table <strong>' . TABLE_SIMULATED_CRON_RECORDS . '</strong>: There is no result "last_executed" for application "customers_remind"!</div>';
		}
	}

	if(xtc_check_agent() == 0 && !file_exists(DIR_WS_MODULES.'.sendremindmails_running')) { //process already running ?
	  if(is_null($last_exec) || (isset($mas_act) && $mas_act === true)) {
	    touch(DIR_WS_MODULES.'.sendremindmails_running'); //generate file as indicator that process is running

	    //update set database record
	    $remind_upd_qu_str = "INSERT INTO ".TABLE_SIMULATED_CRON_RECORDS." (application, last_executed) VALUES('customers_remind', NOW()) ON DUPLICATE KEY UPDATE last_executed = VALUES(last_executed)";
	    if(xtc_db_query($remind_upd_qu_str) && sendremindmails()) {
	      unlink(DIR_WS_MODULES.'.sendremindmails_running'); //delete indicator
	    }
	  }
	}
} else {
  sendremindmails();
}

function sendremindmails() {

	$strstockQuery = "SELECT cr.*,
	                        p.products_quantity,
	                        p.products_model,
	                        p.products_image
	                  FROM customers_remind cr
	                  JOIN ".TABLE_CUSTOMERS_REMIND_RECIPIENTS." crr
	                        ON crr.mail_status = '1'
	                        AND crr.customers_email_address = cr.customers_email_address
	                  JOIN ".TABLE_PRODUCTS." p
	                        ON p.products_id = cr.products_id
	                        AND p.products_quantity >= cr.customers_st";

	$resstockQuery = xtc_db_query($strstockQuery);

	if(xtc_db_num_rows($resstockQuery) > 0) {
		$objSmarty= new Smarty();
		$objSmarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
		$objSmarty->assign('logo_path',HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$objSmarty->assign('STORE_NAME',STORE_NAME);
		$objSmarty->caching = false;

		while($arrstock = xtc_db_fetch_array($resstockQuery)) {
			$objSmarty->assign('PRODUCTS_NAME', $arrstock['products_name']);
			$objSmarty->assign('PRODUCTS_MODEL', $arrstock['products_model']);
			$objSmarty->assign('CUSTOMERS_GENDER', $arrstock['customers_gender']);
			$objSmarty->assign('CUSTOMERS_FIRSTNAME', $arrstock['customers_firstname']);
			$objSmarty->assign('CUSTOMERS_LASTNAME', $arrstock['customers_lastname']);
			$objSmarty->assign('MAIL_HEAD1', $arrstock['mail_head1']);
			$objSmarty->assign('CUSTOMERS_LANGUAGE', $arrstock['customers_language']);
			$objSmarty->assign('CUSTOMERS_PRODUCTS_IMAGE', $arrstock['products_image']);

			$link = HTTP_SERVER.DIR_WS_CATALOG.FILENAME_PRODUCT_INFO."?products_id=".$arrstock['products_id'];
			$objSmarty->assign('LINK', $link);
			$objSmarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
			$objSmarty->assign('img_path', HTTP_SERVER.DIR_WS_CATALOG.DIR_WS_THUMBNAIL_IMAGES.$arrstock['products_image']);

			$html_mail = $objSmarty->fetch(CURRENT_TEMPLATE."/mail/".$arrstock['customers_language']."/remind_mail.html");
			$txt_mail = $objSmarty->fetch(CURRENT_TEMPLATE."/mail/".$arrstock['customers_language']."/remind_mail.txt");

			$strMarkQuery = "DELETE FROM
			                   customers_remind
			                 WHERE
			                   remind_id = ".(int)$arrstock['remind_id']."
			                 AND
			                   customers_id = ".(int)$arrstock['customers_id']."
			                 ";

			xtc_db_query($strMarkQuery);

			xtc_php_mail(
				EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, // from
				$arrstock['customers_email_address'], '', // to
				'', // bcc
				EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, // reply-to
				'', '', // attachments
				STORE_NAME . ' - ' . $arrstock['mail_head1'], // subject
				$html_mail, // HTML content
				$txt_mail // text-only content
			);
		}
	}
  return true;
}
