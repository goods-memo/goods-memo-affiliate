<?php

namespace goodsmemo\rakuten;

use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\ItemHTMLUtils;
use goodsmemo\item\html\ImageItemHTMLOption;
use goodsmemo\item\html\PriceItemHTMLOption;
use goodsmemo\item\html\ReviewItemHTMLOptionUtils;
use goodsmemo\option\rakuten\RakutenSettingSection;
use goodsmemo\option\rakuten\ItemHTMLParagraphUtils;
use goodsmemo\option\rakuten\ImageParagraphUtils;
use goodsmemo\option\rakuten\PriceParagraphUtils;
use goodsmemo\option\rakuten\ReviewParagraphUtils;
use goodsmemo\shortcode\ShortcodeAttribute;

require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "item/html/ImageItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/PriceItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLOptionUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";
require_once GOODS_MEMO_DIR . "option/rakuten/ItemHTMLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/ImageParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/PriceParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/ReviewParagraphUtils.php";
require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttribute.php";

class RakutenItemHTMLOptionUtils
{

	public static function makeItemHTMLOption($optionMap, ShortcodeAttribute $shortcodeAttribute): ItemHTMLOption
	{

		$option = new ItemHTMLOption();

		// TODO get_option()から、値を取得する。

		$option->setIdPrefix(RakutenSettingSection::ID_PREFIX);

		ItemHTMLUtils::setNumberToDisplayTo(
			$option,
			$shortcodeAttribute,
			ItemHTMLParagraphUtils::DEFAULT_NUMBER_TO_DISPLAY
		);

		$titleLengthOfOptionMap = $optionMap[ItemHTMLParagraphUtils::TITLE_LENGTH_ID];
		ItemHTMLUtils::setTitleLengthTo($option, $shortcodeAttribute, $titleLengthOfOptionMap);

		$imageItemHTMLOption = RakutenItemHTMLOptionUtils::makeImageItemHTMLOption($optionMap);
		$option->setImageItemHTMLOption($imageItemHTMLOption);

		$priceItemHTMLOption = RakutenItemHTMLOptionUtils::makePriceItemHTMLOption($optionMap);
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

	private static function makeImageItemHTMLOption($optionMap): ImageItemHTMLOption
	{

		$imageItemHTMLOption = new ImageItemHTMLOption();

		// TODO get_option()から、値を取得する。
		$imageItemHTMLOption->setImageWidth(ImageParagraphUtils::DEFAULT_MEDIUM_IMAGE_WIDTH);
		$imageItemHTMLOption->setImageHeight(ImageParagraphUtils::DEFAULT_MEDIUM_IMAGE_HEIGHT);

		return $imageItemHTMLOption;
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
