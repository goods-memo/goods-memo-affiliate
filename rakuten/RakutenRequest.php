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
		$parameterMap["accessKey"] = $commonParameter->getAccessKey(); //GETパラメータを使う場合
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
		$siteURL = home_url();

		$headersMap = array(
			//400 Bad Requestエラーになる。解決できなかった
			//ヘッダー方式。URLに機密情報漏洩なし
			//'Authorization' => 'Bearer ' . $commonParameter->getAccessKey(),

			//403(REQUEST_CONTEXT_BODY_HTTP_REFERRER_MISSING)エラーを防ぐため、
			//OriginとRefererを設定する。Refererだけだと、403エラーが発生した
			'Origin' => $siteURL,
			'Referer' => $siteURL . '/'
		);

		$requestArguments =
			array(
				'headers' => $headersMap,

				// $timeout = 5 の場合、テスト用ページでタイムアウトエラーになった。
				// 例：cURL error 28: Operation timed out after 0 milliseconds with 0 out of 0 bytes received.
				'timeout' => 15
			);

		$response = HTTPRequest::getContents($requestURL, $requestArguments);

		return $response;
	}
}
