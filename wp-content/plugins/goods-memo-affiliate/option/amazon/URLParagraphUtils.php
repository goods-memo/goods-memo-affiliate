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

use goodsmemo\option\field\FieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

/**
 * Description of URLParagraphUtils
 *
 * @author Goods Memo
 */
class URLParagraphUtils {

	const HOSTNAME_ID = AmazonSettingSection::ID_PREFIX . "_hostname_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array();

		$hostnameFieldInfo = new FieldInfo();
		$hostnameFieldInfo->setFieldID(URLParagraphUtils::HOSTNAME_ID);
		$hostnameFieldInfo->setFieldLabel('Product Advertising API ホスト');
		$hostnameFieldInfo->setDefaultFieldValue("webservices.amazon.co.jp");
		array_push($fieldInfoArray, $hostnameFieldInfo);

		return $fieldInfoArray;
	}

	/*
	  //const PATH_ID = AmazonSettingSection::ID_PREFIX . "_path_id";
	 *
	  //		$pathFieldInfo = new FieldInfo();
	  //		$pathFieldInfo->setFieldID(URLParagraphUtils::PATH_ID);
	  //		$pathFieldInfo->setFieldLabel('Product Advertising API URI（パス部分）');
	  //		$pathFieldInfo->setDefaultFieldValue("/onca/xml");
	  //		array_push($fieldInfoArray, $pathFieldInfo);
	 *
	 */
}
