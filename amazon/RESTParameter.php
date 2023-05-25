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

namespace goodsmemo\amazon;

use goodsmemo\network\DefaultRESTParameter;

require_once GOODS_MEMO_DIR . "network/DefaultRESTParameter.php";

/**
 * Description of RESTParameter
 *
 * @author Goods Memo
 */
class RESTParameter extends DefaultRESTParameter {

    private $operation;
    private $searchIndex;
    private $searchItemsResources;

    public function getOperation() {
	return $this->operation;
    }

    public function getSearchIndex() {
	return $this->searchIndex;
    }

    public function getSearchItemsResources() {
	return $this->searchItemsResources;
    }

    public function setOperation($operation) {
	$this->operation = $operation;
    }

    public function setSearchIndex($searchIndex) {
	$this->searchIndex = $searchIndex;
    }

    public function setSearchItemsResources($searchItemsResources) {
	$this->searchItemsResources = $searchItemsResources;
    }

}
