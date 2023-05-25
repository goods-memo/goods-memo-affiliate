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
namespace goodsmemo\option\rakuten;

use goodsmemo\option\field\TextFieldInfo;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

/**
 * Description of CommonRESTParagraphUtils
 *
 * @author Goods Memo
 */
class CommonRESTParagraphUtils {
	const APPLICATION_ID_ID = RakutenSettingSection::ID_PREFIX . "_application_id_id";
	const AFFILIATE_ID_ID = RakutenSettingSection::ID_PREFIX . "_affiliate_id_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$applicationIDFieldInfo = new TextFieldInfo ();
		$applicationIDFieldInfo->setFieldID ( CommonRESTParagraphUtils::APPLICATION_ID_ID );
		$applicationIDFieldInfo->setFieldLabel ( '楽天アプリID/デベロッパーID' );
		array_push ( $fieldInfoArray, $applicationIDFieldInfo );

		$affiliateIDFieldInfo = new TextFieldInfo ();
		$affiliateIDFieldInfo->setFieldID ( CommonRESTParagraphUtils::AFFILIATE_ID_ID );
		$affiliateIDFieldInfo->setFieldLabel ( '楽天アフィリエイトID' );
		array_push ( $fieldInfoArray, $affiliateIDFieldInfo );

		return $fieldInfoArray;
	}
}
