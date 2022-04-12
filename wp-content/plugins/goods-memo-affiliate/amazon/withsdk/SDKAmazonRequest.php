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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301 USA
 */
namespace goodsmemo\amazon\withsdk;

use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\network\URLInfo;
use goodsmemo\exception\HttpRequestException;
// PA-API v5 SDK
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\api\DefaultApi;
use Amazon\ProductAdvertisingAPI\v1\ApiException;
use Amazon\ProductAdvertisingAPI\v1\Configuration;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsRequest;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\PartnerType;
use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\ProductAdvertisingAPIClientException;

require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";
// PA-API v5 SDK
require_once (__DIR__ . '/sdk/vendor/autoload.php');

// change path as needed

/**
 * Description of AmazonRequest
 *
 * @author Goods Memo
 */
class SDKAmazonRequest {

	public static function requestSearchIndex(URLInfo $urlInfo, CommonRESTParameter $commonParameter, RESTParameter $restParameter, int $itemCount) {

		if ($itemCount <= 0) {
			return NULL; // 表示する件数が０件なので、商品情報なしとする。
		}

		// Request initialization
		/*
		 * Specify the category in which search request is to be made
		 * For more details, refer: https://webservices.amazon.com/paapi5/documentation/use-cases/organization-of-items-on-amazon/search-index.html
		 */
		$partnerTag = $commonParameter->getAssociateTag (); // Please add your partner tag (store/tracking id) here
		$searchIndex = $restParameter->getSearchIndex ();
		$keyword = $restParameter->getKeyword (); // Specify keywords
		/*
		 * Choose resources you want from SearchItemsResource enum
		 * For more details, refer: https://webservices.amazon.com/paapi5/documentation/search-items.html#resources-parameter
		 */
		$resources = $restParameter->getSearchItemsResources ();

		// Forming the request
		$searchItemsRequest = new SearchItemsRequest ();
		$searchItemsRequest->setPartnerTag ( $partnerTag );
		$searchItemsRequest->setPartnerType ( PartnerType::ASSOCIATES );
		$searchItemsRequest->setSearchIndex ( $searchIndex );
		$searchItemsRequest->setKeywords ( $keyword );
		$searchItemsRequest->setItemCount ( $itemCount );
		$searchItemsRequest->setResources ( $resources );

		// Validating request
		$invalidPropertyList = $searchItemsRequest->listInvalidProperties ();
		$length = count ( $invalidPropertyList );
		if ($length > 0) {
			$errorMessage = "Error forming the request" . PHP_EOL;
			foreach ( $invalidPropertyList as $invalidProperty ) {
				$errorMessage .= $invalidProperty . PHP_EOL;
			}
			throw new HttpRequestException ( $errorMessage );
		}

		$config = new Configuration ();
		/*
		 * Add your credentials
		 * Please add your access key here
		 */
		$config->setAccessKey ( $commonParameter->getAccessKey () );
		// Please add your secret key here
		$config->setSecretKey ( $commonParameter->getSecretKey () );
		/*
		 * PAAPI host and region to which you want to send request
		 * For more details refer: https://webservices.amazon.com/paapi5/documentation/common-request-parameters.html#host-and-region
		 */
		$config->setHost ( $urlInfo->getHostname () );
		$config->setRegion ( $commonParameter->getRegion () );

		$apiInstance = new DefaultApi(
			/*
			 * If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
			 * This is optional, `GuzzleHttp\Client` will be used as default.
			 */
			new \GuzzleHttp\Client (), $config );

		$searchItemsResponse = SDKAmazonRequest::getSearchItems ( $apiInstance, $searchItemsRequest );
		return $searchItemsResponse;
	}

	private static function getSearchItems(DefaultApi $apiInstance, SearchItemsRequest $searchItemsRequest, $retryCount = 3) {

		$lastHttpRequestException;
		for($i = 0; $i < $retryCount; $i ++) { // リトライ回数：３回
			if ($i >= 1) {
				sleep ( 1 ); // 再試行の待ち時間（１秒）
			}

			try {
				$searchItemsResponse = SDKAmazonRequest::getSearchItemsResponse ( $apiInstance, $searchItemsRequest );
				return $searchItemsResponse;
			} catch ( HttpRequestException $ex ) {
				$lastHttpRequestException = $ex;
			}
		}

		throw $lastHttpRequestException;
	}

	private static function getSearchItemsResponse(DefaultApi $apiInstance, SearchItemsRequest $searchItemsRequest) {

		// Sending the request
		try {
			$searchItemsResponse = $apiInstance->searchItems ( $searchItemsRequest );

			// echo 'API called successfully', PHP_EOL;
			// echo 'Complete Response: ', $searchItemsResponse, PHP_EOL;
			if ($searchItemsResponse->getErrors () != NULL and $searchItemsResponse->getErrors () [0] != NULL) {
				// Error message: No results found for your request.この時 $searchItemsResponse->getSearchResult() == NULL。//var_dump($searchItemsResponse);
				// 検索結果0件の場合、ここに来る。正常処理なので、throw new HttpRequestException()しなくて良い。
				$errorCodeText = $searchItemsResponse->getErrors () [0]->getCode (); // string型。例："NoResults"という文字列が取得された。
				$errorMessage = 'Printing Errors:' . PHP_EOL . 'Printing first error object from list of errors' . PHP_EOL;
				$errorMessage .= 'Error message: ' . $searchItemsResponse->getErrors () [0]->getMessage () . PHP_EOL;
				$errorMessage .= 'Error CodeText: ' . $errorCodeText . PHP_EOL;
				// var_dump($errorMessage);
			}

			return $searchItemsResponse;
		} catch ( ApiException $exception ) {

			$errorMessage = "Error calling PA-API 5.0!" . PHP_EOL;
			$errorMessage .= "Error Message: " . $exception->getMessage () . PHP_EOL;
			$errorMessage .= "Error host: " . $apiInstance->getConfig ()->getHost () . PHP_EOL;

			if ($exception->getResponseObject () instanceof ProductAdvertisingAPIClientException) {
				$errors = $exception->getResponseObject ()->getErrors ();
				foreach ( $errors as $error ) {
					$errorMessage .= "Error Type: " . $error->getCode () . PHP_EOL;
					$errorMessage .= "Error Message: " . $error->getMessage () . PHP_EOL;
				}
			} else {
				$errorMessage .= "Error response body: " . $exception->getResponseBody () . PHP_EOL;
			}

			$errorCode = $exception->getCode ();
			throw new HttpRequestException ( $errorMessage, $errorCode );
		}
		// Shortcode.phpで受け取るようにした。
		// catch (Exception $exception) {
		// $errorMessage = "Error Message: " . $exception->getMessage() . PHP_EOL;
		// }
	}
}
