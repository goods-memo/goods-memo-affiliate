<?php

namespace goodsmemo\item\html;

class ReviewItemHTMLOption {
	private $reviewLength;
	private $arrayOfStringToDelete;
	private $arrayOfStringToBreak;

	public function getReviewLength() {

		return $this->reviewLength;
	}

	public function setReviewLength($reviewLength) {

		$this->reviewLength = $reviewLength;
	}

	public function getArrayOfStringToDelete() {

		return $this->arrayOfStringToDelete;
	}

	public function setArrayOfStringToDelete($arrayOfStringToDelete) {

		$this->arrayOfStringToDelete = $arrayOfStringToDelete;
	}

	public function getArrayOfStringToBreak() {

		return $this->arrayOfStringToBreak;
	}

	public function setArrayOfStringToBreak($arrayOfStringToBreak) {

		$this->arrayOfStringToBreak = $arrayOfStringToBreak;
	}
}
