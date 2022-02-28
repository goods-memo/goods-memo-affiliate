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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

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

/**
 * Description of RakutenItemsHTMLInfoMaker
 *
 * @author Goods Memo
 */
class RakutenItemsHTMLInfoMaker implements ItemsHTMLInfoMaker {

	private $commonParameter;
	private $restParameter;
	private $searchOption;

	public function __construct(CommonRESTParameter $commonParameter, RESTParameter $restParameter,
		SearchOption $searchOption) {

		$this->commonParameter = $commonParameter;
		$this->restParameter = $restParameter;
		$this->searchOption = $searchOption;
	}

	public function requestItemSearch(URLInfo $urlInfo, int $itemCount) {

		$response = RakutenRequest::requestIchibaItemSearch($urlInfo, $this->commonParameter, $this->restParameter);
		return $response;
	}

	public function makeItemArray($response, ItemHTMLOption $itemHTMLOption) {

		$itemArray = RakutenResponse::makeItemArray($response, $itemHTMLOption); // var_dump($itemArray);
		return $itemArray;
	}

	public function makeUniqueText(ItemHTMLOption $itemHTMLOption) {

		$operation = $this->searchOption->getOperation();
		$keyword = $this->restParameter->getKeyword();
		$numberToDisplay = $itemHTMLOption->getNumberToDisplay();
		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds();

		$uniqueText = RakutenSettingSection::ID_PREFIX . $operation . $keyword . $numberToDisplay . $cacheExpirationInSeconds;
		return $uniqueText;
	}

}
