<?php

namespace goodsmemo\amazon\withoutsdk;

use goodsmemo\amazon\withoutsdk\SearchItemsRequest;
use goodsmemo\exception\HttpRequestException;

require_once GOODS_MEMO_DIR . "amazon/withoutsdk/SearchItemsRequest.php";
require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";

class RequestSearchIndex {

	public static function requestSearchIndex(string $partnerTag, string $keyword, string $searchIndex, $resources, string $hostname, string $accessKey, string $secretKey, string $regionName) {

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
			throw new HttpRequestException ( "fopen Exception Occured" );
		}

		$response = @stream_get_contents ( $fp );
		if ($response === false) {
			throw new HttpRequestException ( "stream_get_contents Exception Occured" );
		}

		$jsonResponse = json_decode ( $response );

		if (property_exists ( $jsonResponse, 'Errors' )) { // $jsonResponse内にerrorが含まれる場合

			$errorCode = $jsonResponse->{'Errors'} [0]->{'Code'};
			$errorMessage = $jsonResponse->{'Errors'} [0]->{'Message'};
			throw new HttpRequestException ( $errorMessage, $errorCode );
		}

		return $jsonResponse;
	}
}