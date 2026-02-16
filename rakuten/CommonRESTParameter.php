<?php

namespace goodsmemo\rakuten;

class CommonRESTParameter
{

    private $applicationId;
    private $accessKey;
    private $affiliateId;

    public function getApplicationId()
    {
        return $this->applicationId;
    }

    public function setApplicationId($applicationId)
    {
        $this->applicationId = $applicationId;
    }

    public function getAccessKey()
    {
        return $this->accessKey;
    }

    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
    }

    public function getAffiliateId()
    {
        return $this->affiliateId;
    }

    public function setAffiliateId($affiliateId)
    {
        $this->affiliateId = $affiliateId;
    }
}
