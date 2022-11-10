<?php

namespace goodsmemo\item\html;

class ReviewItemHTMLOption {
	private $reviewLength;
	private $stringToDeleteJSONArray;
	private $stringToBreakJSONArray;

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
}
