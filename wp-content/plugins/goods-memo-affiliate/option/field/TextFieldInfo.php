<?php

namespace goodsmemo\option\field;

use goodsmemo\option\field\AbstractFieldInfo;

require_once GOODS_MEMO_DIR . "option/field/AbstractFieldInfo.php";

/**
 *
 * @author kijim
 *        
 */
class TextFieldInfo extends AbstractFieldInfo {
	private string $defaultFieldValue = "";
	private bool $existenceVerificationEnabled = TRUE;
	private bool $moreThanZeroVerificationEnabled = FALSE;

	public function getDefaultFieldValue(): string {

		return $this->defaultFieldValue;
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

	public function setDefaultFieldValue(string $defaultFieldValue) {

		$this->defaultFieldValue = $defaultFieldValue;
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

	public function enableMoreThanZeroVerification() {

		$this->setExistenceVerificationEnabled ( FALSE ); // 未入力検査を2回実行するのを防ぐ
		$this->setMoreThanZeroVerificationEnabled ( TRUE ); // 未入力、0以上、共に検査する
	}
}

