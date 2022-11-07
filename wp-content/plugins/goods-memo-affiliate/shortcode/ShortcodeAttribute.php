<?php

namespace goodsmemo\shortcode;

class ShortcodeAttribute {
	private string $operation;
	private string $searchIndex;
	private string $keyword;
	private int $numberToDisplay;
	private int $itemTitleLength;
	private int $itemReviewLength;

	public function getOperation() {

		return $this->operation;
	}

	public function getSearchIndex() {

		return $this->searchIndex;
	}

	public function getKeyword() {

		return $this->keyword;
	}

	public function getNumberToDisplay() {

		return $this->numberToDisplay;
	}

	public function getItemTitleLength() {

		return $this->itemTitleLength;
	}

	public function getItemReviewLength() {

		return $this->itemReviewLength;
	}

	public function setOperation($operation) {

		$this->operation = $operation;
	}

	public function setSearchIndex($searchIndex) {

		$this->searchIndex = $searchIndex;
	}

	public function setKeyword($keyword) {

		$this->keyword = $keyword;
	}

	public function setNumberToDisplay($numberToDisplay) {

		$this->numberToDisplay = $numberToDisplay;
	}

	public function setItemTitleLength($itemTitleLength) {

		$this->itemTitleLength = $itemTitleLength;
	}

	public function setItemReviewLength($itemReviewLength) {

		$this->itemReviewLength = $itemReviewLength;
	}
}

