<?php

/*
 * Copyright (C) 2019 Goods Memo.
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

namespace goodsmemo\amazon\widget;

use goodsmemo\amazon\CommonRESTParameter;
use goodsmemo\amazon\RESTParameter;
use goodsmemo\amazon\AmazonItemsHTMLInfoMaker;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\exception\FileNotFoundException;

require_once GOODS_MEMO_DIR . "amazon/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/RESTParameter.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "exception/FileNotFoundException.php";

/**
 * Description of SearchWidget
 *
 * @author Goods Memo
 */
class SearchWidget {

	const SEARCH_WIDGET_PREFIX = "search_w";

	public static function makeHtmlOfSearchWidget(
	CommonRESTParameter $commonParameter, RESTParameter $restParameter) {

		$filename = __DIR__ . "/SearchWidget.html";
		$widgetHtml = file_get_contents($filename); //$widgetHtml = false;
		if ($widgetHtml === false) {
			$errorMessage = "検索ウィジェットファイルの読み込み失敗：filename=[" . $filename . "]";
			throw new FileNotFoundException($errorMessage);
		}

		$searchArray = array("GOODS_MEMO_ASSOCIATE_TAG", "GOODS_MEMO_SEARCH_KEYWORD");

		$associateTag = $commonParameter->getAssociateTag();
		$keyword = $restParameter->getKeyword();
		$replaceArray = array($associateTag, $keyword);

		$newWidgetHtml = str_replace($searchArray, $replaceArray, $widgetHtml);

		return $newWidgetHtml;
	}

	public static function getSearchWidgetCache(ItemHTMLOption $itemHTMLOption, AmazonItemsHTMLInfoMaker $itemsHTMLInfoMaker) {

		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds();
		if ($cacheExpirationInSeconds <= 0) {
			return false;
		}

		$transientID = SearchWidget::makeTransientID($itemHTMLOption, $itemsHTMLInfoMaker);
		$searchWidgetCache = get_transient($transientID);
		//var_dump($searchWidgetCache);

		return $searchWidgetCache;
	}

	public static function setSearchWidgetCache($widgetHtml, ItemHTMLOption $itemHTMLOption, AmazonItemsHTMLInfoMaker $itemsHTMLInfoMaker) {

		$transientID = SearchWidget::makeTransientID($itemHTMLOption, $itemsHTMLInfoMaker);
		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds();

		//一時的にデータベースに検索ウィジェットHTMLを保存する。有効期限後、削除される。
		set_transient($transientID, $widgetHtml, $cacheExpirationInSeconds);
		//var_dump($newWidgetHtml);
	}

	private static function makeTransientID(ItemHTMLOption $itemHTMLOption, AmazonItemsHTMLInfoMaker $itemsHTMLInfoMaker) {

		$uniqueText = $itemsHTMLInfoMaker->makeUniqueText($itemHTMLOption);
		$uniqueTextOfWidget = SearchWidget::SEARCH_WIDGET_PREFIX . $uniqueText;

		//$transientID：キャッシュされるデータにつけるユニークな識別子。長さ 45 文字以下であること。
		//md5() ：32 文字の 16 進数からなるハッシュを返します。
		$transientID = GOODS_MEMO_PREFIX . md5($uniqueTextOfWidget); //var_dump($transientID);

		return $transientID;
	}

}
