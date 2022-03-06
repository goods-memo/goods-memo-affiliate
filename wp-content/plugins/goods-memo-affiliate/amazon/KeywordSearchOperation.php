<?php

/*
 * Copyright (C) 2018 Goods Memo.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301 USA
 */
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

/**
 * Description of AmazonKeywordSearchOperation
 *
 * @author Goods Memo
 */
class KeywordSearchOperation {

	public static function makeHTMLOfSearchOperation(URLInfo $urlInfo, CommonRESTParameter $commonParameter, RESTParameter $restParameter, ItemHTMLOption $itemHTMLOption, ProductTypeOption $productTypeOption, DisplayHTMLPAAPINotAvailableOption $displayHTMLOption) {

		$affiliateHTML;

		$searchIndex = $restParameter->getSearchIndex ();
		switch ($searchIndex) {
			case RESTParagraphUtils::ALL_SEARCH_INDEX :

				$affiliateHTML = KeywordSearchOperation::makeHTMLOfSearchIndex ( $urlInfo, $commonParameter, $restParameter, $itemHTMLOption, $productTypeOption, $displayHTMLOption );
				break;

			default :

				throw new IllegalArgumentException ( "無効なサーチインデックス：" . $searchIndex );
		}

		return $affiliateHTML;
	}

	private static function makeHTMLOfSearchIndex(URLInfo $urlInfo, CommonRESTParameter $commonParameter, RESTParameter $restParameter, ItemHTMLOption $itemHTMLOption, ProductTypeOption $productTypeOption, DisplayHTMLPAAPINotAvailableOption $displayHTMLOption) {

		$displayHTMLAlwaysEnabled = $displayHTMLOption->getDisplayHTMLPAAPINotAvailableAlwaysEnabled ();
		if ($displayHTMLAlwaysEnabled) {

			$displayHTML = DisplayHTMLPAAPINotAvailableUtils::makeDisplayHTMLPAAPINotAvailable ( $commonParameter, $restParameter, $displayHTMLOption );
			return $displayHTML;
		}

		$itemsHTMLInfoMaker = new AmazonItemsHTMLInfoMaker ( $commonParameter, $restParameter, $productTypeOption );

		$displayHTMLCache = DisplayHTMLPAAPINotAvailableUtils::geDisplayHTMLPAAPINotAvailableCache ( $itemHTMLOption, $itemsHTMLInfoMaker );
		if ($displayHTMLCache !== false) {
			return $displayHTMLCache;
		}

		try {
			$itemsHtml = ItemSearchOperation::makeItemsHTML ( $urlInfo, $itemHTMLOption, $itemsHTMLInfoMaker );
			return $itemsHtml;
		} catch ( HttpRequestException $ex ) {

			$responseCode = $ex->getCode ();

			/*
			 * APIリクエストが多すぎる場合
			 * 429:Too Many Requests
			 * The request was denied due to request throttling. Please verify the number of requests made per second to the Amazon Product Advertising API.
			 *
			 * Product Advertising API 売上実績なしの場合
			 * 503:RequestThrottled
			 * A 503 error means that you are submitting requests too quickly and your requests are being throttled.
			 * If this is the case, you need to reduce the number of requests you are sending per second.
			 */
			$displayHTMLEnabled;
			switch ($responseCode) {
				case 429 :
				case 503 :
					$displayHTMLEnabled = TRUE;
					break;
				default :
					$displayHTMLEnabled = FALSE;
			}

			if ($displayHTMLEnabled) {

				$displayHTML = DisplayHTMLPAAPINotAvailableUtils::makeDisplayHTMLPAAPINotAvailable ( $commonParameter, $restParameter, $displayHTMLOption );
				DisplayHTMLPAAPINotAvailableUtils::setDisplayHTMLPAAPINotAvailableCache ( $displayHTML, $itemHTMLOption, $itemsHTMLInfoMaker );
				return $displayHTML;
			} else {
				throw $ex;
			}
		}
	}
}
