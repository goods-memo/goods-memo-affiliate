<?php

namespace goodsmemo\rakuten;

use goodsmemo\item\ItemsHTMLInfoMaker;
use goodsmemo\item\html\ImageItemHTMLOption;
use goodsmemo\network\URLInfo;
use goodsmemo\rakuten\CommonRESTParameter;
use goodsmemo\rakuten\RESTParameter;
use goodsmemo\rakuten\SearchOption;
use goodsmemo\rakuten\RakutenRequest;
use goodsmemo\rakuten\RakutenResponse;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "item/ItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "item/html/ImageItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "rakuten/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/RESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/SearchOption.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenRequest.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenResponse.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

class RakutenItemsHTMLInfoMaker implements ItemsHTMLInfoMaker
{
	private $commonParameter;
	private $restParameter;
	private $searchOption;
	private $imageItemHTMLOption;

	public function __construct(
		CommonRESTParameter $commonParameter,
		RESTParameter $restParameter,
		SearchOption $searchOption,
		ImageItemHTMLOption $imageItemHTMLOption
	) {
		$this->commonParameter = $commonParameter;
		$this->restParameter = $restParameter;
		$this->searchOption = $searchOption;
		$this->imageItemHTMLOption = $imageItemHTMLOption;
	}

	public function requestItemSearch(URLInfo $urlInfo)
	{
		$response = RakutenRequest::requestIchibaItemSearch($urlInfo, $this->commonParameter, $this->restParameter);
		return $response;
	}

	public function makeItemArray($response)
	{
		$itemArray = RakutenResponse::makeItemArray($response, $this->imageItemHTMLOption);
		return $itemArray;
	}

	public function makeUniqueText(int $cacheExpirationInSeconds)
	{
		$operation = $this->searchOption->getOperation();
		$keyword = $this->restParameter->getKeyword();

		$uniqueText = RakutenSettingSection::ID_PREFIX . $operation . $keyword . $cacheExpirationInSeconds;
		return $uniqueText;
	}
}
