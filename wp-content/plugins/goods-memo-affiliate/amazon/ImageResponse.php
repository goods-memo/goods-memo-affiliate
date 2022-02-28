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

namespace goodsmemo\amazon;

use goodsmemo\item\ImageItem;

require_once GOODS_MEMO_DIR . "item/ImageItem.php";
//PA-API v5  SDK
require_once(__DIR__ . '/sdk/vendor/autoload.php'); // change path as needed

/**
 * Description of ImageResponse
 *
 * @author Goods Memo
 */
class ImageResponse {

	public static function makeImageItem(\Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem): ImageItem {

		$imageItem = new ImageItem();

		if ($searchItem->getImages() == NULL
			or $searchItem->getImages()->getPrimary() == NULL) {
			return $imageItem;
		}

		$primaryImages = $searchItem->getImages()->getPrimary();

		//大きさの優先順位は、ミディアム、ラージ、スモール

		if ($primaryImages->getMedium() != NULL) {
			$imageSize = $primaryImages->getMedium();
			ImageResponse::setImageInfoTo($imageItem, $imageSize);

			if ($imageItem->getImageURL()) {
				return $imageItem;
			}
		}

		if ($primaryImages->getLarge() != NULL) {
			$imageSize = $primaryImages->getLarge();
			ImageResponse::setImageInfoTo($imageItem, $imageSize);

			if ($imageItem->getImageURL()) {
				return $imageItem;
			}
		}

		if ($primaryImages->getSmall() != NULL) {
			$imageSize = $primaryImages->getSmall();
			ImageResponse::setImageInfoTo($imageItem, $imageSize);

			if ($imageItem->getImageURL()) {
				return $imageItem;
			}
		}

		return $imageItem;
	}

	private static function setImageInfoTo(ImageItem &$imageItem,
		\Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\ImageSize $imageSize) {

		if ($imageSize->getURL() != NULL) { //ImageSizeクラス string型
			$imageItem->setImageURL(esc_url($imageSize->getURL()));
			$imageItem->setImageWidth($imageSize->getWidth()); //ImageSizeクラス int32型
			$imageItem->setImageHeight($imageSize->getHeight()); //ImageSizeクラス int32型
		}
	}

}
