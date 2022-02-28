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

use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\PriceItemHTMLOption;
use goodsmemo\item\html\ReviewItemHTMLUtils;
use goodsmemo\option\amazon\AmazonSettingSection;
use goodsmemo\option\amazon\ItemHTMLParagraphUtils;
use goodsmemo\option\amazon\PriceParagraphUtils;
use goodsmemo\option\amazon\ReviewParagraphUtils;

require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/PriceItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";
require_once GOODS_MEMO_DIR . "option/amazon/ItemHTMLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/PriceParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/ReviewParagraphUtils.php";

/**
 * Description of ItemHTMLUtils
 *
 * @author Goods Memo
 */
class ItemHTMLUtils {

    public static function makeItemHTMLOption($optionMap, int $number): ItemHTMLOption {

	$option = new ItemHTMLOption();

	//TODO get_option()から、値を取得する。

	$option->setIdPrefix(AmazonSettingSection::ID_PREFIX);

	if (is_numeric($number)) {//ゼロも有効とした。
	    $option->setNumberToDisplay($number);
	} else {
	    $option->setNumberToDisplay(ItemHTMLParagraphUtils::DEFAULT_NUMBER_TO_DISPLAY);
	}

	$titleLength = $optionMap[ItemHTMLParagraphUtils::TITLE_LENGTH_ID];
	$option->setTitleLength($titleLength);

	$priceItemHTMLOption = ItemHTMLUtils::makePriceItemHTMLOption($optionMap);
	$option->setPriceItemHTMLOption($priceItemHTMLOption);

	$reviewItemHTMLOption = ReviewItemHTMLUtils::makeReviewItemHTMLOption(
			$optionMap, //
			ReviewParagraphUtils::EDITORIAL_REVIEW_LENGTH_ID, //
			ReviewParagraphUtils::ARRAY_OF_STRING_TO_DELETE_ID, //
			ReviewParagraphUtils::ARRAY_OF_STRING_TO_BREAK_ID
	);
	$option->setReviewItemHTMLOption($reviewItemHTMLOption);

	$cacheExpirationInSeconds = $optionMap[ItemHTMLParagraphUtils::CACHE_EXPIRATION_IN_SECONDS_ID];
	$option->setCacheExpirationInSeconds($cacheExpirationInSeconds);

	return $option;
    }

    private static function makePriceItemHTMLOption($optionMap): PriceItemHTMLOption {

	$priceItemHTMLOption = new PriceItemHTMLOption();

	//TODO get_option()から、値を取得する。
	//PriceItemHTMLUtils::makePriceItemHTMLOptionを作成して、共通化する。

	$priceItemHTMLOption->setPriceTimeLinkVisible(PriceParagraphUtils::DEFAULT_PRICE_TIME_LINK_VISIBLE);
	$priceItemHTMLOption->setPriceFooterText(PriceParagraphUtils::DEFAULT_PRICE_TIME_FOOTER_TEXT);

	return $priceItemHTMLOption;
    }

}
