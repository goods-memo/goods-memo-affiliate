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

/**
 * Description of RakutenOptionUtils
 *
 * @author Goods Memo
 */
class RakutenOptionUtils {

    public static function makeCommonRESTParameter($optionMap): CommonRESTParameter {

	$parameter = new CommonRESTParameter();

	$applicationId = $optionMap[CommonRESTParagraphUtils::APPLICATION_ID_ID]; //var_dump($accessKey);
	$parameter->setApplicationId($applicationId);

	$affiliateId = $optionMap[CommonRESTParagraphUtils::AFFILIATE_ID_ID]; //var_dump($associateTag);
	$parameter->setAffiliateId($affiliateId);

	return $parameter;
    }

    public static function makeRESTParameter($optionMap, $keyword): RESTParameter {

	$restParameter = new RESTParameter();

	//TODO get_option()から、値を取得する。

	$restParameter->setImageFlag(RESTParagraphUtils::EXISTENCE_IMAGE_FLAG);
	$restParameter->setKeyword($keyword);

	return $restParameter;
    }

    public static function makeSearchOption($optionMap, $operationOfShortcode): SearchOption {

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
