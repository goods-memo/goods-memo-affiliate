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
namespace goodsmemo\amazon\withsdk;

use goodsmemo\amazon\ImageResponse;
use goodsmemo\amazon\PriceResponse;
use goodsmemo\amazon\ProductionResponse;
use goodsmemo\amazon\ProductTypeOption;
// use goodsmemo\item\Item;//PA-API v5 SDKに同名のクラスがある。
use goodsmemo\item\ReviewItem;
use goodsmemo\item\html\HTMLUtils;
use goodsmemo\date\DateTextMaking;

// PA-API v5 SDK
// use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item;
require_once GOODS_MEMO_DIR . "amazon/ImageResponse.php";
require_once GOODS_MEMO_DIR . "amazon/PriceResponse.php";
require_once GOODS_MEMO_DIR . "amazon/ProductionResponse.php";
require_once GOODS_MEMO_DIR . "amazon/ProductTypeOption.php";
require_once GOODS_MEMO_DIR . "item/Item.php";
require_once GOODS_MEMO_DIR . "item/ReviewItem.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
require_once GOODS_MEMO_DIR . "date/DateTextMaking.php";
// PA-API v5 SDK
require_once (__DIR__ . '/sdk/vendor/autoload.php');

// change path as needed

/**
 * Description of AmazonResponse
 *
 * @author Goods Memo
 */
class SDKAmazonResponse {

	public static function makeItemArray($searchItemsResponse, $numberToDisplay, ProductTypeOption $productTypeOption) {

		$itemArray = array ();

		if ($searchItemsResponse == NULL or $searchItemsResponse->getSearchResult () == NULL or $searchItemsResponse->getSearchResult ()->getItems () == NULL) {

			return $itemArray; // 商品情報なし
		}

		$searchItems = $searchItemsResponse->getSearchResult ()->getItems (); // Item[] //PA-API v5 SDKのItemクラス
		$priceTime = DateTextMaking::getUnixTimeMillSecond ();

		$searchItemCount = count ( $searchItems ); // var_dump($searchItems);
		$count = min ( $searchItemCount, $numberToDisplay );
		for($i = 0; $i < $count; $i ++) {

			$searchItem = $searchItems [$i];
			if ($searchItem == NULL) { // 念のため。配列の要素がNULLの場合
				continue;
			}

			if (SDKAmazonResponse::getItemEnabled ( $searchItem, $productTypeOption )) {

				$item = SDKAmazonResponse::makeItem ( $searchItem, $priceTime );
				array_push ( $itemArray, $item );
			}
		}

		return $itemArray;
	}

	private static function getItemEnabled(\Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem, ProductTypeOption $productTypeOption): bool {

		$adultProductEnable = $productTypeOption->getAdultProductEnabled (); // var_dump($adultProductEnable);
		if ($adultProductEnable) {
			return true;
		}

		// 以下、アダルト商品が無効と指定されている場合について
		//
		if ($searchItem->getItemInfo () == NULL or $searchItem->getItemInfo ()->getProductInfo () == NULL or $searchItem->getItemInfo ()->getProductInfo ()->getIsAdultProduct () == NULL or $searchItem->getItemInfo ()->getProductInfo ()->getIsAdultProduct ()->getDisplayValue () === NULL) // bool型とNULL型を比較
		{

			return true; // アダルト商品の情報がない場合、有効とする。
		}

		$isAdultProductValue = $searchItem->getItemInfo ()->getProductInfo ()->getIsAdultProduct ()->getDisplayValue (); // SingleBooleanValuedAttributeクラスのbool値
		                                                                                                                 // var_dump($isAdultProductValue);//var_dump($searchItem);
		if ($isAdultProductValue) {
			return false; // $searchItemがアダルト商品なら、無効とする。
		} else {
			return true; // $searchItemが普通の商品なら、有効とする。
		}
	}

	private static function makeItem(\Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem, float $priceTime): \goodsmemo\item\Item {

		$item = new \goodsmemo\item\Item ();

		if ($searchItem->getDetailPageURL () != NULL) {
			$item->setPageURL ( esc_url ( $searchItem->getDetailPageURL () ) );
		}

		SDKAmazonResponse::setItemInfoTo ( $item, $searchItem );
		SDKAmazonResponse::setOffersTo ( $item, $searchItem );

		$imageItem = ImageResponse::makeImageItem ( $searchItem );
		$item->setImageItem ( $imageItem );

		$priceItem = PriceResponse::makePriceItem ( $searchItem, $priceTime );
		$item->setPriceItem ( $priceItem );

		$productionItem = ProductionResponse::makeProductionItem ( $searchItem );
		$item->setProductionItem ( $productionItem ); // var_dump($searchItem);

		$reviewItem = SDKAmazonResponse::makeReviewItem ( $searchItem );
		$item->setReviewItem ( $reviewItem );

		return $item;
	}

	private static function setItemInfoTo(\goodsmemo\item\Item &$item, \Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem) {

		if ($searchItem->getItemInfo () == NULL) {
			return;
		}

		$itemInfo = $searchItem->getItemInfo ();

		if ($itemInfo->getTitle () != NULL and $itemInfo->getTitle ()->getDisplayValue () != NULL) {

			$titleValue = $itemInfo->getTitle ()->getDisplayValue ();
			$item->setTitle ( HTMLUtils::makePlainText ( $titleValue ) );
		}
	}

	private static function setOffersTo(\goodsmemo\item\Item &$item, \Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem) {

		if ($searchItem->getOffers () == NULL) {
			return;
		}

		$offers = $searchItem->getOffers (); // var_dump($offers);

		if ($offers->getListings () != NULL and $offers->getListings () [0] != NULL and $offers->getListings () [0]->getDeliveryInfo () != NULL) {

			$isPrimeEligible = $offers->getListings () [0]->getDeliveryInfo ()->getIsPrimeEligible (); // bool型 //var_dump($isPrimeEligible);
			if ($isPrimeEligible) {
				$item->setPreferentialMember ( HTMLUtils::makePlainText ( "&#10003;prime" ) ); // "✓prime"
			}
		}

		if ($offers->getListings () != NULL and $offers->getListings () [0] != NULL and $offers->getListings () [0]->getMerchantInfo () != NULL and $offers->getListings () [0]->getMerchantInfo ()->getName () != NULL) {

			$merchantName = $offers->getListings () [0]->getMerchantInfo ()->getName ();
			$item->setShop ( HTMLUtils::makePlainText ( $merchantName ) );
		}
	}

	private static function makeReviewItem(\Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem): ReviewItem {

		$reviewItem = new ReviewItem ();

		if ($searchItem->getItemInfo () != NULL and $searchItem->getItemInfo ()->getFeatures () != NULL and $searchItem->getItemInfo ()->getFeatures ()->getDisplayValues () != NULL) {

			$featuresValues = $searchItem->getItemInfo ()->getFeatures ()->getDisplayValues (); // string[]

			$featureArray = array ();
			foreach ( $featuresValues as $value ) {

				if ($value == NULL) {
					continue;
				} // var_dump($value);
				$feature = HTMLUtils::makePlainText ( $value );
				array_push ( $featureArray, $feature );
			}

			$reviewItem->setReviewLineArray ( $featureArray );
		}

		// TODO Check back later for updates
		// if (isset($node->EditorialReviews->EditorialReview->Content)) {//Noticd: Trying to get property of non-objectエラーが起きた。
		// $editorialReview = HTMLUtils::makePlainText($node->EditorialReviews->EditorialReview->Content);
		// $reviewItem->setPlainTextReview($editorialReview);
		// }

		return $reviewItem;
	}
}
