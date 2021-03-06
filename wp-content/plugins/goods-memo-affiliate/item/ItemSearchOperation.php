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

namespace goodsmemo\item;

use goodsmemo\network\URLInfo;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\ItemsHTMLInfoMaker;
use goodsmemo\item\html\ItemArrayHTMLMaking;

require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/ItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "item/html/ItemArrayHTMLMaking.php";

/**
 * Description of KeywordSearchOperation
 *
 * @author Goods Memo
 */
class ItemSearchOperation {

	public static function makeItemsHTML(
	URLInfo $urlInfo, ItemHTMLOption $itemHTMLOption, ItemsHTMLInfoMaker $itemsHTMLInfoMaker) {

		$cacheExpirationInSeconds = $itemHTMLOption->getCacheExpirationInSeconds();

		if ($cacheExpirationInSeconds <= 0) {

			$response = $itemsHTMLInfoMaker->requestItemSearch($urlInfo, $itemHTMLOption->getNumberToDisplay());
			$itemArray = $itemsHTMLInfoMaker->makeItemArray($response, $itemHTMLOption); // var_dump($itemArray);
			$itemsHtml = ItemArrayHTMLMaking::makeItemArrayHTML($itemArray, $itemHTMLOption);
			return $itemsHtml;
		}

		$itemArray = NULL;

		$uniqueText = $itemsHTMLInfoMaker->makeUniqueText($itemHTMLOption);
		//$transientID：キャッシュされるデータにつけるユニークな識別子。長さ 45 文字以下であること。
		//md5() ：32 文字の 16 進数からなるハッシュを返します。
		$transientID = GOODS_MEMO_PREFIX . md5($uniqueText); //var_dump($transientID);

		$transientItemArrayCache = get_transient($transientID);
		if ($transientItemArrayCache !== FALSE) {

			$binaryItemArray = base64_decode($transientItemArrayCache); //var_dump($binaryItemArray);
			if ($binaryItemArray !== FALSE) {

				$itemArray = @unserialize($binaryItemArray); //エラー抑制演算子：E_WARNINGが画面に表示されるのを防ぐ。//var_dump($itemArray);
				if ($itemArray === FALSE) {
					$itemArray = NULL;
				}
			}
		}

		if (is_null($itemArray)) {

			$response = $itemsHTMLInfoMaker->requestItemSearch($urlInfo, $itemHTMLOption->getNumberToDisplay());
			$itemArray = $itemsHTMLInfoMaker->makeItemArray($response, $itemHTMLOption); // var_dump($itemArray);

			/**
			 * レンタルサーバーのMySQLにおいて
			 * set_transient()に配列変数$itemArrayを設定する場合、失敗している場合があった。set_transient returns false.
			 * よって _transient_goodsmemoXXXX が作成されないため、429:Too Many Requestsエラーが起きていた。
			 * 設定する値を、64種類の英数字の文字列にした。
			 * テーブル: wp_options：option_value列 longtext型
			 */
			$binaryItemArray = serialize($itemArray); //バイナリ文字列。データベースのBLOB型に保存できる。longtext型に保存できない場合があった。//var_dump($binaryItemArray);
			$transientItemArray = base64_encode($binaryItemArray); //64種類の印字可能な英数字の文字列。データベースのlongtext型に保存できる。
			//一時的にデータベースに商品情報を保存する。有効期限後、削除される。
			set_transient($transientID, $transientItemArray, $cacheExpirationInSeconds); //失敗したら、falseを返した。
		}

		$itemsHtml = ItemArrayHTMLMaking::makeItemArrayHTML($itemArray, $itemHTMLOption);
		return $itemsHtml;
	}

}
