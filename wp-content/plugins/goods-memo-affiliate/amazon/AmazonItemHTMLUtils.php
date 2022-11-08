<?php

namespace goodsmemo\amazon;

use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\ItemHTMLUtils;
use goodsmemo\item\html\PriceItemHTMLOption;
use goodsmemo\item\html\ReviewItemHTMLUtils;
use goodsmemo\option\amazon\AmazonSettingSection;
use goodsmemo\option\amazon\ItemHTMLParagraphUtils;
use goodsmemo\option\amazon\PriceParagraphUtils;
use goodsmemo\option\amazon\ReviewParagraphUtils;
use goodsmemo\shortcode\ShortcodeAttribute;

require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "item/html/PriceItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";
require_once GOODS_MEMO_DIR . "option/amazon/ItemHTMLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/PriceParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/ReviewParagraphUtils.php";
require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttribute.php";

class AmazonItemHTMLUtils {

	public static function makeItemHTMLOption($optionMap, ShortcodeAttribute $shortcodeAttribute): ItemHTMLOption {

		$option = new ItemHTMLOption ();

		// TODO get_option()から、値を取得する。

		$option->setIdPrefix ( AmazonSettingSection::ID_PREFIX );

		ItemHTMLUtils::setNumberToDisplayTo ( $option, $shortcodeAttribute, ItemHTMLParagraphUtils::DEFAULT_NUMBER_TO_DISPLAY );

		$titleLengthOfOptionMap = $optionMap [ItemHTMLParagraphUtils::TITLE_LENGTH_ID];
		ItemHTMLUtils::setTitleLengthTo ( $option, $shortcodeAttribute, $titleLengthOfOptionMap );

		$priceItemHTMLOption = AmazonItemHTMLUtils::makePriceItemHTMLOption ( $optionMap );
		$option->setPriceItemHTMLOption ( $priceItemHTMLOption );

		$reviewItemHTMLOption = ReviewItemHTMLUtils::makeReviewItemHTMLOption ( //
		$optionMap, $shortcodeAttribute->getItemReviewLength (), //
		ReviewParagraphUtils::EDITORIAL_REVIEW_LENGTH_ID, //
		ReviewParagraphUtils::ARRAY_OF_STRING_TO_DELETE_ID, //
		ReviewParagraphUtils::ARRAY_OF_STRING_TO_BREAK_ID );
		$option->setReviewItemHTMLOption ( $reviewItemHTMLOption );

		$cacheExpirationInSeconds = $optionMap [ItemHTMLParagraphUtils::CACHE_EXPIRATION_IN_SECONDS_ID];
		$option->setCacheExpirationInSeconds ( $cacheExpirationInSeconds );

		return $option;
	}

	private static function makePriceItemHTMLOption($optionMap): PriceItemHTMLOption {

		$priceItemHTMLOption = new PriceItemHTMLOption ();

		// TODO get_option()から、値を取得する。
		// PriceItemHTMLUtils::makePriceItemHTMLOptionを作成して、共通化する。

		$priceItemHTMLOption->setPriceTimeLinkVisible ( PriceParagraphUtils::DEFAULT_PRICE_TIME_LINK_VISIBLE );
		$priceItemHTMLOption->setPriceFooterText ( PriceParagraphUtils::DEFAULT_PRICE_TIME_FOOTER_TEXT );

		return $priceItemHTMLOption;
	}
}
