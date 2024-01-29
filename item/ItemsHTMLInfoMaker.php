<?php

namespace goodsmemo\item;

use goodsmemo\network\URLInfo;
use goodsmemo\item\html\ItemHTMLOption;

require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";

interface ItemsHTMLInfoMaker
{
	public function requestItemSearch(URLInfo $urlInfo, int $numberToDisplay);

	public function makeItemArray($response);

	public function makeUniqueText(int $cacheExpirationInSeconds);
}
