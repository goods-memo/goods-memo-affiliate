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

/**
 * Description of AmazonItemsHTMLInfoMaker
 *
 * @author Goods Memo
 */
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
		$itemArray = AmazonResponse::makeItemArray ( $response, $numberToDisplay, $this->productTypeOption );
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
