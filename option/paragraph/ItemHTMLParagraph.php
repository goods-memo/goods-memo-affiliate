<?php

namespace goodsmemo\option\paragraph;

use goodsmemo\option\paragraph\AbstractParagraph;
use goodsmemo\option\paragraph\AbstractTextParagraph;
use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\field\TextField;

require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractTextParagraph.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/field/TextField.php";

/**
 * Description of ItemHTMLParagraph
 *
 * @author Goods Memo
 */
class ItemHTMLParagraph extends AbstractParagraph {

	use AbstractTextParagraph;
	const DEFAULT_TITLE_LENGTH_LABEL = "商品名の表示文字数（目安の文字数）";
	const DEFAULT_TITLE_LENGTH_VALUE = 60;
	//
	const DEFAULT_CACHE_EXPIRATION_IN_SECONDS_LABEL = "商品情報のキャッシュ時間（秒）（0秒：キャッシュ無効）";
	const DEFAULT_CACHE_EXPIRATION_IN_SECONDS_VALUE = 86400;

	// 例：3600秒=1時間。21600秒=6時間。86400秒=24時間。
	public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray) {

		parent::setOptionGroup ( $pageInfo->getOptionGroup () );
		parent::setSectionTitle ( $sectionInfo->getSectionTitle () );
		parent::setFieldInfoArray ( $fieldInfoArray );

		$titleLengthTextField = new TextField ( $pageInfo->getOptionNameOfDatabase (), $fieldInfoArray [0] );
		parent::addField ( $pageInfo, $sectionInfo, $titleLengthTextField );

		$cacheExpirationInSecondsTextField = new TextField ( $pageInfo->getOptionNameOfDatabase (), $fieldInfoArray [1] );
		parent::addField ( $pageInfo, $sectionInfo, $cacheExpirationInSecondsTextField );
	}

	public function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap) {

		// sanitizedValueMap：変更するため、配列の参照渡しとする。
		$this->validateMoreThanZero ( $inputedValueMap );
		parent::sanitizeParagraphValue ( $inputedValueMap, $sanitizedValueMap );
	}
}
