<?php

namespace goodsmemo\item;

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
