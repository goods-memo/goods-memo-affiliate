<?php

namespace goodsmemo\amazon\displayhtml;

use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\amazon\displayhtml\DisplayHTMLPAAPINotAvailableOption;
use goodsmemo\amazon\AmazonItemsHTMLInfoMaker;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\database\TransientUtils;

require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/displayhtml/DisplayHTMLPAAPINotAvailableOption.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "database/TransientUtils.php";

class DisplayHTMLPAAPINotAvailableUtils
{
	private const DISPLAY_HTML_PAAPI_NOT_AVAILABLE_PREFIX = "display_html";

	public static function makeDisplayHTMLPAAPINotAvailable(
		CommonRESTParameter $commonParameter,
		RESTParameter $restParameter,
		DisplayHTMLPAAPINotAvailableOption $displayHTMLOption
	) {

		$displayHTML = $displayHTMLOption->getDisplayHTMLPAAPINotAvailable();

		$searchArray = array(
			"GOODS_MEMO_ASSOCIATE_TAG", "GOODS_MEMO_SEARCH_KEYWORD",
			"GOODS_MEMO_ENCODED_SEARCH_KEYWORD"
		);

		$associateTag = $commonParameter->getAssociateTag();
		$keyword = $restParameter->getKeyword();
		$encoded_keyword = rawurlencode($keyword);

		$replaceArray = array(
			$associateTag, $keyword, $encoded_keyword
		);

		$newDisplayHTML = str_replace($searchArray, $replaceArray, $displayHTML);

		return $newDisplayHTML;
	}

	public static function getDisplayHTMLPAAPINotAvailableCache(
		ItemHTMLOption $itemHTMLOption,
		AmazonItemsHTMLInfoMaker $itemsHTMLInfoMaker
	) {

		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds();
		if ($cacheExpirationInSeconds <= 0) {
			return false;
		}

		$transientID = DisplayHTMLPAAPINotAvailableUtils::makeTransientID(
			$itemHTMLOption,
			$itemsHTMLInfoMaker
		);
		$displayHTMLCache = get_transient($transientID);

		return $displayHTMLCache;
	}

	public static function setDisplayHTMLPAAPINotAvailableCache(
		string $displayHTML,
		ItemHTMLOption $itemHTMLOption,
		AmazonItemsHTMLInfoMaker $itemsHTMLInfoMaker
	) {

		$transientID = DisplayHTMLPAAPINotAvailableUtils::makeTransientID(
			$itemHTMLOption,
			$itemsHTMLInfoMaker
		);
		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds();

		// 一時的にデータベースに「Product Advertising API 利用不可の時、表示するHTML」を保存する。有効期限後、削除される。
		TransientUtils::setTransient($transientID, $displayHTML, $cacheExpirationInSeconds);
	}

	private static function makeTransientID(
		ItemHTMLOption $itemHTMLOption,
		AmazonItemsHTMLInfoMaker $itemsHTMLInfoMaker
	) {

		$uniqueText = $itemsHTMLInfoMaker->makeUniqueText($itemHTMLOption);
		$uniqueTextOfDisplayHTML = DisplayHTMLPAAPINotAvailableUtils::DISPLAY_HTML_PAAPI_NOT_AVAILABLE_PREFIX .
			$uniqueText;

		// $transientID：キャッシュされるデータにつけるユニークな識別子。長さ 45 文字以下であること。
		// md5() ：32 文字の 16 進数からなるハッシュを返します。
		$transientID = GOODS_MEMO_PREFIX . md5($uniqueTextOfDisplayHTML);

		return $transientID;
	}
}
