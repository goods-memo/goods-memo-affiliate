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
use goodsmemo\network\HTTPRequest;
use goodsmemo\network\URLInfo;

require_once GOODS_MEMO_DIR . "rakuten/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/RESTParameter.php";
require_once GOODS_MEMO_DIR . "network/HTTPRequest.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";

/**
 * Description of RakutenRequest
 *
 * @author Goods Memo
 */
class RakutenRequest {

    public static function requestIchibaItemSearch(URLInfo $urlInfo, CommonRESTParameter $commonParameter, RESTParameter $restParameter) {

	$parameterMap = array();

	$parameterMap["applicationId"] = $commonParameter->getApplicationId();
	$parameterMap["affiliateId"] = $commonParameter->getAffiliateId();

	$parameterMap["imageFlag"] = $restParameter->getImageFlag();
	$parameterMap["keyword"] = $restParameter->getKeyword();

	$queryString = HTTPRequest::makeQueryString($parameterMap);

	$hostname = $urlInfo->getHostname();
	$path = $urlInfo->getPath();

	$requestURL = 'https://' . $hostname . '/' . $path . '?' . $queryString; //var_dump($requestURL);
	$response = HTTPRequest::getContents($requestURL);

	return $response;
    }

}
