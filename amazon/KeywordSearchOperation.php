<?php

namespace goodsmemo\amazon;

use goodsmemo\network\URLInfo;
use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\amazon\ProductTypeOption;
use goodsmemo\amazon\AmazonItemsHTMLInfoMaker;
use goodsmemo\amazon\displayhtml\DisplayHTMLPAAPINotAvailableOption;
use goodsmemo\amazon\displayhtml\DisplayHTMLPAAPINotAvailableUtils;
use goodsmemo\item\ItemSearchOperation;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\ItemArrayHTMLMaking;
use goodsmemo\option\amazon\RESTParagraphUtils;
use goodsmemo\exception\HttpRequestException;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/ProductTypeOption.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "amazon/displayhtml/DisplayHTMLPAAPINotAvailableOption.php";
require_once GOODS_MEMO_DIR . "amazon/displayhtml/DisplayHTMLPAAPINotAvailableUtils.php";
require_once GOODS_MEMO_DIR . "item/ItemSearchOperation.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ItemArrayHTMLMaking.php";
require_once GOODS_MEMO_DIR . "option/amazon/RESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";

class KeywordSearchOperation
{

	public static function makeHTMLOfSearchOperation(
		URLInfo $urlInfo,
		CommonRESTParameter $commonParameter,
		RESTParameter $restParameter,
		ItemHTMLOption $itemHTMLOption,
		ProductTypeOption $productTypeOption,
		DisplayHTMLPAAPINotAvailableOption $displayHTMLOption
	) {

		$itemsHTMLInfoMaker = new AmazonItemsHTMLInfoMaker(
			$commonParameter,
			$restParameter,
			$productTypeOption
		);

		$displayHTMLCache = DisplayHTMLPAAPINotAvailableUtils::getDisplayHTMLPAAPINotAvailableCache(
			$itemHTMLOption,
			$itemsHTMLInfoMaker
		);
		if ($displayHTMLCache !== false) {
			return $displayHTMLCache;
		}

		try {
			$affiliateHTML;

			$searchIndex = $restParameter->getSearchIndex();
			switch ($searchIndex) {
				case RESTParagraphUtils::ALL_SEARCH_INDEX:

					$affiliateHTML = ItemSearchOperation::makeItemsHTML(
						$urlInfo,
						$itemHTMLOption,
						$itemsHTMLInfoMaker
					);
					break;

				default:

					throw new IllegalArgumentException("無効なサーチインデックス：" . $searchIndex);
			}

			return $affiliateHTML;
		} catch (HttpRequestException $ex) {

			$displayHTML = DisplayHTMLPAAPINotAvailableUtils::makeDisplayHTMLPAAPINotAvailable(
				$commonParameter,
				$restParameter,
				$displayHTMLOption
			);

			// HTTP Statusのエラー情報を、HTMLのコメントで出力する。下記コメント文を参照。
			$displayHTML .= "<!-- HTTPリクエストの例外：" . $ex->getMessage() . "。コード：" . $ex->getCode() .
				" -->";

			DisplayHTMLPAAPINotAvailableUtils::setDisplayHTMLPAAPINotAvailableCache(
				$displayHTML,
				$itemHTMLOption,
				$itemsHTMLInfoMaker
			);
			return $displayHTML;
		}
	}

	/*
	 * $responseCode = $ex->getCode ();
	 *
	 * 401:InvalidSignature
	 * ローカル環境(XAMPP)のみで発生した。原因は、わからない。
	 *
	 * APIリクエストが多すぎる場合
	 * 429:Too Many Requests
	 * The request was denied due to request throttling. Please verify the number of requests made per second to the Amazon Product Advertising API.
	 *
	 * Product Advertising API 売上実績なしの場合
	 * 503:RequestThrottled
	 * A 503 error means that you are submitting requests too quickly and your requests are being throttled.
	 * If this is the case, you need to reduce the number of requests you are sending per second.
	 */
}
