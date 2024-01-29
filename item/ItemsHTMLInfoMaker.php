<?php

namespace goodsmemo\item;

use goodsmemo\network\URLInfo;

require_once GOODS_MEMO_DIR . "network/URLInfo.php";

interface ItemsHTMLInfoMaker
{
	public function requestItemSearch(URLInfo $urlInfo);

	public function makeItemArray($response);

	public function makeUniqueText(int $cacheExpirationInSeconds);
}
