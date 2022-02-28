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

namespace goodsmemo\item;

use goodsmemo\network\URLInfo;
use goodsmemo\item\html\ItemHTMLOption;

require_once GOODS_MEMO_DIR . "network/URLInfo.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";

/**
 *
 * @author Goods Memo
 */
interface ItemsHTMLInfoMaker {

	public function requestItemSearch(URLInfo $urlInfo, int $itemCount);

	public function makeItemArray($response, ItemHTMLOption $itemHTMLOption);

	public function makeUniqueText(ItemHTMLOption $itemHTMLOption);
}
