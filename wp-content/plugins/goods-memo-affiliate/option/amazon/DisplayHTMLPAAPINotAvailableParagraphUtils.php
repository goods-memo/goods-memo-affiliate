<?php

namespace goodsmemo\option\amazon;

use goodsmemo\option\field\FieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";
require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";

class DisplayHTMLPAAPINotAvailableParagraphUtils {
	const DISPLAY_HTML_PAAPI_NOT_AVAILABLE_TEXTAREA_ID = AmazonSettingSection::ID_PREFIX . "_display_html_paapi_not_available_textarea_id";
	const DISPLAY_HTML_PAAPI_NOT_AVAILABLE_CHECKBOX_ID = AmazonSettingSection::ID_PREFIX . "_display_html_paapi_not_available_checkbox_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$displayHTMLPAAPINotAvailableTextareaFieldInfo = new FieldInfo ();
		$displayHTMLPAAPINotAvailableTextareaFieldInfo->setFieldID ( DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_PAAPI_NOT_AVAILABLE_TEXTAREA_ID );
		$displayHTMLPAAPINotAvailableTextareaFieldInfo->setFieldLabel ( "Product Advertising API 利用不可の時、表示するHTML" );

		// TODO
		$displayHTMLPAAPINotAvailable = <<< EOD
		<div class="{$_(GOODS_MEMO_PREFIX)}-{$idPrefix}-items {$_(GOODS_MEMO_PREFIX)}-items">
		EOD;
		$displayHTMLPAAPINotAvailableTextareaFieldInfo->setDefaultFieldValue ( $displayHTMLPAAPINotAvailable );
		array_push ( $fieldInfoArray, $displayHTMLPAAPINotAvailableTextareaFieldInfo );

		return $fieldInfoArray;
	}
}

