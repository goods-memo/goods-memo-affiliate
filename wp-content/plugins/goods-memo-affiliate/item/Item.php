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

use goodsmemo\item\ImageItem;
use goodsmemo\item\PriceItem;
use goodsmemo\item\PointItem;
use goodsmemo\item\ProductionItem;
use goodsmemo\item\ReviewItem;

require_once GOODS_MEMO_DIR . "item/ImageItem.php";
require_once GOODS_MEMO_DIR . "item/PriceItem.php";
require_once GOODS_MEMO_DIR . "item/PointItem.php";
require_once GOODS_MEMO_DIR . "item/ProductionItem.php";
require_once GOODS_MEMO_DIR . "item/ReviewItem.php";

/**
 * Description of Item
 *
 * @author Goods Memo
 */
class Item {

	private $pageURL = "";
	private $imageItem;
	private $title = "";
	private $priceItem;
	private $pointItem;
	private $productionItem;
	private $preferentialMember = ""; //優待会員
	private $shop = "";
	private $reviewItem;

	function __construct() {
		$this->imageItem = new ImageItem();
		$this->priceItem = new PriceItem();
		$this->pointItem = new PointItem();
		$this->productionItem = new ProductionItem(); //例：楽天で設定しない場合、空のProductionItemオブジェクトを使う。nullエラーを防げる。
		$this->reviewItem = new ReviewItem();
	}

	public function getPageURL() {
		return $this->pageURL;
	}

	public function setPageURL($pageURL) {
		$this->pageURL = $pageURL;
	}

	public function getImageItem(): ImageItem {
		return $this->imageItem;
	}

	public function setImageItem(ImageItem $imageItem) {
		$this->imageItem = $imageItem;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getPriceItem(): PriceItem {
		return $this->priceItem;
	}

	public function setPriceItem(PriceItem $priceItem) {
		$this->priceItem = $priceItem;
	}

	public function getPointItem(): PointItem {
		return $this->pointItem;
	}

	public function setPointItem(PointItem $pointItem) {
		$this->pointItem = $pointItem;
	}

	public function getProductionItem(): ProductionItem {
		return $this->productionItem;
	}

	public function setProductionItem(ProductionItem $productionItem) {
		$this->productionItem = $productionItem;
	}

	public function getPreferentialMember() {
		return $this->preferentialMember;
	}

	public function setPreferentialMember($preferentialMember) {
		$this->preferentialMember = $preferentialMember;
	}

	public function getShop() {
		return $this->shop;
	}

	public function setShop($shop) {
		$this->shop = $shop;
	}

	public function getReviewItem(): ReviewItem {
		return $this->reviewItem;
	}

	public function setReviewItem(ReviewItem $reviewItem) {
		$this->reviewItem = $reviewItem;
	}

}
