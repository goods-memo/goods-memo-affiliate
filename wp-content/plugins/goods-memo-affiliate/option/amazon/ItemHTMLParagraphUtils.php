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
use goodsmemo\option\paragraph\ItemHTMLParagraph;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ItemHTMLParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

/**
 * Description of ItemHTMLParagraphUtils
 *
 * @author Goods Memo
 */
class ItemHTMLParagraphUtils {
	const DEFAULT_NUMBER_TO_DISPLAY = 1;
	//
	const TITLE_LENGTH_ID = AmazonSettingSection::ID_PREFIX . "_title_length_id";
	const CACHE_EXPIRATION_IN_SECONDS_ID = AmazonSettingSection::ID_PREFIX . "_cache_expiration_in_seconds_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$titleLengthFieldInfo = new TextFieldInfo ();
		$titleLengthFieldInfo->setFieldID ( ItemHTMLParagraphUtils::TITLE_LENGTH_ID );
		$titleLengthFieldInfo->setFieldLabel ( ItemHTMLParagraph::DEFAULT_TITLE_LENGTH_LABEL );
		$titleLengthFieldInfo->setDefaultFieldValue ( ItemHTMLParagraph::DEFAULT_TITLE_LENGTH_VALUE );
		$titleLengthFieldInfo->enableMoreThanZeroVerification ();
		array_push ( $fieldInfoArray, $titleLengthFieldInfo );

		$cacheExpirationInSecondsFieldInfo = new TextFieldInfo ();
		$cacheExpirationInSecondsFieldInfo->setFieldID ( ItemHTMLParagraphUtils::CACHE_EXPIRATION_IN_SECONDS_ID );
		$cacheExpirationInSecondsFieldInfo->setFieldLabel ( ItemHTMLParagraph::DEFAULT_CACHE_EXPIRATION_IN_SECONDS_LABEL );
		// Product Advertising APIの場合、初期リクエスト可能数 : 1日あたり 8,640リクエスト
		$cacheExpirationInSecondsFieldInfo->setDefaultFieldValue ( ItemHTMLParagraph::DEFAULT_CACHE_EXPIRATION_IN_SECONDS_VALUE );
		$cacheExpirationInSecondsFieldInfo->enableMoreThanZeroVerification ();
		array_push ( $fieldInfoArray, $cacheExpirationInSecondsFieldInfo );

		return $fieldInfoArray;
	}
}
