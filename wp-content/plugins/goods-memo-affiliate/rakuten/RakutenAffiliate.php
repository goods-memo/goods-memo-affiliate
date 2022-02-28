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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace goodsmemo\rakuten;

use goodsmemo\rakuten\KeywordSearchOperation;
use goodsmemo\rakuten\RakutenOptionUtils;
use goodsmemo\rakuten\ItemHTMLUtils;
use goodsmemo\network\URLUtils;
use goodsmemo\option\AffiliateOptionUtils;
use goodsmemo\option\rakuten\URLParagraphUtils;
use goodsmemo\option\rakuten\SearchParagraphUtils;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "rakuten/KeywordSearchOperation.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenOptionUtils.php";
require_once GOODS_MEMO_DIR . "rakuten/ItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "network/URLUtils.php";
require_once GOODS_MEMO_DIR . "option/AffiliateOptionUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/URLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/SearchParagraphUtils.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";

/**
 * Description of RakutenAffiliate
 *
 * @author Goods Memo
 */
class RakutenAffiliate {

	public static function makeHTML($operationOfShortcode, $keyword, $number) {

		$optionMap = AffiliateOptionUtils::getAffiliateOption(); //ここで一回だけデータベースを読み込む。

		$urlInfo = URLUtils::makeURLInfo($optionMap, URLParagraphUtils::HOSTNAME_ID, URLParagraphUtils::PATH_ID);
		$commonParameter = RakutenOptionUtils::makeCommonRESTParameter($optionMap);
		$restParameter = RakutenOptionUtils::makeRESTParameter($optionMap, $keyword);
		$searchOption = RakutenOptionUtils::makeSearchOption($optionMap, $operationOfShortcode);
		$itemHTMLOption = ItemHTMLUtils::makeItemHTMLOption($optionMap, $number);

		$affiliateHTML;

		$operation = $searchOption->getOperation();
		switch ($operation) {
			case SearchParagraphUtils::ICHIBA_ITEM_SEARCH_OPERATION:

				//現時点では、Operation="ItemSearch"で、キーワード検索する処理だけ行なう。
				$affiliateHTML = KeywordSearchOperation::makeHTMLOfIchibaItemSearch(
						$urlInfo, $commonParameter, $restParameter, $searchOption, $itemHTMLOption);
				break;

			default:

				throw new IllegalArgumentException("無効なオペレーション：" . $operation);
		}

		return $affiliateHTML;
	}

}
