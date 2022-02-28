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

namespace goodsmemo\option\rakuten;

use goodsmemo\option\field\FieldInfo;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

/**
 * Description of URLParagraphUtils
 *
 * @author Goods Memo
 */
class URLParagraphUtils {

    const HOSTNAME_ID = RakutenSettingSection::ID_PREFIX . "_hostname_id";
    const PATH_ID = RakutenSettingSection::ID_PREFIX . "_path_id";

    public static function makeFieldInfoArray() {

	$fieldInfoArray = array();

	$hostnameFieldInfo = new FieldInfo();
	$hostnameFieldInfo->setFieldID(URLParagraphUtils::HOSTNAME_ID);
	$hostnameFieldInfo->setFieldLabel('楽天商品検索API ホスト名');
	$hostnameFieldInfo->setDefaultFieldValue("app.rakuten.co.jp");
	array_push($fieldInfoArray, $hostnameFieldInfo);

	$pathFieldInfo = new FieldInfo();
	$pathFieldInfo->setFieldID(URLParagraphUtils::PATH_ID);
	$pathFieldInfo->setFieldLabel('楽天商品検索API リクエストURLのパス');
	$pathFieldInfo->setDefaultFieldValue("services/api/IchibaItem/Search/20170706");
	array_push($fieldInfoArray, $pathFieldInfo);

	return $fieldInfoArray;
    }

}
