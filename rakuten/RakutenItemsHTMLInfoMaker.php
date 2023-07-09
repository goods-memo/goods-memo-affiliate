<?php

namespace goodsmemo\rakuten;

use goodsmemo\item\ItemsHTMLInfoMaker;
use goodsmemo\network\URLInfo;
use goodsmemo\rakuten\CommonRESTParameter;
use goodsmemo\rakuten\RESTParameter;
use goodsmemo\rakuten\SearchOption;
use goodsmemo\rakuten\RakutenRequest;
use goodsmemo\rakuten\RakutenResponse;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "item/ItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "rakuten/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/RESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/SearchOption.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenRequest.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenResponse.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

class RakutenItemsHTMLInfoMaker implements ItemsHTMLInfoMaker
{
	private $commonParameter;
	private $restParameter;
	private $searchOption;

	public function __construct(
		CommonRESTParameter $commonParameter,
		RESTParameter $restParameter,
		SearchOption $searchOption
	) {

		$this->commonParameter = $commonParameter;
		$this->restParameter = $restParameter;
		$this->searchOption = $searchOption;
	}

	public function requestItemSearch(URLInfo $urlInfo, int $itemCount)
	{

		$response = RakutenRequest::requestIchibaItemSearch($urlInfo, $this->commonParameter, $this->restParameter);
		return $response;
	}

	public function makeItemArray($response, ItemHTMLOption $itemHTMLOption)
	{

		$itemArray = RakutenResponse::makeItemArray($response, $itemHTMLOption); // var_dump($itemArray);
		return $itemArray;
	}

	public function makeUniqueText(ItemHTMLOption $itemHTMLOption)
	{

		$operation = $this->searchOption->getOperation();
		$keyword = $this->restParameter->getKeyword();
		$numberToDisplay = $itemHTMLOption->getNumberToDisplay();
		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds();

		$uniqueText = RakutenSettingSection::ID_PREFIX . $operation . $keyword . $numberToDisplay . $cacheExpirationInSeconds;
		return $uniqueText;
	}
}
