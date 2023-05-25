<?php

namespace goodsmemo\amazon\withoutsdk;

use goodsmemo\item\ImageItem;

require_once GOODS_MEMO_DIR . "item/ImageItem.php";

class ImageResponse {

	public static function makeImageItem($searchItem): ImageItem {

		$imageItem = new ImageItem ();

		if (isset ( $searchItem->Images ) and isset ( $searchItem->Images->Primary )) {
			;
		} else {
			return $imageItem;
		}

		$primaryImages = $searchItem->Images->Primary;

		// 大きさの優先順位は、ミディアム、ラージ、スモール

		if (isset ( $primaryImages->Medium )) {
			$imageSize = $primaryImages->Medium;
			ImageResponse::setImageInfoTo ( $imageItem, $imageSize );

			if ($imageItem->getImageURL ()) {
				return $imageItem;
			}
		}

		if (isset ( $primaryImages->Large )) {
			$imageSize = $primaryImages->Large;
			ImageResponse::setImageInfoTo ( $imageItem, $imageSize );

			if ($imageItem->getImageURL ()) {
				return $imageItem;
			}
		}

		if (isset ( $primaryImages->Small )) {
			$imageSize = $primaryImages->Small;
			ImageResponse::setImageInfoTo ( $imageItem, $imageSize );

			if ($imageItem->getImageURL ()) {
				return $imageItem;
			}
		}

		return $imageItem;
	}

	private static function setImageInfoTo(ImageItem &$imageItem, $imageSize) {

		if (isset ( $imageSize->URL )) {

			$imageItem->setImageURL ( esc_url ( $imageSize->URL ) );
		}

		if (isset ( $imageSize->Width )) {

			$imageItem->setImageWidth ( $imageSize->Width );
		}

		if (isset ( $imageSize->Height )) {

			$imageItem->setImageHeight ( $imageSize->Height );
		}
	}
}