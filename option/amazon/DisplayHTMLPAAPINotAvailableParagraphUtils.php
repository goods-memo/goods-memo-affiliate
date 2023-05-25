<?php

namespace goodsmemo\option\amazon;

use goodsmemo\option\field\TextareaFieldInfo;
use goodsmemo\option\field\CheckboxFieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextareaFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/field/CheckboxFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

class DisplayHTMLPAAPINotAvailableParagraphUtils {
	const DISPLAY_HTML_TEXTAREA_ID = AmazonSettingSection::ID_PREFIX . "_display_html_paapi_not_available_textarea_id";
	const DISPLAY_HTML_CHECKBOX_ID = AmazonSettingSection::ID_PREFIX . "_display_html_paapi_not_available_checkbox_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$displayHTMLTextareaFieldInfo = new TextareaFieldInfo ();
		$displayHTMLTextareaFieldInfo->setFieldID ( DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_TEXTAREA_ID );
		$displayHTMLTextareaFieldInfo->setFieldLabel ( "Product Advertising API 利用不可の時、「表示するHTML」（商品情報のキャッシュ時間（秒）が適用されます）" );
		$displayHTML = <<< EOD
		<p>
		Product Advertising API 利用不可の時、表示するHTMLを、ここに設定します。<br>
		Product Advertising API アソシエイトタグ：GOODS_MEMO_ASSOCIATE_TAG<br>
		キーワード：GOODS_MEMO_SEARCH_KEYWORD<br>
		URLエンコードされたキーワード：GOODS_MEMO_ENCODED_SEARCH_KEYWORD
		</p>
		EOD;
		$displayHTMLTextareaFieldInfo->setDefaultFieldValue ( $displayHTML );
		$displayHTMLTextareaFieldInfo->setRows ( 10 );
		// 特殊文字を HTML エンティティに変換する、を有効。例：< (小なり) を&lt;に変換する。
		$displayHTMLTextareaFieldInfo->setHtmlTagEnabled ( true );
		array_push ( $fieldInfoArray, $displayHTMLTextareaFieldInfo );

		$displayHTMLCheckboxFieldInfo = new CheckboxFieldInfo ();
		$displayHTMLCheckboxFieldInfo->setFieldID ( DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_CHECKBOX_ID );
		$displayHTMLCheckboxFieldInfo->setFieldLabel ( '「表示するHTML」の表示設定' );
		array_push ( $fieldInfoArray, $displayHTMLCheckboxFieldInfo );

		return $fieldInfoArray;
	}
}

