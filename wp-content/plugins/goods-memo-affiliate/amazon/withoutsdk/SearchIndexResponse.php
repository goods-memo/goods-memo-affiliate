<?php

namespace goodsmemo\amazon\withoutsdk;

use goodsmemo\amazon\withoutsdk\ImageResponse;
use goodsmemo\amazon\withoutsdk\PriceResponse;
use goodsmemo\amazon\withoutsdk\ProductionResponse;

// use goodsmemo\item\Item;//PA-API v5 SDKに同名のクラスがある。
use goodsmemo\item\ReviewItem;
use goodsmemo\item\html\HTMLUtils;
use goodsmemo\date\DateTextMaking;

/*
 * PA-API v5 SDK
 * use Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item;
 */
require_once GOODS_MEMO_DIR . "amazon/withoutsdk/ImageResponse.php";
require_once GOODS_MEMO_DIR . "amazon/withoutsdk/PriceResponse.php";
require_once GOODS_MEMO_DIR . "amazon/withoutsdk/ProductionResponse.php";
require_once GOODS_MEMO_DIR . "item/Item.php";
require_once GOODS_MEMO_DIR . "item/ReviewItem.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
require_once GOODS_MEMO_DIR . "date/DateTextMaking.php";

class SearchIndexResponse {

	public static function makeItemArray($searchItemsResponse, int $numberToDisplay, bool $adultProductEnable) {

		$itemArray = array ();

		if (empty ( $searchItemsResponse ) or ! property_exists ( $searchItemsResponse, 'SearchResult' ) or ! property_exists ( $searchItemsResponse->SearchResult, 'Items' )) {

			return $itemArray; // 商品情報なし
		}

		$searchItems = $searchItemsResponse->SearchResult->Items;
		$priceTime = DateTextMaking::getUnixTimeMillSecond ();

		$searchItemCount = count ( $searchItems );
		$count = min ( $searchItemCount, $numberToDisplay );

		for($i = 0; $i < $count; $i ++) {

			$searchItem = $searchItems [$i];
			if (is_null ( $searchItem )) { // 念のため。配列の要素がNULLの場合
				continue;
			}

			if (SearchIndexResponse::getItemEnabled ( $searchItem, $adultProductEnable )) {

				$item = SearchIndexResponse::makeItem ( $searchItem, $priceTime );
				array_push ( $itemArray, $item );
			}
		}

		return $itemArray;
	}

	private static function getItemEnabled($searchItem, bool $adultProductEnable): bool {

		if ($adultProductEnable) {
			return true;
		}

		/*
		 * 以下、アダルト商品が無効と指定されている場合について
		 */

		if (isset ( $searchItem->ItemInfo ) and isset ( $searchItem->ItemInfo->ProductInfo ) and isset ( $searchItem->ItemInfo->ProductInfo->IsAdultProduct ) and isset ( $searchItem->ItemInfo->ProductInfo->IsAdultProduct->DisplayValue )) {

			;
		} else {
			return true; // アダルト商品の情報がない場合、有効とする。
		}

		$isAdultProductValue = $searchItem->ItemInfo->ProductInfo->IsAdultProduct->DisplayValue;
		if ($isAdultProductValue) {
			return false; // $searchItemがアダルト商品なら、無効とする。
		} else {
			return true; // $searchItemが普通の商品なら、有効とする。
		}
	}

	private static function makeItem($searchItem, float $priceTime): \goodsmemo\item\Item {

		$item = new \goodsmemo\item\Item ();

		if (isset ( $searchItem->DetailPageURL )) {
			$item->setPageURL ( esc_url ( $searchItem->DetailPageURL ) );
		}

		SearchIndexResponse::setItemInfoTo ( $item, $searchItem );

		SearchIndexResponse::setOffersTo ( $item, $searchItem );

		$imageItem = ImageResponse::makeImageItem ( $searchItem );
		$item->setImageItem ( $imageItem );

		$priceItem = PriceResponse::makePriceItem ( $searchItem, $priceTime );
		$item->setPriceItem ( $priceItem );

		/*
		 *
		 * $productionItem = ProductionResponse::makeProductionItem ( $searchItem );
		 * $item->setProductionItem ( $productionItem ); // var_dump($searchItem);
		 *
		 *
		 *
		 */
		$reviewItem = SearchIndexResponse::makeReviewItem ( $searchItem );
		$item->setReviewItem ( $reviewItem );

		return $item;
	}

	private static function setItemInfoTo(\goodsmemo\item\Item &$item, $searchItem) {

		if (isset ( $searchItem->ItemInfo )) {
			;
		} else {
			return;
		}

		$itemInfo = $searchItem->ItemInfo;

		if (isset ( $itemInfo->Title ) and isset ( $itemInfo->Title->DisplayValue )) {

			$titleValue = $itemInfo->Title->DisplayValue;
			$item->setTitle ( HTMLUtils::makePlainText ( $titleValue ) );
		}
	}

	private static function setOffersTo(\goodsmemo\item\Item &$item, $searchItem) {

		if (isset ( $searchItem->Offers )) {
			;
		} else {
			return;
		}

		$offers = $searchItem->Offers;

		if (isset ( $offers->Listings ) and isset ( $offers->Listings [0] )) {

			$listing = $offers->Listings [0];

			if (isset ( $listing->DeliveryInfo ) and isset ( $listing->DeliveryInfo->IsPrimeEligible )) {

				$isPrimeEligible = $listing->DeliveryInfo->IsPrimeEligible;
				if ($isPrimeEligible) {
					$item->setPreferentialMember ( HTMLUtils::makePlainText ( "&#10003;prime" ) ); // "✓prime"
				}
			}

			if (isset ( $listing->MerchantInfo ) and isset ( $listing->MerchantInfo->Name )) {

				$merchantName = $listing->MerchantInfo->Name;
				$item->setShop ( HTMLUtils::makePlainText ( $merchantName ) );
			}
		}
	}

	private static function makeReviewItem($searchItem): ReviewItem {

		$reviewItem = new ReviewItem ();

		if (isset ( $searchItem->ItemInfo ) and isset ( $searchItem->ItemInfo->Features ) and isset ( $searchItem->ItemInfo->Features->DisplayValues )) {

			$featuresValues = $searchItem->ItemInfo->Features->DisplayValues; // string[]

			$featureArray = array ();
			foreach ( $featuresValues as $value ) {

				if ($value == NULL) {
					continue;
				}

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