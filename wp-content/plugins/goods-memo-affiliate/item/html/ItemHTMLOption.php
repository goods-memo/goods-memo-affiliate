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

namespace goodsmemo\item\html;

use goodsmemo\item\html\ImageItemHTMLOption;
use goodsmemo\item\html\PriceItemHTMLOption;
use goodsmemo\item\html\ReviewItemHTMLOption;

require_once GOODS_MEMO_DIR . "item/html/ImageItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/PriceItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLOption.php";

/**
 * Description of ItemHTMLOption
 *
 * @author Goods Memo
 */
class ItemHTMLOption {

    private $idPrefix;
    private $numberToDisplay;
    private $titleLength;
    private $imageItemHTMLOption;
    private $priceItemHTMLOption;
    private $reviewItemHTMLOption;
    private $cacheExpirationInSeconds;

    public function getIdPrefix() {
	return $this->idPrefix;
    }

    public function setIdPrefix($idPrefix) {
	$this->idPrefix = $idPrefix;
    }

    public function getNumberToDisplay() {
	return $this->numberToDisplay;
    }

    public function setNumberToDisplay($numberToDisplay) {
	$this->numberToDisplay = $numberToDisplay;
    }

    public function getTitleLength() {
	return $this->titleLength;
    }

    public function setTitleLength($titleLength) {
	$this->titleLength = $titleLength;
    }

    public function getImageItemHTMLOption(): ImageItemHTMLOption {
	return $this->imageItemHTMLOption;
    }

    public function setImageItemHTMLOption(ImageItemHTMLOption $imageItemHTMLOption) {
	$this->imageItemHTMLOption = $imageItemHTMLOption;
    }

    public function getPriceItemHTMLOption(): PriceItemHTMLOption {
	return $this->priceItemHTMLOption;
    }

    public function setPriceItemHTMLOption(PriceItemHTMLOption $priceItemHTMLOption) {
	$this->priceItemHTMLOption = $priceItemHTMLOption;
    }

    public function getReviewItemHTMLOption(): ReviewItemHTMLOption {
	return $this->reviewItemHTMLOption;
    }

    public function setReviewItemHTMLOption(ReviewItemHTMLOption $reviewItemHTMLOption) {
	$this->reviewItemHTMLOption = $reviewItemHTMLOption;
    }

    public function getCacheExpirationInSeconds() {
	return $this->cacheExpirationInSeconds;
    }

    public function setCacheExpirationInSeconds($cacheExpirationInSeconds) {
	$this->cacheExpirationInSeconds = $cacheExpirationInSeconds;
    }

}
