<?php

namespace goodsmemo\option;

use goodsmemo\option\PageInfo;
use goodsmemo\option\AffiliateSettingPage;

require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/AffiliateSettingPage.php";

class PageInfoUtils
{

    public static function createAffiliatePageInfo(string $pageSlug): PageInfo
    {
        $pageInfo = new PageInfo();

        $pageInfo->setSettingPageSlug($pageSlug);
        $pageInfo->setOptionGroup(AffiliateSettingPage::OPTION_GROUP);
        $pageInfo->setOptionNameOfDatabase(AffiliateSettingPage::OPTION_NAME_OF_DATABASE);

        return $pageInfo;
    }
}
