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
use goodsmemo\option\field\CheckboxFieldInfo;

require_once GOODS_MEMO_DIR . "option/field/AbstractField.php";
require_once GOODS_MEMO_DIR . "option/field/CheckboxFieldInfo.php";

/**
 * Description of CheckboxField
 *
 * @author Goods Memo
 */
class CheckboxField extends AbstractField {
	private $checkedValue;
	private $labelForCheckbox;

	public function __construct($optionNameOfDatabase, CheckboxFieldInfo $fieldInfo, $checkedValue, $labelForCheckbox) {

		parent::__construct ( $optionNameOfDatabase, $fieldInfo );
		$this->checkedValue = $checkedValue;
		$this->labelForCheckbox = $labelForCheckbox;
	}

	public function printField() {

		$optionMap = parent::getOptionMap (); // var_dump($optionMap);
		$fieldInfo = parent::getFieldInfo ();
		$checkboxFieldID = $fieldInfo->getFieldID (); // var_dump($selectFieldID);

		$valueOfDatabase;
		if (isset ( $optionMap [$checkboxFieldID] )) { // nullでない
			$valueOfDatabase = esc_attr ( $optionMap [$checkboxFieldID] );
		} else {
			// 参考：チェックボックスがチェックされていなかった場合、
			// チェックされていない状態を表す値（value=unchecked など）が送信されることはなく、
			// 値はサーバーに全く送信されません。
			$valueOfDatabase = "";
		} // var_dump($valueOfDatabase);

		$outputValue;
		if ($valueOfDatabase) { // emptyでない。例えば "-1" も有効となる。
			$outputValue = $valueOfDatabase;
		} else { // ゼロまたは空文字
			$outputValue = $fieldInfo->getDefaultFieldValue ();
		}

		$optionNameOfDatabase = parent::getOptionNameOfDatabase ();
		$checkedAttribute = checked ( $this->checkedValue, $outputValue, false );

		$checkboxTag = <<< EOD
		<input type="checkbox" id="{$checkboxFieldID}" name="{$optionNameOfDatabase}[{$checkboxFieldID}]" value="{$this->checkedValue}" {$checkedAttribute} />
		<label for="{$checkboxFieldID}">{$this->labelForCheckbox}</label>
		EOD;

		print $checkboxTag;
	}
}
