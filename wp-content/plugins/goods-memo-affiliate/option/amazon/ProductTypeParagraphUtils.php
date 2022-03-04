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
namespace goodsmemo\option\amazon;

use goodsmemo\option\field\FieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

/**
 * Description of ProductTypeFieldUtils
 *
 * @author Goods Memo
 */
class ProductTypeParagraphUtils {
	const ADULT_PRODUCT_ID = AmazonSettingSection::ID_PREFIX . "_adult_product_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$adultProductFieldInfo = new FieldInfo ();
		$adultProductFieldInfo->setFieldID ( ProductTypeParagraphUtils::ADULT_PRODUCT_ID );
		$adultProductFieldInfo->setFieldLabel ( 'アダルト商品（ItemInfo の ProductInfo の IsAdultProductで判断）' );
		$adultProductFieldInfo->setDefaultFieldValue ( "" );
		$adultProductFieldInfo->setExistenceVerificationEnabled ( false ); // チェックボックスでは値の存在検査をしない。
		array_push ( $fieldInfoArray, $adultProductFieldInfo );

		return $fieldInfoArray;
	}
}
