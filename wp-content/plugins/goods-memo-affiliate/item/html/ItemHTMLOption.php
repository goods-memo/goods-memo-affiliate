<?php

namespace goodsmemo\item\html;

use goodsmemo\item\html\ImageItemHTMLOption;
use goodsmemo\item\html\PriceItemHTMLOption;
use goodsmemo\item\html\ReviewItemHTMLOption;

require_once GOODS_MEMO_DIR . "item/html/ImageItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/PriceItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLOption.php";

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
