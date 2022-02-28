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

/**
 * Description of PriceItem
 *
 * @author Goods Memo
 */
class PriceItem {

    private $label = "";
    private $price = "";
    private $priceAddition = "";
    private $priceTime = 0;
    private $postageText = "";

    public function getLabel() {
	return $this->label;
    }

    public function setLabel($label) {
	$this->label = $label;
    }

    public function getPrice() {
	return $this->price;
    }

    public function setPrice($price) {
	$this->price = $price;
    }

    public function getPriceAddition() {
	return $this->priceAddition;
    }

    public function setPriceAddition($priceAddition) {
	$this->priceAddition = $priceAddition;
    }

    public function getPriceTime(): float {
	return $this->priceTime;
    }

    public function setPriceTime(float $priceTime) {
	$this->priceTime = $priceTime;
    }

    public function getPostageText() {
	return $this->postageText;
    }

    public function setPostageText($postageText) {
	$this->postageText = $postageText;
    }

}
