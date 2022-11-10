<?php

namespace goodsmemo\option\rakuten;

use goodsmemo\option\field\TextFieldInfo;
use goodsmemo\option\field\TextareaFieldInfo;
use goodsmemo\option\paragraph\ReviewParagraph;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/field/TextareaFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ReviewParagraph.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

class ReviewParagraphUtils {
	const EDITORIAL_REVIEW_LENGTH_ID = RakutenSettingSection::ID_PREFIX . "_editorial_review_length_id";
	const STRING_TO_DELETE_JSON_ARRAY_ID = RakutenSettingSection::ID_PREFIX . "_string_to_delete_json_array_id";
	const STRING_TO_BREAK_JSON_OBJECT_ID = RakutenSettingSection::ID_PREFIX . "_string_to_break_json_object_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$editorialReviewLengthFieldInfo = new TextFieldInfo ();
		$editorialReviewLengthFieldInfo->setFieldID ( ReviewParagraphUtils::EDITORIAL_REVIEW_LENGTH_ID );
		$editorialReviewLengthFieldInfo->setFieldLabel ( 
				ReviewParagraph::DEFAULT_EDITORIAL_REVIEW_LENGTH_LABEL );
		$editorialReviewLengthFieldInfo->setDefaultFieldValue ( 
				ReviewParagraph::DEFAULT_EDITORIAL_REVIEW_LENGTH_VALUE );
		$editorialReviewLengthFieldInfo->enableMoreThanZeroVerification ();
		array_push ( $fieldInfoArray, $editorialReviewLengthFieldInfo );

		$stringToDeleteFieldInfo = new TextareaFieldInfo ();
		$stringToDeleteFieldInfo->setFieldID ( ReviewParagraphUtils::STRING_TO_DELETE_JSON_ARRAY_ID );
		$stringToDeleteFieldInfo->setFieldLabel ( ReviewParagraph::DEFAULT_STRING_TO_DELETE_JSON_ARRAY_LABEL );
		$stringToDeleteFieldInfo->setDefaultFieldValue ( 
				ReviewParagraph::DEFAULT_STRING_TO_DELETE_JSON_ARRAY_VALUE );
		$stringToDeleteFieldInfo->setRows ( 10 );
		array_push ( $fieldInfoArray, $stringToDeleteFieldInfo );

		$stringToBreakFieldInfo = new TextareaFieldInfo ();
		$stringToBreakFieldInfo->setFieldID ( ReviewParagraphUtils::STRING_TO_BREAK_JSON_OBJECT_ID );
		$stringToBreakFieldInfo->setFieldLabel ( ReviewParagraph::DEFAULT_STRING_TO_BREAK_JSON_OBJECT_LABEL );
		$stringToBreakFieldInfo->setDefaultFieldValue ( 
				ReviewParagraph::DEFAULT_STRING_TO_BREAK_JSON_OBJECT_VALUE );
		$stringToBreakFieldInfo->setRows ( 10 );
		// 特殊文字を HTML エンティティに変換する、を有効。例：< (小なり) を&lt;に変換する。
		$stringToBreakFieldInfo->setHtmlTagEnabled ( true );
		array_push ( $fieldInfoArray, $stringToBreakFieldInfo );

		return $fieldInfoArray;
	}
}
