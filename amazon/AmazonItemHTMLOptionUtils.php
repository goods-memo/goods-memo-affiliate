<?php

namespace goodsmemo\amazon;

use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\ItemHTMLUtils;
use goodsmemo\item\html\PriceItemHTMLOption;
use goodsmemo\item\html\ReviewItemHTMLOptionUtils;
use goodsmemo\option\amazon\AmazonSettingSection;
use goodsmemo\option\amazon\ItemHTMLParagraphUtils;
use goodsmemo\option\amazon\PriceParagraphUtils;
use goodsmemo\option\amazon\ReviewParagraphUtils;
use goodsmemo\shortcode\ShortcodeAttribute;

require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "item/html/PriceItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLOptionUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";
require_once GOODS_MEMO_DIR . "option/amazon/ItemHTMLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/PriceParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/ReviewParagraphUtils.php";
require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttribute.php";

class AmazonItemHTMLOptionUtils
{

	public static function makeItemHTMLOption($optionMap, ShortcodeAttribute $shortcodeAttribute): ItemHTMLOption
	{

		$option = new ItemHTMLOption();

		// TODO get_option()から、値を取得する。

		$option->setIdPrefix(AmazonSettingSection::ID_PREFIX);

		ItemHTMLUtils::setNumberToDisplayTo($option, $shortcodeAttribute, ItemHTMLParagraphUtils::DEFAULT_NUMBER_TO_DISPLAY);

		$titleLengthOfOptionMap = $optionMap[ItemHTMLParagraphUtils::TITLE_LENGTH_ID];
		ItemHTMLUtils::setTitleLengthTo($option, $shortcodeAttribute, $titleLengthOfOptionMap);

		$priceItemHTMLOption = AmazonItemHTMLOptionUtils::makePriceItemHTMLOption($optionMap);
		$option->setPriceItemHTMLOption($priceItemHTMLOption);

		$reviewItemHTMLOption = ReviewItemHTMLOptionUtils::makeReviewItemHTMLOption( //
			$optionMap,
			$shortcodeAttribute->getItemReviewLength(), //
			ReviewParagraphUtils::EDITORIAL_REVIEW_LENGTH_ID, //
			ReviewParagraphUtils::STRING_TO_DELETE_JSON_ARRAY_ID, //
			ReviewParagraphUtils::STRING_TO_BREAK_JSON_OBJECT_ID
		);
		$option->setReviewItemHTMLOption($reviewItemHTMLOption);

		$cacheExpirationInSeconds = $optionMap[ItemHTMLParagraphUtils::CACHE_EXPIRATION_IN_SECONDS_ID];
		$option->setCacheExpirationInSeconds($cacheExpirationInSeconds);

		return $option;
	}

	private static function makePriceItemHTMLOption($optionMap): PriceItemHTMLOption
	{

		$priceItemHTMLOption = new PriceItemHTMLOption();

		// TODO get_option()から、値を取得する。
		// PriceItemHTMLUtils::makePriceItemHTMLOptionを作成して、共通化する。

		$priceItemHTMLOption->setPriceTimeLinkVisible(PriceParagraphUtils::DEFAULT_PRICE_TIME_LINK_VISIBLE);
		$priceItemHTMLOption->setPriceFooterText(PriceParagraphUtils::DEFAULT_PRICE_TIME_FOOTER_TEXT);

		return $priceItemHTMLOption;
	}
}
