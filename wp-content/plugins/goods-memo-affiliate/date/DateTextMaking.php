<?php

namespace goodsmemo\date;

class DateTextMaking {
	const TIME_TEXT_FORMAT = "Y年n月j日 H:i"; // 例：2018年10月6日 21:23
	const UNIX_TIME_ID_FORMAT = "Y-m-d-H-i-s";

	// 例：HTMLタグのIDに使う。
	public static function getUnixTimeMillSecond(): float {

		date_default_timezone_set ( 'Asia/Tokyo' );

		// ミリ秒を含むUnixタイムスタンプを得る。true:数値（float）で取得する。
		$timestamp = microtime ( true );
		return $timestamp;
	}

	public static function makeTimeText($format, float $unixTimestamp) {

		// 日時とミリ秒に分割する。
		$timeInfo = explode ( '.', $unixTimestamp );

		$text = date ( $format, $timeInfo [0] );
		return $text;
	}

	public static function makeUnixTimeIDText($format, float $unixTimestamp) {

		// 日時とミリ秒に分割する。
		$timeInfo = explode ( '.', $unixTimestamp );

		$text = date ( $format, $timeInfo [0] ) . '-' . $timeInfo [1];
		return $text;
	}
}
