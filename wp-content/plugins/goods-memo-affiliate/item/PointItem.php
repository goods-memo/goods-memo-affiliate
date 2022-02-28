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
 * Description of PointItem
 *
 * @author Goods Memo
 */
class PointItem {

    //今の所、楽天だけで使うアイテムクラス。
    private $pointRate = "";
    private $pointRateStartTime = "";
    private $pointRateEndTime = "";

    public function getPointRate() {
	return $this->pointRate;
    }

    public function getPointRateStartTime() {
	return $this->pointRateStartTime;
    }

    public function getPointRateEndTime() {
	return $this->pointRateEndTime;
    }

    public function setPointRate($pointRate) {
	$this->pointRate = $pointRate;
    }

    public function setPointRateStartTime($pointRateStartTime) {
	$this->pointRateStartTime = $pointRateStartTime;
    }

    public function setPointRateEndTime($pointRateEndTime) {
	$this->pointRateEndTime = $pointRateEndTime;
    }

}
