<?php

namespace goodsmemo\amazon;

use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\amazon\withoutsdk\SearchIndexRequest;
use goodsmemo\network\URLInfo;
use goodsmemo\exception\HttpRequestException;

require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/withoutsdk/SearchIndexRequest.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";

class AmazonRequest
{

	public static function requestSearchIndex(
		URLInfo $urlInfo,
		CommonRESTParameter $commonParameter,
		RESTParameter $restParameter,
		$retryCount = 1
	) {
		$partnerTag = $commonParameter->getAssociateTag();
		$keyword = $restParameter->getKeyword();
		$searchIndex = $restParameter->getSearchIndex();
		$resources = $restParameter->getSearchItemsResources();
		$hostname = $urlInfo->getHostname();
		$accessKey = $commonParameter->getAccessKey();
		$secretKey = $commonParameter->getSecretKey();
		$regionName = $commonParameter->getRegion();

		$lastHttpRequestException;
		for ($i = 0; $i < $retryCount; $i++) { // 例：リトライ回数：2回 //TODO 設定画面で指定する

			if ($i >= 1) {
				sleep(1); // 再試行の待ち時間（1秒）
			}

			try {
				/*
				 * ここでSDKあり・なしの分岐処理をするかもしれない。
				 * SDKAmazonRequest::requestSearchIndex()
				 */

				$searchItemsResponse = SearchIndexRequest::request(
					$partnerTag,
					$keyword,
					$searchIndex,
					$resources,
					$hostname,
					$accessKey,
					$secretKey,
					$regionName
				);

				return $searchItemsResponse;
			} catch (HttpRequestException $ex) {
				$lastHttpRequestException = $ex;
			}
		}

		throw $lastHttpRequestException;
	}
}
