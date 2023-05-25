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

use goodsmemo\option\field\TextFieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

/**
 * Description of CommonRESTParagraphUtils
 *
 * @author Goods Memo
 */
class CommonRESTParagraphUtils {
	const PAA_ACCESS_KEY_ID = AmazonSettingSection::ID_PREFIX . "_paa_access_key_id";
	const PAA_ASSOCIATE_TAG_ID = AmazonSettingSection::ID_PREFIX . "_paa_associate_tag_id";
	const PAA_SECRET_KEY_ID = AmazonSettingSection::ID_PREFIX . "_paa_secret_key_id";
	const PAA_REGION_ID = AmazonSettingSection::ID_PREFIX . "_paa_region_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$paaAccessKeyFieldInfo = new TextFieldInfo ();
		$paaAccessKeyFieldInfo->setFieldID ( CommonRESTParagraphUtils::PAA_ACCESS_KEY_ID );
		$paaAccessKeyFieldInfo->setFieldLabel ( 'Product Advertising API アクセスキー' );
		array_push ( $fieldInfoArray, $paaAccessKeyFieldInfo );

		$paaAssociateTagFieldInfo = new TextFieldInfo ();
		$paaAssociateTagFieldInfo->setFieldID ( CommonRESTParagraphUtils::PAA_ASSOCIATE_TAG_ID );
		$paaAssociateTagFieldInfo->setFieldLabel ( 'Product Advertising API アソシエイトタグ' );
		array_push ( $fieldInfoArray, $paaAssociateTagFieldInfo );

		$paaSecretKeyFieldInfo = new TextFieldInfo ();
		$paaSecretKeyFieldInfo->setFieldID ( CommonRESTParagraphUtils::PAA_SECRET_KEY_ID );
		$paaSecretKeyFieldInfo->setFieldLabel ( 'Product Advertising API シークレットキー' );
		array_push ( $fieldInfoArray, $paaSecretKeyFieldInfo );

		$paaRegionFieldInfo = new TextFieldInfo ();
		$paaRegionFieldInfo->setFieldID ( CommonRESTParagraphUtils::PAA_REGION_ID );
		$paaRegionFieldInfo->setFieldLabel ( 'Product Advertising API リージョン（例：Japanの場合 us-west-2）' );
		$paaRegionFieldInfo->setDefaultFieldValue ( "us-west-2" );
		array_push ( $fieldInfoArray, $paaRegionFieldInfo );

		return $fieldInfoArray;
	}
}
