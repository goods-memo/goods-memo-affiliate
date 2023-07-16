<?php

namespace goodsmemo\rakuten;

use goodsmemo\rakuten\CommonRESTParameter;
use goodsmemo\rakuten\RESTParameter;
use goodsmemo\network\HTTPRequest;
use goodsmemo\network\URLInfo;

require_once GOODS_MEMO_DIR . "rakuten/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/RESTParameter.php";
require_once GOODS_MEMO_DIR . "network/HTTPRequest.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";

class RakutenRequest
{

	public static function requestIchibaItemSearch(URLInfo $urlInfo, CommonRESTParameter $commonParameter, RESTParameter $restParameter)
	{

		$parameterMap = array();

		$parameterMap["applicationId"] = $commonParameter->getApplicationId();
		$parameterMap["affiliateId"] = $commonParameter->getAffiliateId();

		$parameterMap["imageFlag"] = $restParameter->getImageFlag();
		$parameterMap["keyword"] = $restParameter->getKeyword();

		$queryString = HTTPRequest::makeQueryString($parameterMap);

		$hostname = $urlInfo->getHostname();
		$path = $urlInfo->getPath();

		$requestURL = 'https://' . $hostname . '/' . $path . '?' . $queryString;
		$response = HTTPRequest::getContents($requestURL);

		return $response;
	}
}
