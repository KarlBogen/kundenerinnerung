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
	// prüft. ob Artikelnummer mit Zeichenkette für Mietartikel endet - wenn ja, dann Button hinzufügen

	if ($product->data['products_quantity'] < 1) {

		global $request_type;

		$remindtext = '';
		$remindlink = '';
		$class = '';

		if (!defined('POPUP_PRODUCT_LINK_PARAMETERS')) {
			define('POPUP_PRODUCT_LINK_PARAMETERS', '&KeepThis=true&TB_iframe=true&height=450&width=750');
		}
		if (!defined('POPUP_PRODUCT_LINK_CLASS')) {
			define('POPUP_PRODUCT_LINK_CLASS', 'thickbox');
		}

		$link_parameters = defined('TPL_POPUP_PRODUCT_LINK_PARAMETERS') ? TPL_POPUP_PRODUCT_LINK_PARAMETERS : POPUP_PRODUCT_LINK_PARAMETERS;
		$link_class = defined('TPL_POPUP_PRODUCT_LINK_CLASS') ? TPL_POPUP_PRODUCT_LINK_CLASS : POPUP_PRODUCT_LINK_CLASS;

		$remindlink .= '<p class="messageStackError color_error_message">' . CUSTOMERS_REMIND_NOTE . '</p>'."\n";
		$remindlink .= '<a target="_blank" href="'.xtc_href_link(FILENAME_CUSTOMERS_REMIND, 'products_id='.$product->data['products_id'].$link_parameters, $request_type).'" class="'.$link_class.' '.$class.'" title="'.CUSTOMERS_REMIND.'">'."\n";
		if (CURRENT_TEMPLATE != 'tpl_modified') {
			$remindlink .= xtc_image_button('button_continue.gif', CUSTOMERS_REMIND)."\n";
		} else {
			$remindlink .= xtc_image_button('remind.gif', CUSTOMERS_REMIND)."\n";
		}
		$remindlink .= '</a>'."\n";

			$products_qty = '<input type="hidden" value="1" name="products_qty">';

		$info_smarty->clear_assign('ADD_QTY');
		$info_smarty->clear_assign('ADD_CART_BUTTON');
		$info_smarty->clear_assign('ADD_CART_BUTTON_EXPRESS');
		$info_smarty->clear_assign('ADD_CART_BUTTON_PAYPAL');
		$info_smarty->clear_assign('PAYPAL_INSTALLMENT');
		$info_smarty->clear_assign('EASYCREDIT');

		$info_smarty->assign('ADD_QTY', $products_qty . ' ' . $add_pid_to_qty);
		$info_smarty->assign('ADD_CART_BUTTON', $remindlink);
	}
}
?>