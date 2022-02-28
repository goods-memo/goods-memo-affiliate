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

namespace goodsmemo\rakuten;

use goodsmemo\item\PointItem;
use goodsmemo\item\html\HTMLUtils;
use goodsmemo\date\DateComparison;
use goodsmemo\exception\TimeException;

require_once GOODS_MEMO_DIR . "item/PointItem.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
require_once GOODS_MEMO_DIR . "date/DateComparison.php";
require_once GOODS_MEMO_DIR . "exception/TimeException.php";

/**
 * Description of PointResponse
 *
 * @author Goods Memo
 */
class PointResponse {

    public static function makePointItem($node, float $priceTime): PointItem {

	$pointRate = HTMLUtils::makePlainText($node->{'pointRate'});

	$isPointRateVisible;
	if (is_numeric($pointRate)) {
	    $pointRateValue = intval($pointRate);
	    if ($pointRateValue >= 2) {
		$isPointRateVisible = true;
	    } else {
		$isPointRateVisible = false;
	    }
	} else {
	    $isPointRateVisible = false;
	}

	$pointRateStartTime = HTMLUtils::makePlainText($node->{'pointRateStartTime'});
	$pointRateEndTime = HTMLUtils::makePlainText($node->{'pointRateEndTime'});

	$isDuringThePeriod;
	if ($pointRateStartTime && $pointRateEndTime) {
	    try {
		$isDuringThePeriod = DateComparison::isDuringThePeriod($pointRateStartTime, $pointRateEndTime, $priceTime);
	    } catch (TimeException $ex) {
		$isDuringThePeriod = false;
	    }
	} else {
	    $isDuringThePeriod = false;
	}

	$pointItem = new PointItem();
	if ($isPointRateVisible && $isDuringThePeriod) {

	    $pointItem->setPointRate($pointRate);
	    $pointItem->setPointRateStartTime($pointRateStartTime);
	    $pointItem->setPointRateEndTime($pointRateEndTime);
	}

	return $pointItem;
    }

}
