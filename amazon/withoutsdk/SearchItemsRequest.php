<?php

namespace goodsmemo\amazon\withoutsdk;

/*
 * payload用検索情報
 * 参考：https://webservices.amazon.com/paapi5/documentation/without-sdk.html
 */
class SearchItemsRequest {
	public $PartnerType;
	public $PartnerTag;
	public $Keywords;
	public $SearchIndex;
	public $Resources;
}