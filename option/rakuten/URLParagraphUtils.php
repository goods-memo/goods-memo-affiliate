<?php

namespace goodsmemo\option\rakuten;

use goodsmemo\option\field\TextFieldInfo;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

class URLParagraphUtils
{
	const HOSTNAME_ID = RakutenSettingSection::ID_PREFIX . "_hostname_id";
	const PATH_ID = RakutenSettingSection::ID_PREFIX . "_path_id";

	public static function makeFieldInfoArray()
	{

		$fieldInfoArray = array();

		$hostnameFieldInfo = new TextFieldInfo();
		$hostnameFieldInfo->setFieldID(URLParagraphUtils::HOSTNAME_ID);
		$hostnameFieldInfo->setFieldLabel('楽天市場商品検索API ホスト名');
		$hostnameFieldInfo->setDefaultFieldValue("openapi.rakuten.co.jp");
		array_push($fieldInfoArray, $hostnameFieldInfo);

		$pathFieldInfo = new TextFieldInfo();
		$pathFieldInfo->setFieldID(URLParagraphUtils::PATH_ID);
		$pathFieldInfo->setFieldLabel('楽天市場商品検索API リクエストURLのパス');
		$pathFieldInfo->setDefaultFieldValue("ichibams/api/IchibaItem/Search/20220601");
		array_push($fieldInfoArray, $pathFieldInfo);

		return $fieldInfoArray;
	}
}
