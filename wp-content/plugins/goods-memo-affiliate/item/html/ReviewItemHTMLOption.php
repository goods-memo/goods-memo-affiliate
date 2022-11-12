<?php

namespace goodsmemo\item\html;

class ReviewItemHTMLOption {
	private $reviewLength;
	private $stringToDeleteJSONArray;
	private $stringToBreakJSONArray;
	// 最新の「●箇条書き」の記号文字
	private $latestSentenceSymbols;

	public function getReviewLength() {

		return $this->reviewLength;
	}

	public function setReviewLength($reviewLength) {

		$this->reviewLength = $reviewLength;
	}

	public function getStringToDeleteJSONArray() {

		return $this->stringToDeleteJSONArray;
	}

	public function setStringToDeleteJSONArray($stringToDeleteJSONArray) {

		$this->stringToDeleteJSONArray = $stringToDeleteJSONArray;
	}

	public function getStringToBreakJSONArray() {

		return $this->stringToBreakJSONArray;
	}

	public function setStringToBreakJSONArray($stringToBreakJSONArray) {

		$this->stringToBreakJSONArray = $stringToBreakJSONArray;
	}

	public function getLatestSentenceSymbols() {

		return $this->latestSentenceSymbols;
	}

	public function setLatestSentenceSymbols($latestSentenceSymbols) {

		$this->latestSentenceSymbols = $latestSentenceSymbols;
	}
}
