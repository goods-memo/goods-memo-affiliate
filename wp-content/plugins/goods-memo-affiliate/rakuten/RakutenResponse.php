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

use goodsmemo\rakuten\ReviewResponse;
use goodsmemo\rakuten\PointResponse;
use goodsmemo\item\Item;
use goodsmemo\item\ImageItem;
use goodsmemo\item\PriceItem;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\ImageItemHTMLOption;
use goodsmemo\item\html\HTMLUtils;
use goodsmemo\item\html\PriceUtils;
use goodsmemo\date\DateTextMaking;
use goodsmemo\arrayutils\ArrayUtils;

require_once GOODS_MEMO_DIR . "rakuten/ReviewResponse.php";
require_once GOODS_MEMO_DIR . "rakuten/PointResponse.php";
require_once GOODS_MEMO_DIR . "item/Item.php";
require_once GOODS_MEMO_DIR . "item/ImageItem.php";
require_once GOODS_MEMO_DIR . "item/PriceItem.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ImageItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
require_once GOODS_MEMO_DIR . "item/html/PriceUtils.php";
require_once GOODS_MEMO_DIR . "date/DateTextMaking.php";
require_once GOODS_MEMO_DIR . "arrayutils/ArrayUtils.php";

/**
 * Description of RakutenResponse
 *
 * @author Goods Memo
 */
class RakutenResponse {

    public static function makeItemArray($response, ItemHTMLOption $itemHTMLOption) {

	$itemArray = array();

	$json = json_decode($response);
	$itemCount = intval($json->{'count'});
	if ($itemCount <= 0) {
	    return $itemArray; //商品情報なし
	}
	//var_dump($xml->Items->Item[0]);//print_r($xml->Items->Item[0]);

	$imageItemHTMLOption = $itemHTMLOption->getImageItemHTMLOption();
	$priceTime = DateTextMaking::getUnixTimeMillSecond();

	$numberToDisplay = $itemHTMLOption->getNumberToDisplay();
	$count = min($itemCount, $numberToDisplay);
	for ($i = 0; $i < $count; $i++) {

	    $node = $json->{'Items'}[$i]->{'Item'};

	    $item = RakutenResponse::makeItem($node, $imageItemHTMLOption, $priceTime);
	    array_push($itemArray, $item);
	}

	return $itemArray;
    }

    private static function makeItem($node, ImageItemHTMLOption $imageItemHTMLOption, float $priceTime) {

	$item = new Item();

	$item->setPageURL(esc_url($node->{'affiliateUrl'}));

	$imageItem = RakutenResponse::makeImageItem($node, $imageItemHTMLOption);
	$item->setImageItem($imageItem);

	$item->setTitle(HTMLUtils::makePlainText($node->{'itemName'}));

	$priceItem = RakutenResponse::makePriceItem($node, $priceTime);
	$item->setPriceItem($priceItem);

	$pointItem = PointResponse::makePointItem($node, $priceTime);
	$item->setPointItem($pointItem);

	$item->setShop(HTMLUtils::makePlainText($node->{'shopName'}));

	$reviewItem = ReviewResponse::makeReviewItem($node);
	$item->setReviewItem($reviewItem);

	return $item;
    }

    private static function makeImageItem($node, ImageItemHTMLOption $imageItemHTMLOption): ImageItem {

	$imageItem = new ImageItem();

	//最大3枚の画像（画像サイズ128px*128px）を imageUrl の配列で返却
	//httpsではじまる商品画像128x128のURL
	$mediumImageUrls = $node->{'mediumImageUrls'};

	$imageUrl = $mediumImageUrls['0']->{'imageUrl'};
	$imageItem->setImageURL(esc_url($imageUrl));

	$imageWidth = $imageItemHTMLOption->getImageWidth(); //楽天APIから値を取得できないため、データベースの値を使う。
	$imageItem->setImageWidth($imageWidth);

	$imageHeight = $imageItemHTMLOption->getImageHeight(); //楽天APIから値を取得できないため、データベースの値を使う。
	$imageItem->setImageHeight($imageHeight);

	return $imageItem;
    }

    private static function makePriceItem($node, float $priceTime): PriceItem {

	$priceItem = new PriceItem();

	$priceItem->setLabel("価格");

	$itemPrice = HTMLUtils::makePlainText($node->{'itemPrice'});
	$priceText = PriceUtils::makeFormattedPrice($itemPrice);
	$priceItem->setPrice($priceText);

	$TAG_FLAG_MAP = array('0' => '［税込］', '1' => '［税別］');
	$taxFlag = HTMLUtils::makePlainText($node->{'taxFlag'});
	$taxText = ArrayUtils::getValueIfKeyExists($taxFlag, $TAG_FLAG_MAP);
	$priceItem->setPriceAddition($taxText);

	$priceItem->setPriceTime($priceTime);

	$POSTAGE_FLAG_MAP = array('0' => '送料込', '1' => '送料別');
	$postageFlag = HTMLUtils::makePlainText($node->{'postageFlag'});
	$postageText = ArrayUtils::getValueIfKeyExists($postageFlag, $POSTAGE_FLAG_MAP);
	$priceItem->setPostageText($postageText);

	return $priceItem;
    }

}
