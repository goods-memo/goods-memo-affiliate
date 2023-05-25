<?php

namespace goodsmemo\item;

class PointItem {

	// 今の所、楽天だけで使うアイテムクラス。
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
