<?php

namespace goodsmemo\option\rakuten;

use goodsmemo\option\field\TextFieldInfo;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

class CommonRESTParagraphUtils
{
	const APPLICATION_ID_ID = RakutenSettingSection::ID_PREFIX . "_application_id_id";
	const ACCESS_KEY_ID = RakutenSettingSection::ID_PREFIX . "_access_key_id";
	const AFFILIATE_ID_ID = RakutenSettingSection::ID_PREFIX . "_affiliate_id_id";

	public static function makeFieldInfoArray()
	{

		$fieldInfoArray = array();

		$applicationIDFieldInfo = new TextFieldInfo();
		$applicationIDFieldInfo->setFieldID(CommonRESTParagraphUtils::APPLICATION_ID_ID);
		$applicationIDFieldInfo->setFieldLabel('楽天アプリID/デベロッパーID');
		$applicationIDFieldInfo->setExistenceVerificationEnabled(false);
		array_push($fieldInfoArray, $applicationIDFieldInfo);

		$accessKeyFieldInfo = new TextFieldInfo();
		$accessKeyFieldInfo->setFieldID(CommonRESTParagraphUtils::ACCESS_KEY_ID);
		$accessKeyFieldInfo->setFieldLabel('楽天アプリ/アクセスキー');
		$accessKeyFieldInfo->setExistenceVerificationEnabled(false);
		array_push($fieldInfoArray, $accessKeyFieldInfo);

		$affiliateIDFieldInfo = new TextFieldInfo();
		$affiliateIDFieldInfo->setFieldID(CommonRESTParagraphUtils::AFFILIATE_ID_ID);
		$affiliateIDFieldInfo->setFieldLabel('楽天アフィリエイトID');
		$affiliateIDFieldInfo->setExistenceVerificationEnabled(false);
		array_push($fieldInfoArray, $affiliateIDFieldInfo);

		return $fieldInfoArray;
	}
}
