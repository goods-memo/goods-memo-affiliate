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

namespace goodsmemo\amazon;

use goodsmemo\amazon\KeywordSearchOperation;
use goodsmemo\amazon\AmazonOptionUtils;
use goodsmemo\amazon\ItemHTMLUtils;
use goodsmemo\network\URLUtils;
use goodsmemo\option\AffiliateOptionUtils;
use goodsmemo\option\amazon\URLParagraphUtils;
use goodsmemo\option\amazon\RESTParagraphUtils;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "amazon/KeywordSearchOperation.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonOptionUtils.php";
require_once GOODS_MEMO_DIR . "amazon/ItemHTMLUtils.php";
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

		$optionMap = AffiliateOptionUtils::getAffiliateOption(); //ここで一回だけデータベースを読み込む。

		$urlInfo = URLUtils::makeURLInfo($optionMap, URLParagraphUtils::HOSTNAME_ID);
		$commonParameter = AmazonOptionUtils::makeCommonRESTParameter($optionMap);
		$restParameter = AmazonOptionUtils::makeRESTParameter($optionMap, $operationOfShortcode, $searchIndexOfShortcode,
				$keyword);
		$itemHTMLOption = ItemHTMLUtils::makeItemHTMLOption($optionMap, $number);
		$productTypeOption = AmazonOptionUtils::makeProductTypeOption($optionMap);
		$searchWidgetOption = AmazonOptionUtils::makeSearchWidgetOption($optionMap);

		$affiliateHTML;

		$operation = $restParameter->getOperation();
		switch ($operation) {
			case RESTParagraphUtils::ITEM_SEARCH_OPERATION:

				//現時点では、「Operation="ItemSearch", SearchIndex="all"の組み合わせ」で、キーワード検索する処理だけ行なう。
				$affiliateHTML = KeywordSearchOperation::makeHTMLOfSearchOperation($urlInfo, $commonParameter, $restParameter,
						$itemHTMLOption, $productTypeOption, $searchWidgetOption);
				break;

			default:

				throw new IllegalArgumentException("無効なオペレーション：" . $operation);
		}

		return $affiliateHTML;
	}

}
