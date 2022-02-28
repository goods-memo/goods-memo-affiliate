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
 * Description of ProductionItem
 *
 * @author Goods Memo
 */
class ProductionItem {

	private $contributorArray = array(); //空のオブジェクト作成に対応するため、空の配列を設定する。
	//
	private $manufacturerLabel = "";
	private $manufacturer = ""; //製造元、メーカー
	//
	private $binding = ""; //装丁、形式、種別

	public function getContributorArray() {
		return $this->contributorArray;
	}

	public function getManufacturerLabel() {
		return $this->manufacturerLabel;
	}

	public function getManufacturer() {
		return $this->manufacturer;
	}

	public function getBinding() {
		return $this->binding;
	}

	public function setContributorArray($contributorArray) {
		$this->contributorArray = $contributorArray;
	}

	public function setManufacturerLabel($manufacturerLabel) {
		$this->manufacturerLabel = $manufacturerLabel;
	}

	public function setManufacturer($manufacturer) {
		$this->manufacturer = $manufacturer;
	}

	public function setBinding($binding) {
		$this->binding = $binding;
	}

}
