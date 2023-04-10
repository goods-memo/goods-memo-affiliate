<?php

namespace goodsmemo\item;

class ProductionItem {
	/* 投稿者（「役柄」と「人物名」） */
	private $contributorArray = array (); // 空のオブジェクト作成に対応するため、空の配列を設定する。

	/* 製造者（製造元、メーカー） */
	private $manufacturerLabel = "";
	private $manufacturer = "";

	/* 種別（装丁、形式） */
	private $binding = "";

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
