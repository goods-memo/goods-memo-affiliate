<?php

namespace goodsmemo\amazon;

use goodsmemo\amazon\KeywordSearchOperation;
use goodsmemo\amazon\AmazonOptionUtils;
use goodsmemo\amazon\ItemHTMLUtils;
use goodsmemo\amazon\displayhtml\DisplayHTMLPAAPINotAvailableUtils;
use goodsmemo\network\URLUtils;
use goodsmemo\option\AffiliateOptionUtils;
use goodsmemo\option\amazon\URLParagraphUtils;
use goodsmemo\option\amazon\RESTParagraphUtils;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "amazon/KeywordSearchOperation.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonOptionUtils.php";
require_once GOODS_MEMO_DIR . "amazon/ItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "amazon/displayhtml/DisplayHTMLPAAPINotAvailableUtils.php";
require_once GOODS_MEMO_DIR . "network/URLUtils.php";
require_once GOODS_MEMO_DIR . "option/AffiliateOptionUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/URLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/RESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";

/**
 * Description of Amazon
 *
 * @author Goods Memo
 */
class AmazonAffiliate {

	public static function makeHTML($operationOfShortcode, $searchIndexOfShortcode, $keyword, $number) {

		$optionMap = AffiliateOptionUtils::getAffiliateOption (); // ここで一回だけデータベースを読み込む。

		$commonParameter = AmazonOptionUtils::makeCommonRESTParameter ( $optionMap );
		$restParameter = AmazonOptionUtils::makeRESTParameter ( $optionMap, $operationOfShortcode, $searchIndexOfShortcode, $keyword );
		$displayHTMLOption = AmazonOptionUtils::makeDisplayHTMLPAAPINotAvailableOption ( $optionMap );

		$displayHTMLAlwaysEnabled = $displayHTMLOption->getDisplayHTMLPAAPINotAvailableAlwaysEnabled ();
		if ($displayHTMLAlwaysEnabled) {

			$displayHTML = DisplayHTMLPAAPINotAvailableUtils::makeDisplayHTMLPAAPINotAvailable ( $commonParameter, $restParameter, $displayHTMLOption );
			return $displayHTML;
		}

		$urlInfo = URLUtils::makeURLInfo ( $optionMap, URLParagraphUtils::HOSTNAME_ID );
		$itemHTMLOption = ItemHTMLUtils::makeItemHTMLOption ( $optionMap, $number );
		$productTypeOption = AmazonOptionUtils::makeProductTypeOption ( $optionMap );

		$affiliateHTML;

		$operation = $restParameter->getOperation ();
		switch ($operation) {
			case RESTParagraphUtils::ITEM_SEARCH_OPERATION :

				// 現時点では、「Operation="ItemSearch", SearchIndex="all"の組み合わせ」で、キーワード検索する処理だけ行なう。
				$affiliateHTML = KeywordSearchOperation::makeHTMLOfSearchOperation ( $urlInfo, $commonParameter, $restParameter, $itemHTMLOption, $productTypeOption, $displayHTMLOption );
				break;

			default :

				throw new IllegalArgumentException ( "無効なオペレーション：" . $operation );
		}

		return $affiliateHTML;
	}
}
