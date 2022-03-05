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
namespace goodsmemo\option\paragraph;

use goodsmemo\option\field\TextFieldInfo;
use goodsmemo\option\field\TextareaFieldInfo;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/field/TextareaFieldInfo.php";

/**
 * Description of ParagraphUtils
 *
 * @author Goods Memo
 */
class ParagraphUtils {

	public static function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap, $fieldInfoArray) {

		// sanitizedValueMap：変更するため、配列の参照渡しとする。
		foreach ( $fieldInfoArray as $fieldInfo ) {

			$inputFieldID = $fieldInfo->getFieldID ();
			if (isset ( $inputedValueMap [$inputFieldID] )) {
				;
			} else {
				continue;
			}

			$inputedValue = $inputedValueMap [$inputFieldID];
			if ($fieldInfo instanceof TextareaFieldInfo) {

				if ($fieldInfo->getHtmlSpecialcharsConversionEnabled ()) {
					$inputedValue = htmlspecialchars ( $inputedValue );
				}

				// sanitize_textarea_field：textarea要素の正当な入力である改行、その他の空白を保持する。
				$inputedValue = sanitize_textarea_field ( $inputedValue );
			} elseif ($fieldInfo instanceof TextFieldInfo) {

				// sanitize_text_field：改行、その他の空白も取り除く。文字エンコードUTF-8で無効な文字やHTML要素も取り除く。
				$inputedValue = sanitize_text_field ( $inputedValue );
			}

			$sanitizedValueMap [$inputFieldID] = $inputedValue;
		}
	}

	public static function validateMoreThanZero($inputedValueMap, $fieldInfoArray, $optionGroup, $sectionTitle) {

		foreach ( $fieldInfoArray as $fieldInfo ) {

			if ($fieldInfo instanceof TextFieldInfo) { // TextFieldInfo, TextareaFieldInfoの場合
				if ($fieldInfo->getMoreThanZeroVerificationEnabled () === false) {
					continue;
				}
			} else {
				continue;
			}

			$inputFieldID = $fieldInfo->getFieldID ();

			if (isset ( $inputedValueMap [$inputFieldID] )) {

				$value = $inputedValueMap [$inputFieldID];
				if (is_numeric ( $value ) && $value >= 0) {
					;
				} else {
					$fieldLabel = $fieldInfo->getFieldLabel ();
					add_settings_error ( $optionGroup, $inputFieldID, // エラー出力時にHTMLで「id=」の形式で「setting-error-」の後に追加される文字列を設定します。任意の文字列で良いです。
					$sectionTitle . '：' . $fieldLabel . '：無効な値 ' . $value . ' です。０以上の値を入力してください。' );
					// ここで処理を中断したい場合、自作の例外を通知する。
				}
			}
		}
	}

	public static function validateExistence($inputedValueMap, $fieldInfoArray, $optionGroup, $sectionTitle) {

		foreach ( $fieldInfoArray as $fieldInfo ) {

			if ($fieldInfo instanceof TextFieldInfo) { // TextFieldInfo, TextareaFieldInfoの場合
				if ($fieldInfo->getExistenceVerificationEnabled () === false) {
					continue;
				}
			} else {
				continue;
			}

			$inputFieldID = $fieldInfo->getFieldID ();
			$valueExists;
			if (isset ( $inputedValueMap [$inputFieldID] )) {
				$value = $inputedValueMap [$inputFieldID];
				if (trim ( $value )) {
					$valueExists = true;
				} else {
					$valueExists = false;
				}
			} else {
				$valueExists = false;
			}

			if ($valueExists === false) {
				$fieldLabel = $fieldInfo->getFieldLabel ();
				add_settings_error ( $optionGroup, $inputFieldID, // エラー出力時にHTMLで「id=」の形式で「setting-error-」の後に追加される文字列を設定します。任意の文字列で良いです。
				$sectionTitle . '：' . $fieldLabel . '：未入力でした。有効な値を入力してください。' );
				// ここで処理を中断したい場合、自作の例外を通知する。
			}
		}
	}
}
