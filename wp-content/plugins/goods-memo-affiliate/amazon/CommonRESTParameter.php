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

/**
 * Description of CommonRESTParameter
 *
 * @author Goods Memo
 */
class CommonRESTParameter {

	private $accessKey;
	private $associateTag;
	private $secretKey;
	private $region;

	public function getAccessKey() {
		return $this->accessKey;
	}

	public function getAssociateTag() {
		return $this->associateTag;
	}

	public function getSecretKey() {
		return $this->secretKey;
	}

	public function getRegion() {
		return $this->region;
	}

	public function setAccessKey($accessKey) {
		$this->accessKey = $accessKey;
	}

	public function setAssociateTag($associateTag) {
		$this->associateTag = $associateTag;
	}

	public function setSecretKey($secretKey) {
		$this->secretKey = $secretKey;
	}

	public function setRegion($region) {
		$this->region = $region;
	}

}
