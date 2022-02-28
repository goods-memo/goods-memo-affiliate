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

namespace goodsmemo\option;

use goodsmemo\option\AffiliateSettingPage;
use goodsmemo\exception\OptionException;

require_once GOODS_MEMO_DIR . "option/AffiliateSettingPage.php";
require_once GOODS_MEMO_DIR . "exception/OptionException.php";

/**
 * Description of AffiliateOptionUtils
 *
 * @author Goods Memo
 */
class AffiliateOptionUtils {

    public static function getAffiliateOption() {

	$optionMap = get_option(AffiliateSettingPage::OPTION_NAME_OF_DATABASE); //var_dump($optionMap);
	if ($optionMap === false) {
	    throw new OptionException("データベースに[" . AffiliateSettingPage::OPTION_NAME_OF_DATABASE . "]オプションが、存在しません。");
	}

	$filteredArray = array_filter($optionMap); //コールバック関数を省略した場合、配列のfalseに相当する値が全て削除される。
	if (empty($filteredArray)) {
	    throw new OptionException("アフィリエイトの設定が、ありません。");
	}

	return $optionMap;
    }

}
