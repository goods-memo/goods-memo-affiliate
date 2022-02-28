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

namespace goodsmemo\text;

/**
 * Description of StringUtils
 *
 * @author Goods Memo
 */
class TextUtils {

    public static function startsWith($haystack, $needle) {
	return (strpos($haystack, $needle) === 0);
    }

    public static function mb_strimwidth(string $str, int $start, int $width, $trimmarker = "", $encoding = "UTF-8") {

	//mb_strimwidth()：全角を2，半角を1として数えて、指定した幅で切り取る。
	//mb_strimwidthの$trimmarker引数が「３点リーダー文字」の場合、数え間違いするらしい？
	//全角の３点リーダー文字を、半角と判断するらしい。
	//var_dump($encoding);
	$trimmedText = mb_strimwidth($str, $start, $width, "", $encoding); //$trimmarker引数に、空文字を指定する。

	$cmpValue = strcmp($str, $trimmedText); //等しければ 0 を返します。

	if ($cmpValue <> 0 && $trimmedText) {//文字列が切り取られた、かつ、文字が存在するなら
	    $trimmedText .= $trimmarker; //例：ここで$trimmarker「３点リーダー文字」を、結合する。
	}

	return $trimmedText;
    }

}
