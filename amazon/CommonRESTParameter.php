<?php

namespace goodsmemo\amazon;

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
