<?php

namespace goodsmemo\text;

class TextUtils {

	public static function startsWith($haystack, $needle) {

		return (strpos ( $haystack, $needle ) === 0);
	}

	public static function mb_strimwidth(string $str, int $start, int $width, $trimmarker = "",
			$encoding = "UTF-8") {

		// mb_strimwidth()：全角を2，半角を1として数えて、指定した幅で切り取る。
		// mb_strimwidthの$trimmarker引数が「３点リーダー文字」の場合、数え間違いするらしい？
		// 全角の３点リーダー文字を、半角と判断するらしい。
		// var_dump($encoding);
		$trimmedText = mb_strimwidth ( $str, $start, $width, "", $encoding ); // $trimmarker引数に、空文字を指定する。

		$cmpValue = strcmp ( $str, $trimmedText ); // 等しければ 0 を返します。

		if ($cmpValue != 0 && $trimmedText) { // 文字列が切り取られた、かつ、文字が存在するなら
			$trimmedText .= $trimmarker; // 例：ここで$trimmarker「３点リーダー文字」を、結合する。
		}

		return $trimmedText;
	}

	public static function decodeJSONTextToArray(string $JSONText) {

		$JSONArray = json_decode ( $JSONText, true ); // true：連想配列に変換する
		if (is_null ( $JSONArray )) {
			return array ();
		} else {
			return $JSONArray;
		}
	}
}
