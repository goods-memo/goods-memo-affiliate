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

namespace goodsmemo\option\amazon;

use goodsmemo\option\paragraph\AbstractParagraph;
use goodsmemo\option\paragraph\AbstractTextParagraph;
use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\field\TextareaField;

require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractTextParagraph.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/field/TextareaField.php";

/**
 * Description of RESTParagraph
 *
 * @author Goods Memo
 */
class RESTParagraph extends AbstractParagraph {

	use AbstractTextParagraph;

	public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray) {

		parent::setOptionGroup($pageInfo->getOptionGroup());
		parent::setSectionTitle($sectionInfo->getSectionTitle());
		parent::setFieldInfoArray($fieldInfoArray);

		$searchItemsResourcesTextarea = new TextareaField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[0]);
		parent::addField($pageInfo, $sectionInfo, $searchItemsResourcesTextarea);
	}

	public function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap) {
		//sanitizedValueMap：変更するため、配列の参照渡しとする。

		$this->validateExistence($inputedValueMap);
		parent::sanitizeParagraphValue($inputedValueMap, $sanitizedValueMap);
	}

}
