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

use goodsmemo\option\paragraph\ParagraphUtils;

require_once GOODS_MEMO_DIR . "option/paragraph/ParagraphUtils.php";

/**
 * Description of AbstractTextParagraph
 *
 * @author Goods Memo
 */
trait AbstractTextParagraph {

    //AbstractParagraphクラスから、テキストフィールドの検証処理を取り出した。
    //AbstractTextParagraph extends AbstractParagraph をやめた。
    //AbstractTextParagraphの子クラスで、input type="text"以外の部品（チェックボックスやセレクトのタグ）を使う場合があるため。
    //
    //このトレイト使うなら、以下のメソッドを実装していること
    abstract public function getFieldInfoArray();

    abstract public function getOptionGroup();

    abstract public function getSectionTitle();

    public function validateMoreThanZero($inputedValueMap) {

	$fieldInfoArray = parent::getFieldInfoArray();
	$optionGroup = parent::getOptionGroup();
	$sectionTitle = parent::getSectionTitle();

	//入力値の検証処理は、段落「画面クラス」の処理でないと判断しました。
	ParagraphUtils::validateMoreThanZero($inputedValueMap, $fieldInfoArray, $optionGroup, $sectionTitle);
    }

    public function validateExistence($inputedValueMap) {

	$fieldInfoArray = parent::getFieldInfoArray();
	$optionGroup = parent::getOptionGroup();
	$sectionTitle = parent::getSectionTitle();

	//入力値の検証処理は、段落「画面クラス」の処理でないと判断しました。
	ParagraphUtils::validateExistence($inputedValueMap, $fieldInfoArray, $optionGroup, $sectionTitle);
    }

}
