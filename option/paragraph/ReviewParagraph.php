<?php

namespace goodsmemo\option\paragraph;

use goodsmemo\option\paragraph\AbstractParagraph;
use goodsmemo\option\paragraph\AbstractTextParagraph;
use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\field\TextField;
use goodsmemo\option\field\TextareaField;

require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractTextParagraph.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/field/TextField.php";
require_once GOODS_MEMO_DIR . "option/field/TextareaField.php";

class ReviewParagraph extends AbstractParagraph
{
	use AbstractTextParagraph;
	const DEFAULT_EDITORIAL_REVIEW_LENGTH_LABEL = "商品説明の表示文字数（目安の文字数）";
	const DEFAULT_EDITORIAL_REVIEW_LENGTH_VALUE = 120;
	const DEFAULT_STRING_TO_DELETE_JSON_ARRAY_LABEL = "商品説明から削除する文字列のJSON配列（空の配列[]）";
	// 削除する文字列の配列。例：全角の＜＞
	const DEFAULT_STRING_TO_DELETE_JSON_ARRAY_VALUE = '["＜p＞","＜/p＞","＜b＞","＜br＞","＜br /＞"]';
	const DEFAULT_STRING_TO_BREAK_JSON_OBJECT_LABEL = "商品説明で改行する文字列のJSONオブジェクト（空のオブジェクト{}）";
	// 改行する文字列の配列
	const DEFAULT_STRING_TO_BREAK_JSON_OBJECT_VALUE = <<< EOD
	{
	"●":"<br>●",
	"■":"<br>■",
	"◆":"<br>◆",
	"★":"<br>★",
	"【":"<br>【",
	"。":"。<br>"
	}
	EOD;

	public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray)
	{

		parent::setOptionGroup($pageInfo->getOptionGroup());
		parent::setSectionTitle($sectionInfo->getSectionTitle());
		parent::setFieldInfoArray($fieldInfoArray);

		$editorialReviewLengthTextField = new TextField(
			$pageInfo->getOptionNameOfDatabase(),
			$fieldInfoArray[0]
		);
		parent::addField($pageInfo, $sectionInfo, $editorialReviewLengthTextField);

		$stringToDeleteTextarea = new TextareaField(
			$pageInfo->getOptionNameOfDatabase(),
			$fieldInfoArray[1]
		);
		parent::addField($pageInfo, $sectionInfo, $stringToDeleteTextarea);

		$stringToBreakTextarea = new TextareaField(
			$pageInfo->getOptionNameOfDatabase(),
			$fieldInfoArray[2]
		);
		parent::addField($pageInfo, $sectionInfo, $stringToBreakTextarea);
	}

	public function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap)
	{

		// sanitizedValueMap：変更するため、配列の参照渡しとする。
		$this->validateMoreThanZero($inputedValueMap);
		$this->validateExistence($inputedValueMap);
		parent::sanitizeParagraphValue($inputedValueMap, $sanitizedValueMap);
	}
}
