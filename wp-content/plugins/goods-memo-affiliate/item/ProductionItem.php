<?php

namespace goodsmemo\item;

class ProductionItem {
	private $contributorArray = array (); // 空のオブジェクト作成に対応するため、空の配列を設定する。
	private $manufacturerLabel = "";
	private $manufacturer = ""; // 製造元、メーカー
	private $binding = "";

	// 装丁、形式、種別
	public function getContributorArray() {

		return $this->contributorArray;
	}

	public function getManufacturerLabel() {

		return $this->manufacturerLabel;
	}

	public function getManufacturer() {

		return $this->manufacturer;
	}

	public function getBinding() {

		return $this->binding;
	}

	public function setContributorArray($contributorArray) {

		$this->contributorArray = $contributorArray;
	}

	public function setManufacturerLabel($manufacturerLabel) {

		$this->manufacturerLabel = $manufacturerLabel;
	}

	public function setManufacturer($manufacturer) {

		$this->manufacturer = $manufacturer;
	}

	public function setBinding($binding) {

		$this->binding = $binding;
	}
}
