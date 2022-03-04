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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301 USA
 */
namespace goodsmemo\option\field;

/**
 * Description of FieldInfo
 *
 * @author Goods Memo
 */
class FieldInfo {
	private $fieldID;
	private $fieldLabel;
	private $defaultFieldValue = "";
	private $existenceVerificationEnabled = true;
	private $moreThanZeroVerificationEnabled = false;

	public function getFieldID() {

		return $this->fieldID;
	}

	public function getFieldLabel() {

		return $this->fieldLabel;
	}

	public function getDefaultFieldValue() {

		return $this->defaultFieldValue;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getExistenceVerificationEnabled() {

		return $this->existenceVerificationEnabled;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getMoreThanZeroVerificationEnabled() {

		return $this->moreThanZeroVerificationEnabled;
	}

	public function setFieldID($fieldID) {

		$this->fieldID = $fieldID;
	}

	public function setFieldLabel($fieldLabel) {

		$this->fieldLabel = $fieldLabel;
	}

	public function setDefaultFieldValue($defaultFieldValue) {

		$this->defaultFieldValue = $defaultFieldValue;
	}

	/**
	 *
	 * @param boolean $existenceVerificationEnabled
	 */
	public function setExistenceVerificationEnabled($existenceVerificationEnabled) {

		$this->existenceVerificationEnabled = $existenceVerificationEnabled;
	}

	/**
	 *
	 * @param boolean $moreThanZeroVerificationEnabled
	 */
	public function setMoreThanZeroVerificationEnabled($moreThanZeroVerificationEnabled) {

		$this->moreThanZeroVerificationEnabled = $moreThanZeroVerificationEnabled;
	}

	public function enableMoreThanZeroVerification() {

		$this->setExistenceVerificationEnabled ( false ); // 未入力検査を2回実行するのを防ぐ
		$this->setMoreThanZeroVerificationEnabled ( true ); // 未入力、0以上、共に検査する
	}
}
