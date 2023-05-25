<?php

namespace goodsmemo\item\html;

class PriceUtils {

	public static function makeFormattedPrice(float $price) {

		// 千位毎にカンマ (",") を追加する。
		$priceText = number_format ( $price ) . " 円"; // string number_format ( float $number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = "," )
		return $priceText;
	}
}
