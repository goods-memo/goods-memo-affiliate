<?php

namespace goodsmemo\rakuten;

use goodsmemo\rakuten\CommonRESTParameter;
use goodsmemo\rakuten\RESTParameter;
use goodsmemo\rakuten\SearchOption;
use goodsmemo\option\rakuten\CommonRESTParagraphUtils;
use goodsmemo\option\rakuten\RESTParagraphUtils;
use goodsmemo\option\rakuten\SearchParagraphUtils;

require_once GOODS_MEMO_DIR . "rakuten/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/RESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/SearchOption.php";
require_once GOODS_MEMO_DIR . "option/rakuten/CommonRESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/SearchParagraphUtils.php";

class RakutenOptionUtils
{

	public static function makeCommonRESTParameter($optionMap): CommonRESTParameter
	{

		$parameter = new CommonRESTParameter();

		$applicationId = $optionMap[CommonRESTParagraphUtils::APPLICATION_ID_ID];
		$parameter->setApplicationId($applicationId);

		$accessKey = $optionMap[CommonRESTParagraphUtils::ACCESS_KEY_ID];
		$parameter->setAccessKey($accessKey);

		$affiliateId = $optionMap[CommonRESTParagraphUtils::AFFILIATE_ID_ID];
		$parameter->setAffiliateId($affiliateId);

		return $parameter;
	}

	public static function makeRESTParameter($optionMap, $keyword): RESTParameter
	{

		$restParameter = new RESTParameter();

		//TODO get_option()から、値を取得する。

		$restParameter->setImageFlag(RESTParagraphUtils::EXISTENCE_IMAGE_FLAG);
		$restParameter->setKeyword($keyword);

		return $restParameter;
	}

	public static function makeSearchOption($optionMap, $operationOfShortcode): SearchOption
	{

		$searchOption = new SearchOption();

		//TODO get_option()から、値を取得する。

		if ($operationOfShortcode) {
			$searchOption->setOperation($operationOfShortcode);
		} else {
			$searchOption->setOperation(SearchParagraphUtils::ICHIBA_ITEM_SEARCH_OPERATION);
		}

		return $searchOption;
	}
}
