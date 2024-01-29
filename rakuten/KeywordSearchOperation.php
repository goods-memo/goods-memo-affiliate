<?php


namespace goodsmemo\rakuten;

use goodsmemo\network\URLInfo;
use goodsmemo\rakuten\CommonRESTParameter;
use goodsmemo\rakuten\RESTParameter;
use goodsmemo\rakuten\SearchOption;
use goodsmemo\rakuten\RakutenItemsHTMLInfoMaker;
use goodsmemo\item\ItemSearchOperation;
use goodsmemo\item\html\ItemHTMLOption;

require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "rakuten/CommonRESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/RESTParameter.php";
require_once GOODS_MEMO_DIR . "rakuten/SearchOption.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenItemsHTMLInfoMaker.php";
require_once GOODS_MEMO_DIR . "item/ItemSearchOperation.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";

class KeywordSearchOperation
{

    public static function makeHTMLOfIchibaItemSearch(
        URLInfo $urlInfo,
        CommonRESTParameter $commonParameter,
        RESTParameter $restParameter,
        SearchOption $searchOption,
        ItemHTMLOption $itemHTMLOption
    ) {
        $imageItemHTMLOption = $itemHTMLOption->getImageItemHTMLOption();
        $itemsHTMLInfoMaker = new RakutenItemsHTMLInfoMaker($commonParameter, $restParameter, $searchOption, $imageItemHTMLOption);

        $itemsHtml = ItemSearchOperation::makeItemsHTML($urlInfo, $itemHTMLOption, $itemsHTMLInfoMaker);
        return $itemsHtml;
    }
}
