<?php

namespace goodsmemo\amazon\withoutsdk;

use Exception;
use goodsmemo\item\PriceItem;
use goodsmemo\item\html\PriceUtils;
use goodsmemo\item\html\HTMLUtils;
use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "item/PriceItem.php";
require_once GOODS_MEMO_DIR . "item/html/PriceUtils.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";

class PriceResponse {

	public static function makePriceItem($searchItem, float $priceTime): PriceItem {

		$priceItem = new PriceItem ();

		if (isset ( $searchItem->Offers )) {
			$offers = $searchItem->Offers;
		} else {
			$offers = NULL;
		}

		// 参考：PA-API v4
		// 定価 価格：「ItemAttributes->ListPrice->Amount」「ItemAttributes->ListPrice->FormattedPrice」
		// Amazon.co.jp 価格：「Offers->Offer->OfferListing->Price->Amount」「Offers->Offer->OfferListing->Price->FormattedPrice」
		// マーチャント 新品の価格：「OfferSummary->LowestNewPrice->Amount」「OfferSummary->LowestNewPrice->FormattedPrice」
		//
		// PA-API v5
		// LowestUsedPriceは、無い。Condition ValueにUsedがあった。
		// Offers Listings Condition Value:Valid Values: New, Used, Collectible and Refurbished

		$priceFlag = 0b000;

		if (isset ( $offers ) and isset ( $offers->Listings ) and isset ( $offers->Listings [0] ) and
				isset ( $offers->Listings [0]->Price ) and
				isset ( $offers->Listings [0]->Price->Amount )) {
			$priceFlag = $priceFlag | 0b001; // 「Amazon.co.jp 価格」が存在する。
		}

		if (isset ( $offers ) and isset ( $offers->Summaries ) and isset ( $offers->Summaries [0] ) and
				isset ( $offers->Summaries [0]->LowestPrice ) and
				isset ( $offers->Summaries [0]->LowestPrice->Amount )) {
			$priceFlag = $priceFlag | 0b010; // 「価格（最安値）」が存在する。
		}

		// if (isset($node->OfferSummary->LowestUsedPrice->FormattedPrice)) {
		// $priceFlag = $priceFlag | 0b100; //「マーチャント 中古の価格」が存在する。
		// }

		switch ($priceFlag) {
			case 0b000 :
				PriceResponse::setEmptyPriceTo ( $priceItem );
				break;
			case 0b001 :
			case 0b101 :
				PriceResponse::setAmazonPriceTo ( $priceItem, $offers );
				break;
			case 0b010 :
			case 0b110 :
				PriceResponse::setLowestPriceTo ( $priceItem, $offers );
				break;
			case 0b011 :
			case 0b111 :
				PriceResponse::setFitNewPriceTo ( $priceItem, $offers );
				break;
			case 0b100 :
				PriceResponse::setMerchantUsedPriceTo ( $priceItem, $offers );
				break;
			default :
				throw new IllegalArgumentException ( "無効な価格フラグ値：" . decbin ( $priceFlag ) );
		}

		if (isset ( $offers ) and isset ( $offers->Listings ) and isset ( $offers->Listings [0] ) and
				isset ( $offers->Listings [0]->DeliveryInfo ) and
				isset ( $offers->Listings [0]->DeliveryInfo->IsFreeShippingEligible )) {

			$isFreeShippingEligible = $offers->Listings [0]->DeliveryInfo->IsFreeShippingEligible;
			if ($isFreeShippingEligible) {
				$priceItem->setPostageText ( "送料無料" );
			}
		}

		$priceItem->setPriceTime ( $priceTime );

		return $priceItem;
	}

	private static function setEmptyPriceTo(&$priceItem) {

		$priceItem->setLabel ( "価格" );
		$priceItem->setPrice ( "" );
		$priceItem->setPriceAddition ( "" );
	}

	private static function setAmazonPriceTo(&$priceItem, $offers) {

		$priceItem->setLabel ( "価格" ); // スマートフォンの画面幅が狭いため、文字数を短くした。「Amazon.co.jp 価格」

		$amazonPrice = PriceResponse::makeAmazonPriceIfAmoutIsSet ( $offers );
		$formattedPrice = PriceUtils::makeFormattedPrice ( $amazonPrice );
		$priceItem->setPrice ( $formattedPrice );

		$priceItem->setPriceAddition ( "" );
	}

	private static function setLowestPriceTo(&$priceItem, $offers) {

		$priceItem->setLabel ( "最安価格" ); // 参考：PA-API v4の場合、新品価格

		$lowestPrice = PriceResponse::makeLowestPriceIfAmoutIsSet ( $offers );
		$formattedPrice = PriceUtils::makeFormattedPrice ( $lowestPrice );
		$priceItem->setPrice ( $formattedPrice );

		$priceItem->setPriceAddition ( "" );
	}

	private static function setMerchantUsedPriceTo(&$priceItem, $offers) {

		throw new Exception ( "setMerchantUsedPriceTo()が、呼び出された。" );

		// $priceItem->setLabel("中古価格");
		//
		// $merchantPrice = PriceResponse::makeMerchantUsedPriceIfAmoutIsSet($offers);
		// $formattedPrice = PriceUtils::makeFormattedPrice($merchantPrice);
		// $priceItem->setPrice($formattedPrice);
		//
		// $priceItem->setPriceAddition("より");
	}

	private static function setFitNewPriceTo(&$priceItem, $offers) {

		// Fit：ちょうど良い
		$amazonPrice = PriceResponse::makeAmazonPriceIfAmoutIsSet ( $offers );
		$lowestPrice = PriceResponse::makeLowestPriceIfAmoutIsSet ( $offers );

		if (is_numeric ( $amazonPrice ) && is_numeric ( $lowestPrice )) { // var_dump(is_numeric($amazonPrice));//var_dump(is_numeric($merchantPrice));
			$amazonPrice = intval ( $amazonPrice );
			$lowestPrice = intval ( $lowestPrice );

			if ($amazonPrice < $lowestPrice) {
				PriceResponse::setAmazonPriceTo ( $priceItem, $offers );
			} else {
				PriceResponse::setLowestPriceTo ( $priceItem, $offers );
			}
		} else {
			PriceResponse::setEmptyPriceTo ( $priceItem );
		}
	}

	private static function makeAmazonPriceIfAmoutIsSet($offers) {

		if (isset ( $offers ) and isset ( $offers->Listings ) and isset ( $offers->Listings [0] ) and
				isset ( $offers->Listings [0]->Price ) and
				isset ( $offers->Listings [0]->Price->Amount )) {

			$priceAmount = $offers->Listings [0]->Price->Amount;
			return HTMLUtils::makePlainText ( ( string ) $priceAmount );
		} else {
			return "";
		}
	}

	private static function makeLowestPriceIfAmoutIsSet($offers) {

		if (isset ( $offers ) and isset ( $offers->Summaries ) and isset ( $offers->Summaries [0] ) and
				isset ( $offers->Summaries [0]->LowestPrice ) and
				isset ( $offers->Summaries [0]->LowestPrice->Amount )) {

			$lowestPriceAmount = $offers->Summaries [0]->LowestPrice->Amount;
			return HTMLUtils::makePlainText ( ( string ) $lowestPriceAmount );
		} else {
			return "";
		}
	}

	private static function makeMerchantUsedPriceIfAmoutIsSet($offers) {

		throw new Exception ( "makeMerchantUsedPriceIfAmoutIsSet()が、呼び出された。" );

		// if (isset($node->OfferSummary->LowestUsedPrice->Amount)) {
		//
		// return HTMLUtils::makePlainText(
		// (string) $node->OfferSummary->LowestUsedPrice->Amount //例：object(SimpleXMLElement) public 0 => string '999' (length=3)
		// );
		// } else {
		//
		// return "";
		// }
	}
}