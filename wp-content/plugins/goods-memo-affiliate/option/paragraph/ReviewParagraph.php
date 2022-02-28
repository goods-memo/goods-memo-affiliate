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

namespace goodsmemo\option\paragraph;

use goodsmemo\option\paragraph\AbstractParagraph;
use goodsmemo\option\paragraph\AbstractTextParagraph;
use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\field\TextField;
use goodsmemo\option\field\TextareaField;

require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractTextParagraph.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/field/TextField.php";
require_once GOODS_MEMO_DIR . "option/field/TextareaField.php";

/**
 * Description of ReviewParagraph
 *
 * @author Goods Memo
 */
class ReviewParagraph extends AbstractParagraph {

    use AbstractTextParagraph;

    const DEFAULT_EDITORIAL_REVIEW_LENGTH_LABEL = "商品説明の表示文字数（目安の文字数）";
    const DEFAULT_EDITORIAL_REVIEW_LENGTH_VALUE = 200;
    //
    const DEFAULT_ARRAY_OF_STRING_TO_DELETE_LABEL = "商品説明から削除する文字列の配列（JSON配列。空の配列[]）";
    const DEFAULT_ARRAY_OF_STRING_TO_DELETE_VALUE = '["＜p＞","＜/p＞","＜b＞","＜br /＞"]'; //削除する文字列の配列
    //
    const DEFAULT_ARRAY_OF_STRING_TO_BREAK_LABEL = "商品説明で改行する文字の配列（JSON配列。空の配列[]）";
    const DEFAULT_ARRAY_OF_STRING_TO_BREAK_VALUE = '["●","■","◆","★","【"]'; //改行する文字列の配列

    public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray) {

	parent::setOptionGroup($pageInfo->getOptionGroup());
	parent::setSectionTitle($sectionInfo->getSectionTitle());
	parent::setFieldInfoArray($fieldInfoArray);

	$editorialReviewLengthTextField = new TextField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[0]);
	parent::addField($pageInfo, $sectionInfo, $editorialReviewLengthTextField);

	$arrayOfStringToDeleteTextarea = new TextareaField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[1]);
	parent::addField($pageInfo, $sectionInfo, $arrayOfStringToDeleteTextarea);

	$arrayOfStringToBreakTextarea = new TextareaField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[2]);
	parent::addField($pageInfo, $sectionInfo, $arrayOfStringToBreakTextarea);
    }

    public function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap) {
	//sanitizedValueMap：変更するため、配列の参照渡しとする。

	$this->validateMoreThanZero($inputedValueMap);
	$this->validateExistence($inputedValueMap);
	parent::sanitizeParagraphValue($inputedValueMap, $sanitizedValueMap);
    }

}
