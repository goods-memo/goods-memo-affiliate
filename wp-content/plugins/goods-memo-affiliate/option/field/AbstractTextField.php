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

use goodsmemo\option\field\AbstractField;
use goodsmemo\option\field\TextFieldInfo;

require_once GOODS_MEMO_DIR . "option/field/AbstractField.php";
require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";

/**
 * Description of AbstractTextField
 *
 * @author Goods Memo
 */
abstract class AbstractTextField extends AbstractField {

	public function __construct($optionNameOfDatabase, TextFieldInfo $fieldInfo) {

		parent::__construct ( $optionNameOfDatabase, $fieldInfo );
	}

	protected function printInputField($format, $inputFieldID, $defaultValue) {

		$optionMap = parent::getOptionMap ();

		$valueOfDatabase;
		$isValidDatabaseValue;
		if (isset ( $optionMap [$inputFieldID] )) { // nullでない

			$valueOfDatabase = esc_attr ( $optionMap [$inputFieldID] );
			if ($valueOfDatabase) { // emptyでない。例えば "-1" も有効となる。

				$isValidDatabaseValue = true; // error_log(var_export($valueOfDatabase, true));
			} else { // ゼロまたは空文字

				if (is_numeric ( $valueOfDatabase )) {

					if (intval ( $valueOfDatabase ) >= 0) { // 0を有効とする。
						$isValidDatabaseValue = true;
					} else {
						$isValidDatabaseValue = false;
					}
				} else {
					$isValidDatabaseValue = false; // 空文字なので、未入力と判断する。
				}
			}
		} else {

			$isValidDatabaseValue = false;
		}

		$outputValue;
		if ($isValidDatabaseValue) {

			$outputValue = $valueOfDatabase;
		} else {

			$outputValue = $defaultValue;
		}

		printf ( $format, $outputValue );
	}
}
