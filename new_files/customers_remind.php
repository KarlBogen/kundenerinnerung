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

  * edited and tried to improve efficiency and logic, 06-2022, noRiddle *
-------------------------------------------------------------- */

include ('includes/application_top.php');

if(defined('MODULE_CUSTOMERS_REMIND_STATUS') && MODULE_CUSTOMERS_REMIND_STATUS == 'true') {

	// captcha
	$use_captcha = array('reminder');
	defined('DISPLAY_PRIVACY_CHECK') or define('DISPLAY_PRIVACY_CHECK', 'true');
	defined('MODULE_CAPTCHA_CODE_LENGTH') or define('MODULE_CAPTCHA_CODE_LENGTH', 6);
	defined('MODULE_CAPTCHA_LOGGED_IN') or define('MODULE_CAPTCHA_LOGGED_IN', 'True');

	// include needed functions
  require_once (DIR_FS_INC.'xtc_validate_email.inc.php');
	require_once (DIR_FS_INC.'secure_form.inc.php');

	// include needed classes
	require_once (DIR_WS_CLASSES.'class.customers_remind.php');
	require_once (DIR_WS_CLASSES.'modified_captcha.php');

  $smarty = new Smarty;

	$error_message = '';
	$reminder = new customersremind();


	// Accountaktivierung per Emaillink
	if (isset ($_GET['action']) && ($_GET['action'] == 'activate')) {
	  $reminder->ActivateAddress($_GET['key'], $_GET['email']);
	  unset($_GET['email']);
	  $error_message = $reminder->message;
	  if ($reminder->message_class == 'info') {
	    $smarty->assign('activated', true);
	  }
		// build breadcrumb
		$breadcrumb->add(NAVBAR_TITLE_CUSTOMERS_REMIND, xtc_href_link(FILENAME_CUSTOMERS_REMIND, '', 'SSL'));

		// include header
		require (DIR_WS_INCLUDES . 'header.php');

		// include boxes
		$display_mode = 'reminder';
		require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
		$smarty->assign('error_message', $error_message);
		$smarty->assign('message_class', $reminder->message_class);
	  $smarty->assign('language', $_SESSION['language']);
	  $smarty->caching = 0;
		$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/reminder_activate.html');
		$smarty->assign('main_content', $main_content);
		if (!defined('RM'))
			$smarty->load_filter('output', 'note');
		$smarty->display(CURRENT_TEMPLATE.'/index.html');
		include ('includes/application_bottom.php');
	}
	else
	{
		// include header
		$smarty->assign('tpl_path', DIR_WS_BASE.'templates/'.CURRENT_TEMPLATE.'/');
		$smarty->assign('html_params', ((TEMPLATE_HTML_ENGINE == 'xhtml') ? ' '.HTML_PARAMS : ' lang="'.$_SESSION['language_code'].'"'));
		$smarty->assign('doctype', ((TEMPLATE_HTML_ENGINE == 'xhtml') ? ' PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"' : ''));
		$smarty->assign('charset', $_SESSION['language_charset']);
		if (DIR_WS_BASE == '') {
			$smarty->assign('base', (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG);
		}

		if (isset($_GET['coID'])) {
			// Content Datenschutz anzeigen
			$content_data = $main->getContentData(((isset($_GET['coID'])) ? (int)$_GET['coID'] : 0), '', '', (isset($_GET['preview']) ? true : false));
			if (count($content_data) > 0) {
				$smarty->assign('content_heading', $content_data['content_heading']);
				$smarty->assign('content_text', $content_data['content_text']);
				$smarty->assign('BUTTON_BACK', '<a href="javascript:history.back(1)">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
			}
		} else {

		$mod_captcha = $_mod_captcha_class::getInstance();
		$privacy = isset($_POST['privacy']) && $_POST['privacy'] == 'privacy' ? true : false;
		$error = false;

		if (isset($_GET['products_id'])) {
			require_once (DIR_FS_INC.'xtc_get_products_name.inc.php');
			$products_id = (int)$_GET['products_id'];
			$products_name = xtc_get_products_name($products_id);
			$smarty->assign('PRODUCTS_NAME', htmlentities($products_name));
		}

  	if(MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED == 'false' || (MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED == 'true' && isset($_SESSION['customer_id']))) {

			if (isset($_POST['action']) && $_POST['action'] == 'add_remind') {
				$email = xtc_db_prepare_input($_POST['customers_input_email']);
				// Postcheck
				if (!isset($_SESSION['customer_email_address']) || (isset($_SESSION['customer_email_address']) && MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED == 'true')) {
					if (DISPLAY_PRIVACY_CHECK == 'true' && empty($privacy)) {
						$error = true;
						$messageStack->add('customers_remind', ENTRY_PRIVACY_ERROR);
					}
				}
				if(strlen($email) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
					$error = true;
					$messageStack->add('customers_remind', ENTRY_EMAIL_ADDRESS_ERROR);
				}
				elseif(xtc_validate_email($email) == false) {
					$error = true;
					$messageStack->add('customers_remind', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
				}
				if (in_array('reminder', $use_captcha) && (!isset($_SESSION['customer_id']) || MODULE_CAPTCHA_LOGGED_IN == 'True')) {
					if ($mod_captcha->validate((isset($_POST['vvcode'])) ? $_POST['vvcode'] : '') !== true) {
						$error = true;
						$messageStack->add('customers_remind', TEXT_WRONG_CODE);
					}
				}
				if (check_secure_form($_POST) === false) {
					$error = true;
					$messageStack->add('customers_remind', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
				}
				$_POST['customers_input_st'] = intval($_POST['customers_input_st']);
				if($_POST['customers_input_st'] < 1) {
					$_POST['customers_input_st'] = 1;
				}
				// Fehlermeldung anzeigen
				if($messageStack->size('customers_remind') > 0) {
					$error_message = $messageStack->output('customers_remind');
					$message_class = 'error';
				}
			}


    	if(isset($_POST['action']) && $_POST['action'] == 'add_remind' && $error === false) {

	      $reminder->auto = true; //Captchaprüfung in PHP Klasse nicht mehr nötig
		    $reminder->AddUser('inp', '', $email);
		    $error_message = $reminder->message;
        $message_class = $reminder->message_class;

		    $reg_query = xtc_db_query("SELECT * FROM customers_remind WHERE customers_email_address = '".$email."' AND products_id = ".$products_id);
		    $registred = xtc_db_fetch_array($reg_query);

	      if(empty($registred)) {
	        $sql_data_array = array (
	          'customers_id' => (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : '0'),
	          'products_id' => $product->data['products_id'],
	          'products_ean' => $product->data['products_ean'],
	          'products_name' => $product->data['products_name'],
	          'products_model' => $product->data['products_model'],
	          'products_image' => $product->data['products_image'],
	          'customers_gender' => (isset($_SESSION['customer_gender']) ? $_SESSION['customer_gender'] : ''),
	          'customers_firstname' => xtc_db_prepare_input($_POST['customers_input_firstname']),
	          'customers_lastname' => xtc_db_prepare_input($_POST['customers_input_lastname']),
	          'customers_email_address' => xtc_db_prepare_input($_POST['customers_input_email']),
	          'customers_language' => xtc_db_prepare_input($_POST['language_input']),
	          'customers_st' => xtc_db_prepare_input($_POST['customers_input_st']),
	          'mail_head1' => xtc_db_prepare_input($_POST['mail_input_head1']),
	          'remind_date_added' => 'now()'
	        );

	        xtc_db_perform('customers_remind', $sql_data_array);
	        $smarty->assign('SUCCESS_MESSAGE', '2');
	      } else {
	        $smarty->assign('SUCCESS_MESSAGE', '1');
	      }

	    } else {

				if (in_array('reminder', $use_captcha) && (!isset($_SESSION['customer_id']) || MODULE_CAPTCHA_LOGGED_IN == 'True')) {
					$smarty->assign('VVIMG', $mod_captcha->get_image_code());
					$smarty->assign('INPUT_CODE', $mod_captcha->get_input_code());
				}

				$idStr = '<input type="hidden" name="products_id" value="'.$products_id.'"/><input type="hidden" name="action" value="add_remind"/>';

				$smarty->assign('FORM_ACTION_REMIND', xtc_draw_form('customers_remind', xtc_href_link(FILENAME_CUSTOMERS_REMIND, xtc_get_all_get_params(array('action')), 'SSL'), 'post', 'class="form-horizontal"').secure_form('customers_remind').$idStr);

				$firstname = isset($_POST['customers_input_firstname']) ? xtc_db_prepare_input($_POST['customers_input_firstname']) : (isset($_SESSION['customer_first_name']) ? $_SESSION['customer_first_name'] : '');
				$lastname = isset($_POST['customers_input_lastname']) ? xtc_db_prepare_input($_POST['customers_input_lastname']) : (isset($_SESSION['customer_last_name']) ? $_SESSION['customer_last_name'] : '');
				$mail = isset($_POST['customers_input_email']) ? xtc_db_prepare_input($_POST['customers_input_email']) : (isset($_SESSION['customer_email_address']) ? $_SESSION['customer_email_address'] : '');
				$st = isset($_POST['customers_input_st']) ? xtc_db_prepare_input($_POST['customers_input_st']) : 1;

				$smarty->assign('CUSTOMERS_FIRSTNAME_INPUT', xtc_draw_input_field('customers_input_firstname', $firstname, 'size="20"'));
				$smarty->assign('CUSTOMERS_LASTNAME_INPUT', xtc_draw_input_field('customers_input_lastname', $lastname, 'size="20"'));
				$smarty->assign('CUSTOMERS_MAIL_INPUT', xtc_draw_input_field('customers_input_email', $mail, 'size="20"'));
				$smarty->assign('CUSTOMERS_INPUT_ST', xtc_draw_input_field('customers_input_st', $st, 'size="20"'));

        $smarty->assign('FORM_END_REMIND', '</form>');
				if (DISPLAY_PRIVACY_CHECK == 'true') {
					if (!isset($_SESSION['customer_email_address']) || (isset($_SESSION['customer_email_address']) && MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED == 'true')) {
						$smarty->assign('PRIVACY_CHECKBOX', xtc_draw_checkbox_field('privacy', 'privacy', $privacy, 'id="privacy"'));
					}
				}
				$smarty->assign('PRIVACY_LINK', '<a target="_blank" href="'.xtc_href_link(FILENAME_CUSTOMERS_REMIND, 'coID=2').'" title="Information">'.MORE_INFO.'</a>');

	      $smarty->assign('SUCCESS_MESSAGE', '0');
	      $smarty->assign('BUTTON_SUBMIT_REMIND', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
    	}

			$smarty->assign('error_message', $error_message);
			if (!empty($message_class)) {
				$smarty->assign('message_class', $message_class);
			}

		}
}
		$smarty->assign('language', $_SESSION['language']);
		$smarty->caching = 0;
		$smarty->display(CURRENT_TEMPLATE.'/module/reminder.html');

	}
}
