<?php

namespace goodsmemo\amazon;

use goodsmemo\item\ItemsHTMLInfoMaker;
use goodsmemo\network\URLInfo;
use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\amazon\ProductTypeOption;
use goodsmemo\amazon\AmazonRequest;
use goodsmemo\amazon\AmazonResponse;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "item/ItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/ProductTypeOption.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonRequest.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonResponse.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

class AmazonItemsHTMLInfoMaker implements ItemsHTMLInfoMaker {
	private $commonParameter;
	private $restParameter;
	private $productTypeOption;

	public function __construct(CommonRESTParameter $commonParameter, RESTParameter $restParameter, ProductTypeOption $productTypeOption) {

		$this->commonParameter = $commonParameter;
		$this->restParameter = $restParameter;
		$this->productTypeOption = $productTypeOption;
	}

	public function requestItemSearch(URLInfo $urlInfo, int $itemCount) {

		$response = AmazonRequest::requestSearchIndex ( $urlInfo, $this->commonParameter, $this->restParameter, $itemCount );
		return $response;
	}

	public function makeItemArray($response, ItemHTMLOption $itemHTMLOption) {

		$numberToDisplay = $itemHTMLOption->getNumberToDisplay ();
		$adultProductEnable = $this->productTypeOption->getAdultProductEnabled ();

		$itemArray = AmazonResponse::makeItemArray ( $response, $numberToDisplay, $adultProductEnable );
		return $itemArray;
	}

	public function makeUniqueText(ItemHTMLOption $itemHTMLOption) {

		$operation = $this->restParameter->getOperation ();
		$searchIndex = $this->restParameter->getSearchIndex ();
		$responseGroup = $this->restParameter->getSearchItemsResources ();
		$keyword = $this->restParameter->getKeyword ();
		$numberToDisplay = $itemHTMLOption->getNumberToDisplay ();
		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds ();

		$uniqueText = AmazonSettingSection::ID_PREFIX . $operation . $searchIndex . $responseGroup . $keyword . $numberToDisplay . $cacheExpirationInSeconds;
		return $uniqueText;
	}
}
