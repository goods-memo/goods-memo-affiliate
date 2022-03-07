<?php

namespace goodsmemo\option\field;

use goodsmemo\option\field\TextFieldInfo;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";

/**
 *
 * @author kijim
 *        
 */
class TextareaFieldInfo extends TextFieldInfo {
	// 例：textareaタグの行数
	private int $rows = 3;
	private bool $htmlTagEnabled = false;

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
	public function getHtmlTagEnabled(): bool {

		return $this->htmlTagEnabled;
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
	 * @param boolean $htmlTagEnabled
	 */
	public function setHtmlTagEnabled(bool $htmlTagEnabled) {

		$this->htmlTagEnabled = $htmlTagEnabled;
	}
}

