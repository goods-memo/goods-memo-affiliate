<?php

namespace goodsmemo\rakuten;

use goodsmemo\rakuten\ReviewResponse;
use goodsmemo\rakuten\PointResponse;
use goodsmemo\item\Item;
use goodsmemo\item\ImageItem;
use goodsmemo\item\PriceItem;
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
require_once GOODS_MEMO_DIR . "item/html/ImageItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
require_once GOODS_MEMO_DIR . "item/html/PriceUtils.php";
require_once GOODS_MEMO_DIR . "date/DateTextMaking.php";
require_once GOODS_MEMO_DIR . "arrayutils/ArrayUtils.php";

class RakutenResponse
{

	public static function makeItemArray($response, ImageItemHTMLOption $imageItemHTMLOption)
	{
		$itemArray = array();

		if (empty($response)) {
			return $itemArray; // 商品情報なし
		}

		$json = json_decode($response);
		if (is_null($json)) {
			return $itemArray; // 商品情報なし
		}

		//ヒット件数番 hits：1度に返却する商品数
		$itemCount = intval($json->{'hits'});

		if ($itemCount <= 0) {
			return $itemArray; // 商品情報なし
		}

		$priceTime = DateTextMaking::getUnixTimeMillSecond();

		for ($i = 0; $i < $itemCount; $i++) {

			$node = $json->{'Items'}[$i]->{'Item'};
			if (is_null($node)) { // 念のため。配列の要素がNULLの場合
				continue;
			}

			$item = RakutenResponse::makeItem($node, $imageItemHTMLOption, $priceTime);
			array_push($itemArray, $item);
		}

		return $itemArray;
	}

	private static function makeItem($node, ImageItemHTMLOption $imageItemHTMLOption, float $priceTime)
	{

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

	private static function makeImageItem($node, ImageItemHTMLOption $imageItemHTMLOption): ImageItem
	{

		$imageItem = new ImageItem();

		// 最大3枚の画像（画像サイズ128px*128px）を imageUrl の配列で返却
		// httpsではじまる商品画像128x128のURL
		$mediumImageUrls = $node->{'mediumImageUrls'};

		$imageUrl = $mediumImageUrls['0']->{'imageUrl'};
		$imageItem->setImageURL(esc_url($imageUrl));

		$imageWidth = $imageItemHTMLOption->getImageWidth(); // 楽天APIから値を取得できないため、データベースの値を使う。
		$imageItem->setImageWidth($imageWidth);

		$imageHeight = $imageItemHTMLOption->getImageHeight(); // 楽天APIから値を取得できないため、データベースの値を使う。
		$imageItem->setImageHeight($imageHeight);

		return $imageItem;
	}

	private static function makePriceItem($node, float $priceTime): PriceItem
	{

		$priceItem = new PriceItem();

		$priceItem->setLabel("価格");

		$itemPrice = HTMLUtils::makePlainText($node->{'itemPrice'});
		$priceText = PriceUtils::makeFormattedPrice($itemPrice);
		$priceItem->setPrice($priceText);

		$TAG_FLAG_MAP = array(
			'0' => '［税込］',
			'1' => '［税別］'
		);
		$taxFlag = HTMLUtils::makePlainText($node->{'taxFlag'});
		$taxText = ArrayUtils::getValueIfKeyExists($taxFlag, $TAG_FLAG_MAP);
		$priceItem->setPriceAddition($taxText);

		$priceItem->setPriceTime($priceTime);

		$POSTAGE_FLAG_MAP = array(
			'0' => '送料込',
			'1' => '送料別'
		);
		$postageFlag = HTMLUtils::makePlainText($node->{'postageFlag'});
		$postageText = ArrayUtils::getValueIfKeyExists($postageFlag, $POSTAGE_FLAG_MAP);
		$priceItem->setPostageText($postageText);

		return $priceItem;
	}
}
