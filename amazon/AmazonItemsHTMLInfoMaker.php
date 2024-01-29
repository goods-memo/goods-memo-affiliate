<?php

namespace goodsmemo\amazon;

use goodsmemo\item\ItemsHTMLInfoMaker;
use goodsmemo\network\URLInfo;
use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\amazon\ProductTypeOption;
use goodsmemo\amazon\AmazonRequest;
use goodsmemo\amazon\AmazonResponse;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "item/ItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/ProductTypeOption.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonRequest.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonResponse.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

class AmazonItemsHTMLInfoMaker implements ItemsHTMLInfoMaker
{
	private $commonParameter;
	private $restParameter;
	private $productTypeOption;

	public function __construct(
		CommonRESTParameter $commonParameter,
		RESTParameter $restParameter,
		ProductTypeOption $productTypeOption
	) {
		$this->commonParameter = $commonParameter;
		$this->restParameter = $restParameter;
		$this->productTypeOption = $productTypeOption;
	}

	public function requestItemSearch(URLInfo $urlInfo)
	{
		$response = AmazonRequest::requestSearchIndex($urlInfo, $this->commonParameter, $this->restParameter);
		return $response;
	}

	public function makeItemArray($response)
	{
		$adultProductEnable = $this->productTypeOption->getAdultProductEnabled();
		$itemArray = AmazonResponse::makeItemArray($response, $adultProductEnable);

		return $itemArray;
	}

	public function makeUniqueText(int $cacheExpirationInSeconds)
	{
		$operation = $this->restParameter->getOperation();
		$searchIndex = $this->restParameter->getSearchIndex();

		$searchItemsResourcesArray = $this->restParameter->getSearchItemsResources();
		$searchItemsResourcesText = implode($searchItemsResourcesArray); // 配列から文字列を作る

		$keyword = $this->restParameter->getKeyword();

		$uniqueText = AmazonSettingSection::ID_PREFIX . $operation . $searchIndex .
			$searchItemsResourcesText . $keyword . $cacheExpirationInSeconds;
		return $uniqueText;
	}
}
