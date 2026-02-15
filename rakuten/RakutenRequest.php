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
		$parameterMap["accessKey"] = $commonParameter->getAccessKey();
		$parameterMap["affiliateId"] = $commonParameter->getAffiliateId();

		$parameterMap["imageFlag"] = $restParameter->getImageFlag();
		$parameterMap["keyword"] = $restParameter->getKeyword();

		$queryString = HTTPRequest::makeQueryString($parameterMap);

		$hostname = $urlInfo->getHostname();
		$path = $urlInfo->getPath();

		$requestURL = 'https://' . $hostname . '/' . $path . '?' . $queryString;

		//プラグインを使用しているWordPressサイトのホームURL（トップページURL）
		//楽天ウェブサービスのアプリ登録 許可されたWebサイトのドメインと同じであること
		//ローカル環境のドメインも、登録する。例：wptest.local
		$referer = home_url();

		$requestArguments =
			array(
				'headers' => array(
					//403エラーを防ぐため、OriginとRefererを設定する。Refererだけだと、403エラーが発生した
					'Origin' => $referer,
					'Referer' => $referer
				),

				// $timeout = 5 の場合、テスト用ページでタイムアウトエラーになった。
				// 例：cURL error 28: Operation timed out after 0 milliseconds with 0 out of 0 bytes received.
				'timeout' => 15
			);

		$response = HTTPRequest::getContents($requestURL, $requestArguments);

		return $response;
	}
}
