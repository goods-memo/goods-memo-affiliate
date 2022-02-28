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

use goodsmemo\option\field\FieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

/**
 * Description of SearchWidgetParagraphUtils
 *
 * @author Goods Memo
 */
class SearchWidgetParagraphUtils {

	const SEARCH_WIDGET_ID = AmazonSettingSection::ID_PREFIX . "_search_widget_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array();

		$searchWidgetFieldInfo = new FieldInfo();
		$searchWidgetFieldInfo->setFieldID(SearchWidgetParagraphUtils::SEARCH_WIDGET_ID);
		$searchWidgetFieldInfo->setFieldLabel('サーチウィジェットJavascript（上記項目の「Product Advertising API アソシエイトタグ」を利用する）');
		$searchWidgetFieldInfo->setDefaultFieldValue("");
		array_push($fieldInfoArray, $searchWidgetFieldInfo);

		return $fieldInfoArray;
	}

}
