<?php

namespace goodsmemo\item;

class ImageItem {
	private $imageURL = "";
	private $imageWidth = 0;
	private $imageHeight = 0;

	public function getImageURL() {

		return $this->imageURL;
	}

	public function getImageWidth() {

		return $this->imageWidth;
	}

	public function getImageHeight() {

		return $this->imageHeight;
	}

	public function setImageURL($imageURL) {

		$this->imageURL = $imageURL;
	}

	public function setImageWidth($imageWidth) {

		$this->imageWidth = $imageWidth;
	}

	public function setImageHeight($imageHeight) {

		$this->imageHeight = $imageHeight;
	}
}
