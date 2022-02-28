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
 * Description of TextareaField
 *
 * @author Goods Memo
 */
class TextareaField extends AbstractTextField {

    public function __construct($optionNameOfDatabase, FieldInfo $fieldInfo) {

	parent::__construct($optionNameOfDatabase, $fieldInfo);
    }

    public function printField() {

	$optionNameOfDatabase = parent::getOptionNameOfDatabase();
	$fieldInfo = parent::getFieldInfo();

	$textareaID = $fieldInfo->getFieldID();
	$defaultValue = $fieldInfo->getDefaultFieldValue();

	$format = <<< EOD
<textarea id="{$textareaID}" name="{$optionNameOfDatabase}[{$textareaID}]" rows="3" cols="50" maxlength="1050">%s</textarea>
EOD;

	parent::printInputField($format, $textareaID, $defaultValue);
    }

}
