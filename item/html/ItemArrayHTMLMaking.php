<?php

namespace goodsmemo\item\html;

use goodsmemo\item\Item;
use goodsmemo\item\ImageItem;
use goodsmemo\item\PriceItem;
use goodsmemo\item\ProductionItem;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\ReviewItemHTMLUtils;
use goodsmemo\item\html\FooterHTMLUtils;
use goodsmemo\date\DateTextMaking;
use goodsmemo\text\TextUtils;

require_once GOODS_MEMO_DIR . "item/Item.php";
require_once GOODS_MEMO_DIR . "item/ImageItem.php";
require_once GOODS_MEMO_DIR . "item/PriceItem.php";
require_once GOODS_MEMO_DIR . "item/ProductionItem.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLUtils.php";
require_once GOODS_MEMO_DIR . "item/html/FooterHTMLUtils.php";
require_once GOODS_MEMO_DIR . "date/DateTextMaking.php";
require_once GOODS_MEMO_DIR . "text/TextUtils.php";

class ItemArrayHTMLMaking
{
	const NO_APPLICABLE_PRODUCT = "該当する商品は、ありませんでした。";

	public static function makeItemArrayHTML(
		$itemArray,
		ItemHTMLOption $itemHTMLOption
	) {

		$_ = function ($s) {
			return $s;
		}; // 展開用のラムダ関数。ヒアドキュメントで定数を展開できる。

		$idPrefix = $itemHTMLOption->getIdPrefix();
		$itemArrayHTML = <<< EOD
		<div class="{$_(GOODS_MEMO_PREFIX)}-{$idPrefix}-items {$_(GOODS_MEMO_PREFIX)}-items">
		EOD;

		$itemCount = count($itemArray);
		$numberToDisplay = $itemHTMLOption->getNumberToDisplay();
		$count = min($itemCount, $numberToDisplay);

		if ($count <= 0) {

			$itemArrayHTML .= <<< EOD
			<p>{$_(ItemArrayHTMLMaking::NO_APPLICABLE_PRODUCT)}</p>
			</div>
			EOD;
			return $itemArrayHTML;
		}

		$footerHTMLInfo = FooterHTMLUtils::makeFooterHTMLInfo($itemHTMLOption);
		$footerID = $footerHTMLInfo->getFooterID();

		for ($index = 0; $index < $count; $index++) {

			$item = $itemArray[$index];
			$oneItemHTML = ItemArrayHTMLMaking::makeOneItemHTML(
				$item,
				$index,
				$itemHTMLOption,
				$footerID
			);
			$itemArrayHTML .= $oneItemHTML;
		}

		$footerDiv = $footerHTMLInfo->getFooterDiv();
		$itemArrayHTML .= $footerDiv;
		$itemArrayHTML .= "</div>";

		return $itemArrayHTML;
	}

	private static function makeOneItemHTML(
		Item $item,
		$index,
		ItemHTMLOption $itemHTMLOption,
		$footerID
	) {

		$idIndex = $index + 1; // １から始まる値にする。
		$idPrefix = $itemHTMLOption->getIdPrefix();

		$pageURL = $item->getPageURL();

		$imageItem = $item->getImageItem();
		ItemArrayHTMLMaking::setImageInfoIfURLIsEmpty($imageItem);
		$imageURL = $imageItem->getImageURL();
		$imageWidth = $imageItem->getImageWidth();
		$imageHeight = $imageItem->getImageHeight();

		$title = ItemArrayHTMLMaking::makeTitle($item, $itemHTMLOption);

		$priceItem = $item->getPriceItem();
		$priceLabel = $priceItem->getLabel();
		$price = $priceItem->getPrice();
		$priceAddition = $priceItem->getPriceAddition();
		$priceTimeText = ItemArrayHTMLMaking::makePriceTimeText($priceItem);
		$postageText = $priceItem->getPostageText();

		$pointItem = $item->getPointItem();
		$pointRate = $pointItem->getPointRate();
		$pointRateStartTime = $pointItem->getPointRateStartTime();
		$pointRateEndTime = $pointItem->getPointRateEndTime();

		$productionItem = $item->getProductionItem();
		$contributorText = ItemArrayHTMLMaking::makeContributorText(
			$productionItem
		);
		$manufacturerLabel = $productionItem->getManufacturerLabel();
		$manufacturer = $productionItem->getManufacturer();
		$binding = $productionItem->getBinding();

		$preferentialMember = $item->getPreferentialMember();
		$shop = $item->getShop();

		$reviewText = ItemArrayHTMLMaking::makeReviewText(
			$item,
			$itemHTMLOption
		);

		$_ = function ($s) {
			return $s;
		}; // 展開用のラムダ関数。ヒアドキュメントで定数を展開できる。
		// 項目の有無によって、表示を制御する。
		$hideIfEmpty = function ($value) {
			if (is_numeric($value)) {
				return "";
			}
			if ($value === "") {
				return 'style="display: none;"';
			} else {
				return "";
			}
		};

		$oneItemHTML = <<< EOD
		<div class="{$_(GOODS_MEMO_PREFIX)}-{$idPrefix}-item{$idIndex} {$_(GOODS_MEMO_PREFIX)}-oneItem">
		
			<div class="imageArea" {$hideIfEmpty($imageURL)}>
			<a href="{$pageURL}">
			<img src="{$imageURL}" alt="{$title}" width="{$imageWidth}" height="{$imageHeight}" />
			</a>
			</div>
		
			<div class="title" {$hideIfEmpty($title)}>
			<a href="{$pageURL}">{$title}</a>
			</div>
		
			<div class="itemDetailsTable">
				<div class="tableRow" {$hideIfEmpty($price)}>
				<p class="rowLabel">{$priceLabel}:</p>
				<p class="price">
				<span class="priceValue">{$price}</span>{$priceAddition}<span class="priceTime">({$priceTimeText}時点<a href="#{$footerID}" class="priceTimeLink" {$hideIfEmpty($footerID)}>詳細はこちら</a>)</span>
				</p>
				</div>
		
				<div class="tableRow" {$hideIfEmpty($preferentialMember)}>
				<p class="rowLabel"></p>
				<p class="preferentialMember">{$preferentialMember}</p>
				</div>
		
				<div class="tableRow" {$hideIfEmpty($postageText)}>
				<p class="rowLabel"></p>
				<p class="postage">{$postageText}</p>
				</div>
			</div>
		
			<div class="itemDetailsTable">
				<div class="tableRow" {$hideIfEmpty($pointRate)}>
				<p class="rowLabel">ポイント:</p>
				<p class="pointRate">{$pointRate} 倍</p>
				</div>
		
				<div class="tableRow" {$hideIfEmpty($pointRateStartTime)}>
				<p class="rowLabel"></p>
				<p class="pointRateStartTime">&#10003;開始日時 {$pointRateStartTime}</p>
				</div>
		
				<div class="tableRow" {$hideIfEmpty($pointRateEndTime)}>
				<p class="rowLabel"></p>
				<p class="pointRateEndTime">&#10003;終了日時 {$pointRateEndTime}</p>
				</div>
			</div>
		
			<div class="itemDetailsTable">
				<div class="tableRow" {$hideIfEmpty($contributorText)}>
				<p class="rowLabel"></p>
				<p class="contributor">{$contributorText}</p>
				</div>
		
				<div class="tableRow" {$hideIfEmpty($manufacturer)}>
				<p class="rowLabel">{$manufacturerLabel}:</p>
				<p class="manufacturer">{$manufacturer}</p>
				</div>
		
				<div class="tableRow" {$hideIfEmpty($binding)}>
				<p class="rowLabel">種別:</p>
				<p class="binding">{$binding}</p>
				</div>
		
				<div class="tableRow" {$hideIfEmpty($shop)}>
				<p class="rowLabel">販売店:</p>
				<p class="shop">{$shop}</p>
				</div>
			</div>

			<div class="reviewArea" {$hideIfEmpty($reviewText)}>
			<p class="reviewLabel">商品の説明:</p>
			<p class="review">{$reviewText}</p>
			</div>
		
		</div>
		EOD;

		return $oneItemHTML;
	}

	private static function makeTitle(Item $item, ItemHTMLOption $itemHTMLOption)
	{

		$title = $item->getTitle();
		$titleLength = $itemHTMLOption->getTitleLength();
		$trimmedTitle = TextUtils::mb_strimwidth($title, 0, $titleLength, "…");
		return $trimmedTitle;
	}

	private static function setImageInfoIfURLIsEmpty(ImageItem &$imageItem)
	{

		$imageURL = $imageItem->getImageURL();
		if (empty($imageURL)) {

			$imageURL = plugins_url('images/no-image.png', __FILE__);
			$imageItem->setImageURL($imageURL);

			$imageItem->setImageWidth(300); // no-image.png の幅
			$imageItem->setImageHeight(300); // no-image.png の高さ
		}
	}

	private static function makePriceTimeText(PriceItem $priceItem)
	{

		$priceTime = $priceItem->getPriceTime();
		$priceTimeText = DateTextMaking::makeTimeText(
			DateTextMaking::TIME_TEXT_FORMAT,
			$priceTime
		);
		return $priceTimeText;
	}

	private static function makeContributorText(ProductionItem $productionItem)
	{

		$contributorArray = $productionItem->getContributorArray();
		$contributorText = implode(", ", $contributorArray);
		return $contributorText;
	}

	private static function makeReviewText(
		Item $item,
		ItemHTMLOption $itemHTMLOption
	) {

		$reviewItem = $item->getReviewItem();
		$reviewItemHTMLOption = $itemHTMLOption->getReviewItemHTMLOption();
		$reviewText = ReviewItemHTMLUtils::makeFitReviewText(
			$reviewItem,
			$reviewItemHTMLOption
		);
		return $reviewText;
	}
}
