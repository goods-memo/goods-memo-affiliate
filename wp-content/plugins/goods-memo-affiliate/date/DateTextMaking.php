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

namespace goodsmemo\date;

/**
 * Description of DateTextMaking
 *
 * @author Goods Memo
 */
class DateTextMaking {

    const TIME_TEXT_FORMAT = "Y年n月j日 H:i"; //例：2018年10月6日 21:23
    const UNIX_TIME_ID_FORMAT = "Y-m-d-H-i-s"; //例：HTMLタグのIDに使う。

    public static function getUnixTimeMillSecond(): float {

	date_default_timezone_set('Asia/Tokyo');

	//ミリ秒を含むUnixタイムスタンプを得る。true:数値（float）で取得する。
	$timestamp = microtime(true);
	return $timestamp;
    }

    public static function makeTimeText($format, float $unixTimestamp) {

	//日時とミリ秒に分割する。
	$timeInfo = explode('.', $unixTimestamp);

	$text = date($format, $timeInfo[0]);
	return $text;
    }

    public static function makeUnixTimeIDText($format, float $unixTimestamp) {

	//日時とミリ秒に分割する。
	$timeInfo = explode('.', $unixTimestamp);

	$text = date($format, $timeInfo[0]) . '-' . $timeInfo[1];
	return $text;
    }

}
