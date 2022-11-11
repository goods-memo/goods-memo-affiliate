<?php

namespace goodsmemo\amazon\withoutsdk;

use goodsmemo\amazon\withoutsdk\SearchItemsRequest;
use goodsmemo\amazon\withoutsdk\AwsV4;
use goodsmemo\exception\HttpRequestException;

require_once GOODS_MEMO_DIR . "amazon/withoutsdk/SearchItemsRequest.php";
require_once GOODS_MEMO_DIR . "amazon/withoutsdk/AwsV4.php";
require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";

class SearchIndexRequest {

	public static function request(string $partnerTag, string $keyword, string $searchIndex, $resources,
			string $hostname, string $accessKey, string $secretKey, string $regionName) {

		$searchItemRequest = new SearchItemsRequest ();
		$searchItemRequest->PartnerType = "Associates";
		// Put your Partner tag (Store/Tracking id) in place of Partner tag
		$searchItemRequest->PartnerTag = $partnerTag;
		$searchItemRequest->Keywords = $keyword;
		$searchItemRequest->SearchIndex = $searchIndex;
		$searchItemRequest->Resources = $resources;
		$host = $hostname;
		$path = "/paapi5/searchitems";
		$payload = json_encode ( $searchItemRequest );

		// Put your Access Key in place of <ACCESS_KEY> and Secret Key in place of <SECRET_KEY> in double quotes
		$awsv4 = new AwsV4 ( $accessKey, $secretKey );
		$awsv4->setRegionName ( $regionName );
		$awsv4->setServiceName ( "ProductAdvertisingAPI" );
		$awsv4->setPath ( $path );
		$awsv4->setPayload ( $payload );
		$awsv4->setRequestMethod ( "POST" );
		$awsv4->addHeader ( 'content-encoding', 'amz-1.0' );
		$awsv4->addHeader ( 'content-type', 'application/json; charset=utf-8' );
		$awsv4->addHeader ( 'host', $host );
		$awsv4->addHeader ( 'x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems' );
		$headers = $awsv4->getHeaders ();
		$headerString = "";
		foreach ( $headers as $key => $value ) {
			$headerString .= $key . ': ' . $value . "\r\n";
		}
		$params = array (
				'http' => array (
						'header' => $headerString,
						'method' => 'POST',
						'content' => $payload
				)
		);
		$stream = stream_context_create ( $params );

		$fp = @fopen ( 'https://' . $host . $path, 'rb', false, $stream );

		if (! $fp) {
			$errorMessage = "fopen Exception Occured.";

			$httpStatus;
			if (isset ( $http_response_header )) { // $http_response_header変数は、fopen実行後、PHPが自動的に設定する。
				$httpStatus = $http_response_header [0];
			} else {
				// URLが存在しない場合、変数は未定義らしい。未定義なら、HTTP Status 404 と判断して良さそう。
				$httpStatus = "Variable http_response_header is undefined.";
			}

			$errorMessage .= "http status:" . $httpStatus;
			throw new HttpRequestException ( $errorMessage );
		}

		$response = @stream_get_contents ( $fp );
		if ($response === false) {
			throw new HttpRequestException ( "stream_get_contents Exception Occured" );
		}

		$jsonResponse = json_decode ( $response );
		if (is_null ( $jsonResponse )) {
			return NULL;
		}

		if (property_exists ( $jsonResponse, 'Errors' )) { // $jsonResponse内にerrorが含まれる場合

			// 検索結果0件の場合、ここに来る。正常処理なので、throw new HttpRequestException()しなくて良い。
			// $errorCodeText: string型。例："NoResults"という文字列が取得された。
			$errorCodeText = $jsonResponse->{'Errors'} [0]->{'Code'};
			$errorMessage = $jsonResponse->{'Errors'} [0]->{'Message'};

			// 検索結果0件以外の場合、Eclipseのデバッグでエラー内容を確認すること。
			$jsonResponse = NULL; // エラー情報を削除した

			// $errorCode=0;
			// throw new HttpRequestException ( $errorMessage, $errorCode );
		}

		return $jsonResponse;
	}
}