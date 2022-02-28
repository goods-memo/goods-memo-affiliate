<?php

/*
 * Copyright (C) 2018 Goods Memo.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace goodsmemo\item;

/**
 * Description of ImageItem
 *
 * @author Goods Memo
 */
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
