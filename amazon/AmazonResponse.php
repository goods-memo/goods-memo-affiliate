<?php

namespace goodsmemo\amazon;

use goodsmemo\amazon\withoutsdk\SearchIndexResponse;

require_once GOODS_MEMO_DIR . "amazon/withoutsdk/SearchIndexResponse.php";

class AmazonResponse
{

	public static function makeItemArray($searchItemsResponse, $adultProductEnable)
	{
		/*
		 * ここでSDKあり・なしの分岐処理をするかもしれない。
		 * SDKAmazonResponse::makeItemArray()
		 */

		$itemArray = SearchIndexResponse::makeItemArray($searchItemsResponse,  $adultProductEnable);
		return $itemArray;
	}
}
