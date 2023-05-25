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

use goodsmemo\option\field\FieldPrinter;
use goodsmemo\option\field\AbstractFieldInfo;

require_once GOODS_MEMO_DIR . "option/field/FieldPrinter.php";
require_once GOODS_MEMO_DIR . "option/field/AbstractFieldInfo.php";

/**
 * Description of AbstractField
 *
 * @author Goods Memo
 */
abstract class AbstractField implements FieldPrinter {
	private $optionNameOfDatabase;

	// protected $optionMap;//superを使って、メンバ変数にアクセスできない。$this->optionMap;と書くらしい。
	// parent::set()と書くことにした。
	private $optionMap = array (); // 最初に「アフィリエイトの設定」画面を表示した際、OptionExceptionが通知される。その時、空の配列としておく。
	private $fieldInfo;

	public function __construct($optionNameOfDatabase, AbstractFieldInfo $fieldInfo) {

		$this->optionNameOfDatabase = $optionNameOfDatabase;
		$this->fieldInfo = $fieldInfo;
	}

	public function getOptionNameOfDatabase() {

		return $this->optionNameOfDatabase;
	}

	public function getOptionMap() {

		return $this->optionMap;
	}

	public function setOptionMap($optionMap) {

		$this->optionMap = $optionMap;
	}

	public function getFieldInfo() {

		return $this->fieldInfo;
	}
}
