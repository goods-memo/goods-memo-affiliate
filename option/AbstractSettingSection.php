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

namespace goodsmemo\option;

use goodsmemo\option\SettingSection;
use goodsmemo\option\PageInfo;
use goodsmemo\option\paragraph\AbstractParagraph;

require_once GOODS_MEMO_DIR . "option/SettingSection.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";

/**
 * Description of AbstractSettingSection
 *
 * @author Goods Memo
 */
abstract class AbstractSettingSection implements SettingSection {

    private $paragraphArray = array();

    abstract public function initSection(PageInfo $pageInfo);

    protected function addParagraph(AbstractParagraph $paragraph) {

	array_push($this->paragraphArray, $paragraph);
    }

    public function setOptionMap($optionMap) {

	foreach ($this->paragraphArray as $paragraph) {
	    $paragraph->setOptionMap($optionMap);
	}
    }

    public function sanitizeSectionValue($inputedValueMap, &$sanitizedValueMap) {
	//sanitizedValueMap：変更するため、配列の参照渡しとする。

	foreach ($this->paragraphArray as $paragraph) {
	    $paragraph->sanitizeParagraphValue($inputedValueMap, $sanitizedValueMap);
	}
    }

}
