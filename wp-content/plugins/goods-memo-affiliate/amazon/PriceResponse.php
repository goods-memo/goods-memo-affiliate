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

namespace goodsmemo\amazon;

use goodsmemo\item\PriceItem;
use goodsmemo\item\html\PriceUtils;
use goodsmemo\item\html\HTMLUtils;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "item/PriceItem.php";
require_once GOODS_MEMO_DIR . "item/html/PriceUtils.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";
//PA-API v5  SDK
require_once(__DIR__ . '/sdk/vendor/autoload.php'); // change path as needed

/**
 * Description of PriceResponse
 *
 * @author Goods Memo
 */
class PriceResponse {

	public static function makePriceItem(\Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem,
		float $priceTime): PriceItem {

		$priceItem = new PriceItem();
		$offers = $searchItem->getOffers();

		//参考：PA-API v4
		//定価 価格：「ItemAttributes->ListPrice->Amount」「ItemAttributes->ListPrice->FormattedPrice」
		//Amazon.co.jp 価格：「Offers->Offer->OfferListing->Price->Amount」「Offers->Offer->OfferListing->Price->FormattedPrice」
		//マーチャント 新品の価格：「OfferSummary->LowestNewPrice->Amount」「OfferSummary->LowestNewPrice->FormattedPrice」
		//
		//PA-API v5
		//LowestUsedPriceは、無い。Condition ValueにUsedがあった。
		//Offers Listings Condition Value:Valid Values: New, Used, Collectible and Refurbished

		$priceFlag = 0b000;
		if ($offers != NULL
			and $offers->getListings() != NULL
			and $offers->getListings()[0] != NULL
			and $offers->getListings()[0]->getPrice() != NULL
			and $offers->getListings()[0]->getPrice()->getAmount() != NULL
		) {
			$priceFlag = $priceFlag | 0b001; //「Amazon.co.jp 価格」が存在する。
		}
		if ($offers != NULL
			and $offers->getSummaries() != NULL
			and $offers->getSummaries()[0] != NULL
			and $offers->getSummaries()[0]->getLowestPrice() != NULL
			and $offers->getSummaries()[0]->getLowestPrice()->getAmount() != NULL
		) {
			$priceFlag = $priceFlag | 0b010; //「価格（最安値）」が存在する。
		}
		//if (isset($node->OfferSummary->LowestUsedPrice->FormattedPrice)) {
		//	$priceFlag = $priceFlag | 0b100; //「マーチャント 中古の価格」が存在する。
		//}
		//var_dump($priceFlag);

		switch ($priceFlag) {
			case 0b000:
				PriceResponse::setEmptyPriceTo($priceItem);
				break;
			case 0b001:
			case 0b101:
				PriceResponse::setAmazonPriceTo($priceItem, $offers);
				break;
			case 0b010:
			case 0b110:
				PriceResponse::setLowestPriceTo($priceItem, $offers);
				break;
			case 0b011:
			case 0b111:
				PriceResponse::setFitNewPriceTo($priceItem, $offers);
				break;
			case 0b100:
				PriceResponse::setMerchantUsedPriceTo($priceItem, $offers);
				break;
			default :
				throw new IllegalArgumentException("無効な価格フラグ値：" . decbin($priceFlag));
		}

		if ($offers != NULL
			and $offers->getListings() != NULL
			and $offers->getListings()[0] != NULL
			and $offers->getListings()[0]->getDeliveryInfo() != NULL) {

			$isFreeShippingEligible = $offers->getListings()[0]->getDeliveryInfo()->getIsFreeShippingEligible(); //bool型	//var_dump($isFreeShippingEligible);
			if ($isFreeShippingEligible) {
				$priceItem->setPostageText("送料無料");
			}
		}

		$priceItem->setPriceTime($priceTime);

		return $priceItem;
	}

	private static function setEmptyPriceTo(&$priceItem) {

		$priceItem->setLabel("価格");
		$priceItem->setPrice("");
		$priceItem->setPriceAddition("");
	}

	private static function setAmazonPriceTo(&$priceItem, $offers) {

		$priceItem->setLabel("価格"); //スマートフォンの画面幅が狭いため、文字数を短くした。「Amazon.co.jp 価格」

		$amazonPrice = PriceResponse::makeAmazonPriceIfAmoutIsSet($offers);
		$formattedPrice = PriceUtils::makeFormattedPrice($amazonPrice);
		$priceItem->setPrice($formattedPrice);

		$priceItem->setPriceAddition("");
	}

	private static function setLowestPriceTo(&$priceItem, $offers) {

		$priceItem->setLabel("最安価格"); //参考：PA-API v4の場合、新品価格

		$lowestPrice = PriceResponse::makeLowestPriceIfAmoutIsSet($offers);
		$formattedPrice = PriceUtils::makeFormattedPrice($lowestPrice);
		$priceItem->setPrice($formattedPrice);

		$priceItem->setPriceAddition("");
	}

	private static function setMerchantUsedPriceTo(&$priceItem, $offers) {

		throw new Exception("setMerchantUsedPriceTo()が、呼び出された。");

//		$priceItem->setLabel("中古価格");
//
//		$merchantPrice = PriceResponse::makeMerchantUsedPriceIfAmoutIsSet($offers);
//		$formattedPrice = PriceUtils::makeFormattedPrice($merchantPrice);
//		$priceItem->setPrice($formattedPrice);
//
//		$priceItem->setPriceAddition("より");
	}

	private static function setFitNewPriceTo(&$priceItem, $offers) {
		//Fit：ちょうど良い

		$amazonPrice = PriceResponse::makeAmazonPriceIfAmoutIsSet($offers);
		$lowestPrice = PriceResponse::makeLowestPriceIfAmoutIsSet($offers);

		if (is_numeric($amazonPrice) && is_numeric($lowestPrice)) {//var_dump(is_numeric($amazonPrice));//var_dump(is_numeric($merchantPrice));
			$amazonPrice = intval($amazonPrice);
			$lowestPrice = intval($lowestPrice);

			if ($amazonPrice < $lowestPrice) {
				PriceResponse::setAmazonPriceTo($priceItem, $offers);
			} else {
				PriceResponse::setLowestPriceTo($priceItem, $offers);
			}
		} else {
			PriceResponse::setEmptyPriceTo($priceItem);
		}
	}

	private static function makeAmazonPriceIfAmoutIsSet($offers) {

		if ($offers != NULL
			and $offers->getListings() != NULL
			and $offers->getListings()[0] != NULL
			and $offers->getListings()[0]->getPrice() != NULL
			and $offers->getListings()[0]->getPrice()->getAmount() != NULL
		) {
			$priceAmount = $offers->getListings()[0]->getPrice()->getAmount();
			return HTMLUtils::makePlainText((string) $priceAmount);
		} else {
			return "";
		}
	}

	private static function makeLowestPriceIfAmoutIsSet($offers) {

		if ($offers != NULL
			and $offers->getSummaries() != NULL
			and $offers->getSummaries()[0] != NULL
			and $offers->getSummaries()[0]->getLowestPrice() != NULL
			and $offers->getSummaries()[0]->getLowestPrice()->getAmount() != NULL
		) {
			$lowestPriceAmount = $offers->getSummaries()[0]->getLowestPrice()->getAmount();
			return HTMLUtils::makePlainText((string) $lowestPriceAmount);
		} else {
			return "";
		}
	}

	private static function makeMerchantUsedPriceIfAmoutIsSet($offers) {

		throw new Exception("makeMerchantUsedPriceIfAmoutIsSet()が、呼び出された。");

//		if (isset($node->OfferSummary->LowestUsedPrice->Amount)) {
//
//			return HTMLUtils::makePlainText(
//					(string) $node->OfferSummary->LowestUsedPrice->Amount //例：object(SimpleXMLElement) public 0 => string '999' (length=3)
//			);
//		} else {
//
//			return "";
//		}
	}

}
