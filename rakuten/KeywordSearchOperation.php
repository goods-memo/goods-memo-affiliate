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

use goodsmemo\network\URLInfo;
use goodsmemo\rakuten\CommonRESTParameter;
use goodsmemo\rakuten\RESTParameter;
use goodsmemo\rakuten\SearchOption;
use goodsmemo\rakuten\RakutenItemsHTMLInfoMaker;
use goodsmemo\item\ItemSearchOperation;
use goodsmemo\item\html\ItemHTMLOption;

require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "rakuten/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/RESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/SearchOption.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "item/ItemSearchOperation.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";

/**
 * Description of RakutenKeywordSearchOperation
 *
 * @author Goods Memo
 */
class KeywordSearchOperation {

    public static function makeHTMLOfIchibaItemSearch(
    URLInfo $urlInfo, CommonRESTParameter $commonParameter, RESTParameter $restParameter, SearchOption $searchOption, ItemHTMLOption $itemHTMLOption) {

	$itemsHTMLInfoMaker = new RakutenItemsHTMLInfoMaker($commonParameter, $restParameter, $searchOption);
	$itemsHtml = ItemSearchOperation::makeItemsHTML($urlInfo, $itemHTMLOption, $itemsHTMLInfoMaker);
	return $itemsHtml;
    }

}
