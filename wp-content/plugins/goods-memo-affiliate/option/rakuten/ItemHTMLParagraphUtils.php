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
use goodsmemo\option\paragraph\ItemHTMLParagraph;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ItemHTMLParagraph.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

/**
 * Description of ItemHTMLParagraphUtils
 *
 * @author Goods Memo
 */
class ItemHTMLParagraphUtils {

    const DEFAULT_NUMBER_TO_DISPLAY = 1;
    //
    const TITLE_LENGTH_ID = RakutenSettingSection::ID_PREFIX . "_title_length_id";
    const CACHE_EXPIRATION_IN_SECONDS_ID = RakutenSettingSection::ID_PREFIX . "_cache_expiration_in_seconds_id";

    public static function makeFieldInfoArray() {

	$fieldInfoArray = array();

	$titleLengthFieldInfo = new FieldInfo();
	$titleLengthFieldInfo->setFieldID(ItemHTMLParagraphUtils::TITLE_LENGTH_ID);
	$titleLengthFieldInfo->setFieldLabel(ItemHTMLParagraph::DEFAULT_TITLE_LENGTH_LABEL);
	$titleLengthFieldInfo->setDefaultFieldValue(ItemHTMLParagraph::DEFAULT_TITLE_LENGTH_VALUE);
	$titleLengthFieldInfo->setNumericalVerificationEnabled(true);
	array_push($fieldInfoArray, $titleLengthFieldInfo);

	$cacheExpirationInSecondsFieldInfo = new FieldInfo();
	$cacheExpirationInSecondsFieldInfo->setFieldID(ItemHTMLParagraphUtils::CACHE_EXPIRATION_IN_SECONDS_ID);
	$cacheExpirationInSecondsFieldInfo->setFieldLabel(
		ItemHTMLParagraph::DEFAULT_CACHE_EXPIRATION_IN_SECONDS_LABEL);
	$cacheExpirationInSecondsFieldInfo->setDefaultFieldValue(
		ItemHTMLParagraph::DEFAULT_CACHE_EXPIRATION_IN_SECONDS_VALUE);
	$cacheExpirationInSecondsFieldInfo->setNumericalVerificationEnabled(true);
	array_push($fieldInfoArray, $cacheExpirationInSecondsFieldInfo);

	return $fieldInfoArray;
    }

}
