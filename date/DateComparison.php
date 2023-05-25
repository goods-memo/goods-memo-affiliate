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

use goodsmemo\exception\TimeException;

require_once GOODS_MEMO_DIR . "exception/TimeException.php";

/**
 * Description of DateComparison
 *
 * @author Goods Memo
 */
class DateComparison {

    public static function isDuringThePeriod($startTimeText, $endTimeText, float $targetUnixTimeMillSecond): bool {

	date_default_timezone_set('Asia/Tokyo');

	$startTime = strtotime($startTimeText); //strtotime(日時) 戻り値はint //var_dump($startTimeText);var_dump($startTime);
	if ($startTime === false) {
	    throw new TimeException("無効な開始時刻文字列:" . $startTimeText);
	}

	$endTime = strtotime($endTimeText); //var_dump($endTimeText);var_dump($endTime);
	if ($endTime === false) {
	    throw new TimeException("無効な終了時刻文字列:" . $endTimeText);
	}

	$targetTime = (int) $targetUnixTimeMillSecond; //var_dump($targetUnixTimeMillSecond);var_dump($targetTime);
	//対象時刻は、開始時刻と終了時刻の期間内か？
	if (($startTime <= $targetTime) && ($targetTime <= $endTime)) {
	    return true;
	} else {
	    return false;
	}
    }

}
