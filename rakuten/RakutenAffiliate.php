<?php

namespace goodsmemo\rakuten;

use goodsmemo\rakuten\KeywordSearchOperation;
use goodsmemo\rakuten\RakutenOptionUtils;
use goodsmemo\rakuten\RakutenItemHTMLOptionUtils;
use goodsmemo\network\URLUtils;
use goodsmemo\option\AffiliateOptionUtils;
use goodsmemo\option\rakuten\URLParagraphUtils;
use goodsmemo\option\rakuten\SearchParagraphUtils;
use goodsmemo\shortcode\ShortcodeAttribute;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "rakuten/KeywordSearchOperation.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenOptionUtils.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenItemHTMLOptionUtils.php";
require_once GOODS_MEMO_DIR . "network/URLUtils.php";
require_once GOODS_MEMO_DIR . "option/AffiliateOptionUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/URLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/SearchParagraphUtils.php";
require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttribute.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";

class RakutenAffiliate
{

	public static function makeHTML(ShortcodeAttribute $shortcodeAttribute)
	{

		$optionMap = AffiliateOptionUtils::getAffiliateOption(); // ここで一回だけデータベースを読み込む。

		$urlInfo = URLUtils::makeURLInfo($optionMap, URLParagraphUtils::HOSTNAME_ID, URLParagraphUtils::PATH_ID);
		$commonParameter = RakutenOptionUtils::makeCommonRESTParameter($optionMap);
		$restParameter = RakutenOptionUtils::makeRESTParameter($optionMap, $shortcodeAttribute->getKeyword());
		$searchOption = RakutenOptionUtils::makeSearchOption($optionMap, $shortcodeAttribute->getOperation());
		$itemHTMLOption = RakutenItemHTMLOptionUtils::makeItemHTMLOption($optionMap, $shortcodeAttribute);

		$affiliateHTML;

		$operation = $searchOption->getOperation();
		switch ($operation) {
			case SearchParagraphUtils::ICHIBA_ITEM_SEARCH_OPERATION:

				// 現時点では、Operation="IchibaItemSearch"で、楽天市場商品をキーワード検索する処理だけ行う。
				$affiliateHTML = KeywordSearchOperation::makeHTMLOfIchibaItemSearch($urlInfo, $commonParameter, $restParameter, $searchOption, $itemHTMLOption);
				break;

			default:

				throw new IllegalArgumentException("無効なオペレーション：" . $operation);
		}

		return $affiliateHTML;
	}
}
