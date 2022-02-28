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

namespace goodsmemo\option\field;

use goodsmemo\option\field\AbstractField;
use goodsmemo\option\field\FieldInfo;

require_once GOODS_MEMO_DIR . "option/field/AbstractField.php";
require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";

/**
 * Description of SelectField
 *
 * @author Goods Memo
 */
class SelectField extends AbstractField {

    private $valueTitleMap;

    public function __construct($optionNameOfDatabase, FieldInfo $fieldInfo, $valueTitleMap) {

	parent::__construct($optionNameOfDatabase, $fieldInfo);
	$this->valueTitleMap = $valueTitleMap;
    }

    public function printField() {

	$optionMap = parent::getOptionMap(); //var_dump($optionMap);
	$fieldInfo = parent::getFieldInfo();
	$selectFieldID = $fieldInfo->getFieldID(); //var_dump($selectFieldID);

	$valueOfDatabase;
	if (isset($optionMap[$selectFieldID])) {//nullでない
	    $valueOfDatabase = esc_attr($optionMap[$selectFieldID]);
	} else {
	    $valueOfDatabase = "";
	}

	$outputValue;
	if ($valueOfDatabase) {//emptyでない。例えば "-1" も有効となる。
	    $outputValue = $valueOfDatabase;
	} else {//ゼロまたは空文字
	    $outputValue = $fieldInfo->getDefaultFieldValue();
	}

	$optionNameOfDatabase = parent::getOptionNameOfDatabase();

	$startTag = <<< EOD
<select id="{$selectFieldID}" name="{$optionNameOfDatabase}[{$selectFieldID}]" >
EOD;

	$optionsTag = "";
	foreach ($this->valueTitleMap as $value => $title) {

	    $selectedAttribute = selected($value, $outputValue, false);
	    $oneOptionTag = <<< EOD
<option value="{$value}" {$selectedAttribute} >{$title}</option>
EOD;
	    $optionsTag .= $oneOptionTag;
	}

	$endTag = "</select>";

	print $startTag . $optionsTag . $endTag;
    }

}
