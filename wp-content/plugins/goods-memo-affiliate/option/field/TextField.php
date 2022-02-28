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

use goodsmemo\option\field\AbstractTextField;
use goodsmemo\option\field\FieldInfo;

require_once GOODS_MEMO_DIR . "option/field/AbstractTextField.php";
require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";

/**
 * Description of TextField
 *
 * @author Goods Memo
 */
class TextField extends AbstractTextField {

    public function __construct($optionNameOfDatabase, FieldInfo $fieldInfo) {

	parent::__construct($optionNameOfDatabase, $fieldInfo);
    }

    public function printField() {

	$optionNameOfDatabase = parent::getOptionNameOfDatabase();
	$fieldInfo = parent::getFieldInfo();

	$textFieldID = $fieldInfo->getFieldID();
	$defaultValue = $fieldInfo->getDefaultFieldValue();

	$format = <<< EOD
<input type="text" id="{$textFieldID}" name="{$optionNameOfDatabase}[{$textFieldID}]" size="50" maxlength="50" value="%s" />
EOD;

	parent::printInputField($format, $textFieldID, $defaultValue);
    }

}
