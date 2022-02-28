<?php

/*
 * Copyright (C) 2019 Goods Memo.
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
use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\field\CheckboxField;

require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/field/CheckboxField.php";

/**
 * Description of SearchWidgetParagraph
 *
 * @author Goods Memo
 */
class SearchWidgetParagraph extends AbstractParagraph {

	const SEARCH_WIDGET_CHECKED_VALUE = "searchWidgetChecked";
	const SEARCH_WIDGET_LABEL_FOR_CHECKBOX = "常に表示する。Product Advertising API を、常に使用しない場合（アクセス制限のため利用できない場合）";

	public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray) {

		parent::setOptionGroup($pageInfo->getOptionGroup());
		parent::setSectionTitle($sectionInfo->getSectionTitle());
		parent::setFieldInfoArray($fieldInfoArray);

		$searchWidgetCheckboxField = new CheckboxField(
			$pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[0], //
			SearchWidgetParagraph::SEARCH_WIDGET_CHECKED_VALUE, //
			SearchWidgetParagraph::SEARCH_WIDGET_LABEL_FOR_CHECKBOX
		);
		parent::addField($pageInfo, $sectionInfo, $searchWidgetCheckboxField);
	}

}
