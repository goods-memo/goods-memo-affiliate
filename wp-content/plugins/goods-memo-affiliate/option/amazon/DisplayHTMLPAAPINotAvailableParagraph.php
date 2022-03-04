<?php

namespace goodsmemo\option\amazon;

use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\paragraph\AbstractParagraph;
use goodsmemo\option\paragraph\AbstractTextParagraph;
use goodsmemo\option\field\TextareaField;
use goodsmemo\option\field\CheckboxField;

require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractTextParagraph.php";
require_once GOODS_MEMO_DIR . "option/field/TextareaField.php";
require_once GOODS_MEMO_DIR . "option/field/CheckboxField.php";

/**
 * Product Advertising API 利用不可の時、表示するHTML
 *
 * @author Goods Memo
 */
class DisplayHTMLPAAPINotAvailableParagraph extends AbstractParagraph {
	use AbstractTextParagraph;
	const DISPLAY_HTML_PAAPI_NOT_AVAILABLE_CHECKED_VALUE = "displayHTMLChecked";
	const DISPLAY_HTML_PAAPI_NOT_AVAILABLE_LABEL_FOR_CHECKBOX = "常に表示する。Product Advertising API を、常に使用しない場合（アクセス制限のため利用できない場合）";

	public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray) {

		parent::setOptionGroup ( $pageInfo->getOptionGroup () );
		parent::setSectionTitle ( $sectionInfo->getSectionTitle () );
		parent::setFieldInfoArray ( $fieldInfoArray );

		$displayHTMLPAAPINotAvailableTextarea = new TextareaField ( $pageInfo->getOptionNameOfDatabase (), $fieldInfoArray [0] );
		parent::addField ( $pageInfo, $sectionInfo, $displayHTMLPAAPINotAvailableTextarea );

		$displayHTMLPAAPINotAvailableCheckboxField = new CheckboxField ( $pageInfo->getOptionNameOfDatabase (), $fieldInfoArray [1], //
		DisplayHTMLPAAPINotAvailableParagraph::DISPLAY_HTML_PAAPI_NOT_AVAILABLE_CHECKED_VALUE, //
		DisplayHTMLPAAPINotAvailableParagraph::DISPLAY_HTML_PAAPI_NOT_AVAILABLE_LABEL_FOR_CHECKBOX );
		parent::addField ( $pageInfo, $sectionInfo, $displayHTMLPAAPINotAvailableCheckboxField );
	}

	public function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap) {

		// sanitizedValueMap：変更するため、配列の参照渡しとする。
		$this->validateExistence ( $inputedValueMap );
		parent::sanitizeParagraphValue ( $inputedValueMap, $sanitizedValueMap );
	}
}

