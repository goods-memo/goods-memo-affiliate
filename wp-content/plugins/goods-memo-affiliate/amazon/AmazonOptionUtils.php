<?php

namespace goodsmemo\amazon;

use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\amazon\ProductTypeOption;
use goodsmemo\amazon\displayhtml\DisplayHTMLPAAPINotAvailableOption;
use goodsmemo\option\amazon\CommonRESTParagraphUtils;
use goodsmemo\option\amazon\RESTParagraphUtils;
use goodsmemo\option\amazon\ProductTypeParagraph;
use goodsmemo\option\amazon\ProductTypeParagraphUtils;
use goodsmemo\option\amazon\DisplayHTMLPAAPINotAvailableParagraph;
use goodsmemo\option\amazon\DisplayHTMLPAAPINotAvailableParagraphUtils;
use goodsmemo\shortcode\ShortcodeAttribute;

require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/ProductTypeOption.php";
require_once GOODS_MEMO_DIR . "amazon/displayhtml/DisplayHTMLPAAPINotAvailableOption.php";

require_once GOODS_MEMO_DIR . "option/amazon/CommonRESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/RESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/ProductTypeParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/ProductTypeParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/DisplayHTMLPAAPINotAvailableParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/DisplayHTMLPAAPINotAvailableParagraphUtils.php";
require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttribute.php";

class AmazonOptionUtils {

	public static function makeCommonRESTParameter($optionMap): CommonRESTParameter {

		$parameter = new CommonRESTParameter ();

		$accessKey = $optionMap [CommonRESTParagraphUtils::PAA_ACCESS_KEY_ID]; // var_dump($accessKey);
		$parameter->setAccessKey ( $accessKey );

		$associateTag = $optionMap [CommonRESTParagraphUtils::PAA_ASSOCIATE_TAG_ID]; // var_dump($associateTag);
		$parameter->setAssociateTag ( $associateTag );

		$secretKey = $optionMap [CommonRESTParagraphUtils::PAA_SECRET_KEY_ID]; // var_dump($secretKey);
		$parameter->setSecretKey ( $secretKey );

		$region = $optionMap [CommonRESTParagraphUtils::PAA_REGION_ID]; // var_dump($region);
		$parameter->setRegion ( $region );

		return $parameter;
	}

	public static function makeRESTParameter($optionMap, ShortcodeAttribute $shortcodeAttribute): RESTParameter {

		$restParameter = new RESTParameter ();

		// TODO get_option()から、値を取得する。

		$operationOfShortcode = $shortcodeAttribute->getOperation ();
		if ($operationOfShortcode) {
			$restParameter->setOperation ( $operationOfShortcode );
		} else {
			$restParameter->setOperation ( RESTParagraphUtils::ITEM_SEARCH_OPERATION );
		}

		$searchIndexOfShortcode = $shortcodeAttribute->getSearchIndex ();
		if ($searchIndexOfShortcode) {
			$restParameter->setSearchIndex ( $searchIndexOfShortcode );
		} else {
			$restParameter->setSearchIndex ( RESTParagraphUtils::ALL_SEARCH_INDEX );
		}

		$searchItemsResources = json_decode ( $optionMap [RESTParagraphUtils::SEARCH_ITEMS_RESOURCES_ID], true ); // true：連想配列に変換する
		$restParameter->setSearchItemsResources ( $searchItemsResources );

		$restParameter->setKeyword ( $shortcodeAttribute->getKeyword () );

		return $restParameter;
	}

	public static function makeProductTypeOption($optionMap): ProductTypeOption {

		$productTypeOption = new ProductTypeOption ();

		// 参考：チェックボックスがチェックされていなかった場合、
		// チェックされていない状態を表す値（value=unchecked など）が送信されることはなく、
		// 値はサーバーに全く送信されません。$optionMapの要素が存在しない。
		if (isset ( $optionMap [ProductTypeParagraphUtils::ADULT_PRODUCT_ID] )) {

			$adultProductCheckedValue = $optionMap [ProductTypeParagraphUtils::ADULT_PRODUCT_ID];
			$adultProductEnabled = ($adultProductCheckedValue === ProductTypeParagraph::ADULT_PRODUCT_CHECKED_VALUE);
			$productTypeOption->setAdultProductEnabled ( $adultProductEnabled );
		}

		return $productTypeOption;
	}

	public static function makeDisplayHTMLPAAPINotAvailableOption($optionMap): DisplayHTMLPAAPINotAvailableOption {

		$displayHTMLOption = new DisplayHTMLPAAPINotAvailableOption ();

		$convertedDisplayHTML = $optionMap [DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_TEXTAREA_ID];
		$displayHTML = htmlspecialchars_decode ( $convertedDisplayHTML ); // 例：HTMLタグに戻す
		$displayHTMLOption->setDisplayHTMLPAAPINotAvailable ( $displayHTML );

		// 参考：チェックボックスがチェックされていなかった場合、
		// チェックされていない状態を表す値（value=unchecked など）が送信されることはなく、
		// 値はサーバーに全く送信されません。$optionMapの要素が存在しない。
		if (isset ( $optionMap [DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_CHECKBOX_ID] )) {

			$displayHTMLCheckedValue = $optionMap [DisplayHTMLPAAPINotAvailableParagraphUtils::DISPLAY_HTML_CHECKBOX_ID];
			$displayHTMLEnabled = ($displayHTMLCheckedValue === DisplayHTMLPAAPINotAvailableParagraph::DISPLAY_HTML_CHECKED_VALUE);
			$displayHTMLOption->setDisplayHTMLPAAPINotAvailableAlwaysEnabled ( $displayHTMLEnabled );
		}

		return $displayHTMLOption;
	}
}
