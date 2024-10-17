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

class customers_remind {

    public $code;
    public $title;
    public $description;
    public $enabled;
    public $sort_order;
    public $_check;
    public $keys;

	public function __construct() {
		$this->code = 'customers_remind';
		$this->title = MODULE_CUSTOMERS_REMIND_TEXT_TITLE . ' © by <a href="https://github.com/KarlBogen" target="_blank" style="color: #e67e22; font-weight: bold;">Karl</a> - Version: 1.0.4';
		$this->description = '';
		if (defined('MODULE_CUSTOMERS_REMIND_STATUS')) {
			$this->description .= '<a class="button btnbox but_green" style="text-align:center;" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=update') . '">Update</a><br /><br />';
		}
		$this->description .= '<a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\''. MODULE_CUSTOMERS_REMIND_DELETE_CONFIRM .'\', \'\' ,this);" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=custom') . '">' . MODULE_CUSTOMERS_REMIND_DELETE_BUTTON . '</a><br />';
		$this->description .= MODULE_CUSTOMERS_REMIND_TEXT_DESCRIPTION;
		$this->sort_order = defined('MODULE_CUSTOMERS_REMIND_SORT_ORDER') ? MODULE_CUSTOMERS_REMIND_SORT_ORDER : 0;
		$this->enabled = ((defined('MODULE_CUSTOMERS_REMIND_STATUS') && MODULE_CUSTOMERS_REMIND_STATUS == 'true') ? true : false);
	}

	public function process($file) {
	}

	public function display() {
		return array('text' => '<br /><div align="center">' . xtc_button(BUTTON_SAVE) .
			xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=customers_remind')) . "</div>");
	}

	public function check() {
    if (!isset($this->_check)) {
      if (defined('MODULE_CUSTOMERS_REMIND_STATUS')) {
        $this->_check = true;
      } else {
        $check_query = xtc_db_query("SELECT configuration_value
                                       FROM " . TABLE_CONFIGURATION . "
                                      WHERE configuration_key = 'MODULE_CUSTOMERS_REMIND_STATUS'");
        $this->_check = xtc_db_num_rows($check_query);
      }
    }
    return $this->_check;
	}
    
	public function install() {
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_STATUS', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_DOUBLE_OPT_IN', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED', 'false',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP', 'false',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_BUTTON_IMAGE', 'button_continue.gif',  '6', '1', 'xtc_cfg_select_option(array(\'button_continue.gif\', \'remind.gif\'), ', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_BUTTON_TEXT', '',  '6', '1', 'xtc_cfg_input_email_language;MODULE_CUSTOMERS_REMIND_BUTTON_TEXT', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_CUSTOMERS_REMIND_SHOW_ADDTOCART', 'no',  '6', '1', 'xtc_cfg_select_option(array(\'no\', \'top\', \'bottom\'), ', now())");

		xtc_db_query("CREATE TABLE IF NOT EXISTS `customers_remind` (
			`remind_id` int(11) NOT NULL AUTO_INCREMENT,
			`customers_id` int(11) NOT NULL DEFAULT 0,
			`customers_gender` char(1) NOT NULL,
			`customers_firstname` varchar(64) NOT NULL,
			`customers_lastname` varchar(64) NOT NULL,
			`customers_email_address` varchar(255) NOT NULL,
			`customers_language` varchar(32) DEFAULT NULL,
			`customers_st` varchar(4) NOT NULL DEFAULT '1',
			`products_id` int(11) NOT NULL,
			`products_ean` varchar(128),
			`products_name` varchar(255) NOT NULL,
			`products_model` varchar(64),
			`products_image` varchar(255) DEFAULT NULL,
			`mail_head1` varchar(128) NOT NULL,
			`remind_date_added` datetime DEFAULT NULL,
			PRIMARY KEY (`remind_id`)
		)");

		xtc_db_query("CREATE TABLE IF NOT EXISTS `customers_remind_recipients` (
		  mail_id int(11) NOT NULL AUTO_INCREMENT,
		  customers_email_address varchar(255) NOT NULL DEFAULT '',
		  customers_id int(11) NOT NULL DEFAULT 0,
		  customers_status int(5) NOT NULL DEFAULT 0,
		  customers_firstname varchar(64) NOT NULL DEFAULT '',
		  customers_lastname varchar(64) NOT NULL DEFAULT '',
		  mail_status int(1) NOT NULL DEFAULT 0,
		  mail_key varchar(32) NOT NULL DEFAULT '',
		  date_added datetime DEFAULT NULL,
		  ip_date_added varchar(50) DEFAULT NULL,
		  date_confirmed datetime DEFAULT NULL,
		  ip_date_confirmed varchar(50) DEFAULT NULL,
		  PRIMARY KEY (mail_id)
		)");

		xtc_db_query("CREATE TABLE IF NOT EXISTS `customers_remind_recipients_history` (
		  history_id int(11) NOT NULL AUTO_INCREMENT,
		  customers_email_address varchar(255) NOT NULL,
		  customers_action varchar(32) NOT NULL,
		  ip_address varchar(50) DEFAULT NULL,
		  date_added datetime DEFAULT NULL,
		  PRIMARY KEY (history_id)
		)");

		// Thanks to noRiddle - simulated cron job (code from https://trac.modified-shop.org/ticket/2252, see also https://www.modified-shop.org/forum/index.php?topic=12813.msg390607#msg390607)
		xtc_db_query("CREATE TABLE IF NOT EXISTS " . TABLE_SIMULATED_CRON_RECORDS . " (
			`application` varchar(64) NOT NULL,
			`last_executed` DATE DEFAULT NULL,
			PRIMARY KEY (`application`)
		)");
		xtc_db_query("INSERT INTO " . TABLE_SIMULATED_CRON_RECORDS . " (application, last_executed) VALUES ('customers_remind', now())");

		// Einträge in admin_access
		$admin_access_customers_remind_exists = xtc_db_num_rows(xtc_db_query("SHOW COLUMNS FROM ".TABLE_ADMIN_ACCESS." WHERE Field='customers_remind'"));
		if(!$admin_access_customers_remind_exists) {
			xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." ADD `customers_remind` INT(1) NOT NULL DEFAULT 0");
		}
		xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET customers_remind = '9' WHERE customers_id = 'groups' LIMIT 1");
		xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET customers_remind = '1' WHERE customers_id = '1' LIMIT 1");
		if ($_SESSION['customer_id'] > 1) {
			xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET customers_remind = '1' WHERE customers_id = '".$_SESSION['customer_id']."' LIMIT 1") ;
		}
		$admin_access_customers_remind_exists = xtc_db_num_rows(xtc_db_query("SHOW COLUMNS FROM ".TABLE_ADMIN_ACCESS." WHERE Field='customers_remind_recipients'"));
		if(!$admin_access_customers_remind_exists) {
			xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." ADD `customers_remind_recipients` INT(1) NOT NULL DEFAULT 0");
		}
		xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET customers_remind_recipients = '9' WHERE customers_id = 'groups' LIMIT 1");
		xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET customers_remind_recipients = '1' WHERE customers_id = '1' LIMIT 1");
		if ($_SESSION['customer_id'] > 1) {
			xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET customers_remind_recipients = '1' WHERE customers_id = '".$_SESSION['customer_id']."' LIMIT 1") ;
		}

		// Klassenerweiterungsmodul wird mitinstalliert
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCT_CUSTOMERS_REMIND_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PRODUCT_CUSTOMERS_REMIND_SORT_ORDER', '10','6', '2', now())");
		$this->check_module_product_installed();

		$file_to_remove = DIR_FS_CATALOG.'includes/extra/modules/product_info_end/customers_remind.php';
		if (file_exists($file_to_remove)) unlink($file_to_remove);

	}

	public function update() {
		if (!defined('MODULE_CUSTOMERS_REMIND_DOUBLE_OPT_IN')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_CUSTOMERS_REMIND_DOUBLE_OPT_IN', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP', 'false','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
	}

	public function remove() {
		xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
		xtc_db_query("DROP TABLE IF EXISTS `customers_remind`");
		if ($this->table_exists(TABLE_SIMULATED_CRON_RECORDS) === true)	{
  		$check_query = xtc_db_query("SELECT application FROM ".TABLE_SIMULATED_CRON_RECORDS);
  		if (xtc_db_num_rows($check_query) > 1) {
  			xtc_db_query("DELETE FROM " . TABLE_SIMULATED_CRON_RECORDS . " WHERE application = 'customers_remind'");
  		} else {
  			xtc_db_query("DROP TABLE " . TABLE_SIMULATED_CRON_RECORDS);
  		}
    }
		$query = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ADMIN_ACCESS . " LIKE 'customers_remind'");
		$exist = xtc_db_num_rows($query);
		if ($exist > 0) {
		  xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." DROP `customers_remind`");
		}
		$query = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ADMIN_ACCESS . " LIKE 'customers_remind_recipients'");
		$exist = xtc_db_num_rows($query);
		if ($exist > 0) {
		  xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." DROP `customers_remind_recipients`");
		}

		// Klassenerweiterungsmodul wird zeitgleich deinstalliert
		xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key LIKE 'MODULE_PRODUCT_CUSTOMERS_REMIND_%'");
		if (defined('MODULE_PRODUCT_INSTALLED')) {
			$installed = [];
			if (MODULE_PRODUCT_INSTALLED != '') $installed = explode(';', MODULE_PRODUCT_INSTALLED);
			if (($key = array_search('customers_remind.php', $installed)) !== false) {
				unset($installed[$key]);
				xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value = '" . implode(';', $installed) . "', last_modified = now() where configuration_key = 'MODULE_PRODUCT_INSTALLED'");
			}
		}
	}

	public function custom() {
		global $messageStack;

		// Systemmodule deinstallieren
		$this->remove();

		// Dateien definieren
		$shop_path = DIR_FS_CATALOG;
		$dirs_and_files = array();
		// admin
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/filenames/customers_remind.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/menu/customers_remind.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'customers_remind.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'customers_remind_recipients.php';
		// includes
		$dirs_and_files[] = $shop_path.'includes/classes/class.customers_remind.php';
		$dirs_and_files[] = $shop_path.'includes/extra/application_top/application_top_begin/customers_remind.php';
		$dirs_and_files[] = $shop_path.'includes/extra/application_top/application_top_end/70_customers_remind.php';
		$dirs_and_files[] = $shop_path.'includes/extra/database_tables/customers_remind.php';
		$dirs_and_files[] = $shop_path.'includes/extra/filenames/customers_remind.php';
		$dirs_and_files[] = $shop_path.'includes/extra/modules/product_info_end/zzz_customers_remind.php';
		$dirs_and_files[] = $shop_path.'includes/modules/product/customers_remind.php';
		$dirs_and_files[] = $shop_path.'includes/modules/customers_remind.php';
		// lang
		$dirs_and_files[] = $shop_path.'lang/english/admin/customers_remind.php';
		$dirs_and_files[] = $shop_path.'lang/english/admin/customers_remind_recipients.php';
		$dirs_and_files[] = $shop_path.'lang/english/extra/admin/customers_remind.php';
		$dirs_and_files[] = $shop_path.'lang/english/extra/customers_remind.conf';
		$dirs_and_files[] = $shop_path.'lang/english/extra/customers_remind.php';
		$dirs_and_files[] = $shop_path.'lang/english/modules/system/customers_remind.php';
		$dirs_and_files[] = $shop_path.'lang/german/admin/customers_remind.php';
		$dirs_and_files[] = $shop_path.'lang/german/admin/customers_remind_recipients.php';
		$dirs_and_files[] = $shop_path.'lang/german/extra/admin/customers_remind.php';
		$dirs_and_files[] = $shop_path.'lang/german/extra/customers_remind.conf';
		$dirs_and_files[] = $shop_path.'lang/german/extra/customers_remind.php';
		$dirs_and_files[] = $shop_path.'lang/german/modules/system/customers_remind.php';
		// template tpl_modified_nova
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/buttons/english/remind.gif';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/buttons/german/remind.gif';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/english/remind_activate_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/english/remind_activate_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/english/remind_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/english/remind_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/german/remind_activate_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/german/remind_activate_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/german/remind_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/mail/german/remind_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/module/reminder_activate.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/module/reminder.html';
		// template tpl_modified_responsive
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/buttons/english/remind.gif';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/buttons/german/remind.gif';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/english/remind_activate_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/english/remind_activate_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/english/remind_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/english/remind_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/german/remind_activate_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/german/remind_activate_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/german/remind_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/mail/german/remind_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/module/reminder_activate.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/module/reminder.html';
		// template tpl_modified
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/buttons/english/remind.gif';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/buttons/german/remind.gif';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/english/remind_activate_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/english/remind_activate_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/english/remind_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/english/remind_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/german/remind_activate_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/german/remind_activate_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/german/remind_mail.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/mail/german/remind_mail.txt';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/module/reminder_activate.html';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/module/reminder.html';
		// root
		$dirs_and_files[] = $shop_path.'customers_remind.php';

		// Dateien löschen
		foreach ($dirs_and_files as $dir_or_file) {
			if(!$this->rrmdir($dir_or_file)){
				$messageStack->add_session($dir_or_file.MODULE_CUSTOMERS_REMIND_DELETE_ERR, 'error');
			}
		}
		// Datei selbst löschen
    unlink($shop_path.DIR_ADMIN.'includes/modules/system/customers_remind.php');
		$messageStack->add_session($this->title, 'success');
    xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system'));
	}

	public function keys() {
		if ($this->enabled == false && defined('MODULE_PRODUCT_CUSTOMERS_REMIND_STATUS') && MODULE_PRODUCT_CUSTOMERS_REMIND_STATUS == 'true')
	    	xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = 'false' WHERE configuration_key = 'MODULE_PRODUCT_CUSTOMERS_REMIND_STATUS'");
		if ($this->enabled == true && defined('MODULE_PRODUCT_CUSTOMERS_REMIND_STATUS') && MODULE_PRODUCT_CUSTOMERS_REMIND_STATUS == 'false')
	    	xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = 'true' WHERE configuration_key = 'MODULE_PRODUCT_CUSTOMERS_REMIND_STATUS'");

		$key = array(
			'MODULE_CUSTOMERS_REMIND_STATUS',
			'MODULE_CUSTOMERS_REMIND_DOUBLE_OPT_IN',
			'MODULE_CUSTOMERS_REMIND_ONLY_REGISTERED',
      'MODULE_CUSTOMERS_REMIND_PRIVACY_CHECK_REGISTERED',
			'MODULE_CUSTOMERS_REMIND_SENDMAIL_ASAP',
			'MODULE_CUSTOMERS_REMIND_BUTTON_IMAGE',
			'MODULE_CUSTOMERS_REMIND_BUTTON_TEXT',
			'MODULE_CUSTOMERS_REMIND_SHOW_ADDTOCART',
		);

		return $key;
	}

	protected function check_module_product_installed() {
		if (defined('MODULE_PRODUCT_INSTALLED')) {
			$installed = [];
			if (MODULE_PRODUCT_INSTALLED != '') $installed = explode(';', MODULE_PRODUCT_INSTALLED);
			if (!in_array('customers_remind.php', $installed)) {
				$installed[] =  'customers_remind.php';
				if (!xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value = '" . implode(';', $installed) . "', last_modified = now() WHERE configuration_key = 'MODULE_PRODUCT_INSTALLED'")) {
					return false;
				}
			}
		} else {
			if (!xtc_db_query("INSERT INTO ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PRODUCT_INSTALLED', 'customers_remind.php;', '6', '0', now())")) {
				return false;
			}
		}
		return true;
	}

	protected function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
			return true;
		} elseif(is_file($dir)) {
			unlink($dir);
			return true;
		}
	}

	protected function table_exists($table_name)
	{
	  $Table = xtc_db_query("show tables like '" . $table_name . "'");
	  if(xtc_db_num_rows($Table) < 1)
	  {
	    return(false);
	  } else {
	    return(true);
	  }
	}

}
