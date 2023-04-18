<?php

namespace goodsmemo\amazon;

use goodsmemo\amazon\KeywordSearchOperation;
use goodsmemo\amazon\AmazonOptionUtils;
use goodsmemo\amazon\AmazonItemHTMLUtils;
use goodsmemo\amazon\displayhtml\DisplayHTMLPAAPINotAvailableUtils;
use goodsmemo\network\URLUtils;
use goodsmemo\option\AffiliateOptionUtils;
use goodsmemo\option\amazon\URLParagraphUtils;
use goodsmemo\option\amazon\RESTParagraphUtils;
use goodsmemo\shortcode\ShortcodeAttribute;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "amazon/KeywordSearchOperation.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonOptionUtils.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "amazon/displayhtml/DisplayHTMLPAAPINotAvailableUtils.php";
require_once GOODS_MEMO_DIR . "network/URLUtils.php";
require_once GOODS_MEMO_DIR . "option/AffiliateOptionUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/URLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/RESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttribute.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";

class AmazonAffiliate {

	public static function makeHTML(ShortcodeAttribute $shortcodeAttribute) {

		$optionMap = AffiliateOptionUtils::getAffiliateOption (); // ここで一回だけデータベースを読み込む。

		$commonParameter = AmazonOptionUtils::makeCommonRESTParameter ( $optionMap );
		$restParameter = AmazonOptionUtils::makeRESTParameter ( $optionMap, $shortcodeAttribute );
		$displayHTMLOption = AmazonOptionUtils::makeDisplayHTMLPAAPINotAvailableOption ( $optionMap );

		$displayHTMLAlwaysEnabled = $displayHTMLOption->getDisplayHTMLPAAPINotAvailableAlwaysEnabled ();
		if ($displayHTMLAlwaysEnabled) {

			$displayHTML = DisplayHTMLPAAPINotAvailableUtils::makeDisplayHTMLPAAPINotAvailable ( 
					$commonParameter, $restParameter, $displayHTMLOption );
			return $displayHTML;
		}

		$urlInfo = URLUtils::makeURLInfo ( $optionMap, URLParagraphUtils::HOSTNAME_ID );
		$itemHTMLOption = AmazonItemHTMLUtils::makeItemHTMLOption ( $optionMap, $shortcodeAttribute );
		$productTypeOption = AmazonOptionUtils::makeProductTypeOption ( $optionMap );

		$affiliateHTML;

		$operation = $restParameter->getOperation ();
		switch ($operation) {
			case RESTParagraphUtils::SEARCH_ITEMS_OPERATION :

				// 現時点では、「Operation="SearchItems", SearchIndex="all"の組み合わせ」で、キーワード検索する処理だけ行なう。
				$affiliateHTML = KeywordSearchOperation::makeHTMLOfSearchOperation ( $urlInfo,
						$commonParameter, $restParameter, $itemHTMLOption, $productTypeOption,
						$displayHTMLOption );
				break;

			default :

				throw new IllegalArgumentException ( "無効なオペレーション：" . $operation );
		}

		return $affiliateHTML;
	}
}
