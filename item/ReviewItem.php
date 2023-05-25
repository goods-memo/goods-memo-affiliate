<?php

namespace goodsmemo\item;

class ReviewItem {
	private $reviewLineArray = array ();
	private $plainTextReview = "";

	public function getReviewLineArray() {

		return $this->reviewLineArray;
	}

	public function getPlainTextReview() {

		return $this->plainTextReview;
	}

	public function setReviewLineArray($reviewLineArray) {

		$this->reviewLineArray = $reviewLineArray;
	}

	public function setPlainTextReview($plainTextReview) {

		$this->plainTextReview = $plainTextReview;
	}
}
