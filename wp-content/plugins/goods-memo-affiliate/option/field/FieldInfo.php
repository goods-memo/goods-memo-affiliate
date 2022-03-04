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
	private int $rows = 3; // 例：textareaタグの行数
	private bool $existenceVerificationEnabled = true;
	private bool $moreThanZeroVerificationEnabled = false;
	private bool $htmlSpecialcharsConversionEnabled = false;

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
	 * @return number
	 */
	public function getRows(): int {

		return $this->rows;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getExistenceVerificationEnabled(): bool {

		return $this->existenceVerificationEnabled;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getMoreThanZeroVerificationEnabled(): bool {

		return $this->moreThanZeroVerificationEnabled;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getHtmlSpecialcharsConversionEnabled(): bool {

		return $this->htmlSpecialcharsConversionEnabled;
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
	 * @param number $rows
	 */
	public function setRows(int $rows) {

		$this->rows = $rows;
	}

	/**
	 *
	 * @param boolean $existenceVerificationEnabled
	 */
	public function setExistenceVerificationEnabled(bool $existenceVerificationEnabled) {

		$this->existenceVerificationEnabled = $existenceVerificationEnabled;
	}

	/**
	 *
	 * @param boolean $moreThanZeroVerificationEnabled
	 */
	public function setMoreThanZeroVerificationEnabled(bool $moreThanZeroVerificationEnabled) {

		$this->moreThanZeroVerificationEnabled = $moreThanZeroVerificationEnabled;
	}

	/**
	 *
	 * @param boolean $htmlSpecialcharsConversionEnabled
	 */
	public function setHtmlSpecialcharsConversionEnabled(bool $htmlSpecialcharsConversionEnabled) {

		$this->htmlSpecialcharsConversionEnabled = $htmlSpecialcharsConversionEnabled;
	}

	public function enableMoreThanZeroVerification() {

		$this->setExistenceVerificationEnabled ( false ); // 未入力検査を2回実行するのを防ぐ
		$this->setMoreThanZeroVerificationEnabled ( true ); // 未入力、0以上、共に検査する
	}
}
