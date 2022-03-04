<?php

namespace goodsmemo\option\amazon;

use goodsmemo\option\field\FieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";
require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";

class DisplayHTMLPAAPINotAvailableParagraphUtils {
	const DISPLAY_HTML_PAAPI_NOT_AVAILABLE_TEXTAREA_ID = AmazonSettingSection::ID_PREFIX . "_display_html_textarea_id";
	const DISPLAY_HTML_PAAPI_NOT_AVAILABLE_CHECKBOX_ID = AmazonSettingSection::ID_PREFIX . "_display_html_checkbox_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$displayHTMLPAAPINotAvailableTextareaFieldInfo = new FieldInfo ();
		$displayHTMLPAAPINotAvailableTextareaFieldInfo->setFieldID ( DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_PAAPI_NOT_AVAILABLE_TEXTAREA_ID );
		$displayHTMLPAAPINotAvailableTextareaFieldInfo->setFieldLabel ( "Product Advertising API 利用不可の時、「表示するHTML」" );
		$htmlOfDisplayHTMLPAAPINotAvailable = <<< EOD
		<p>
		Product Advertising API 利用不可の時、表示するHTMLを、ここに設定します。<br>
		Product Advertising API アソシエイトタグ：GOODS_MEMO_ASSOCIATE_TAG<br>
		キーワード：GOODS_MEMO_SEARCH_KEYWORD<br>
		URLエンコードされたキーワード：GOODS_MEMO_ENCODED_SEARCH_KEYWORD
		</p>
		EOD;
		$displayHTMLPAAPINotAvailableTextareaFieldInfo->setDefaultFieldValue ( $htmlOfDisplayHTMLPAAPINotAvailable );
		array_push ( $fieldInfoArray, $displayHTMLPAAPINotAvailableTextareaFieldInfo );

		$displayHTMLPAAPINotAvailableCheckboxFieldInfo = new FieldInfo ();
		$displayHTMLPAAPINotAvailableCheckboxFieldInfo->setFieldID ( DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_PAAPI_NOT_AVAILABLE_CHECKBOX_ID );
		$displayHTMLPAAPINotAvailableCheckboxFieldInfo->setFieldLabel ( '「表示するHTML」の表示設定' );
		$displayHTMLPAAPINotAvailableCheckboxFieldInfo->setDefaultFieldValue ( "" );
		$displayHTMLPAAPINotAvailableCheckboxFieldInfo->setExistenceVerificationEnabled ( false ); // チェックボックスでは値の存在検査をしない。
		array_push ( $fieldInfoArray, $displayHTMLPAAPINotAvailableCheckboxFieldInfo );

		return $fieldInfoArray;
	}
}

