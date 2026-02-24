<?php

namespace goodsmemo\option;


class PageInfo
{
    private $settingPageSlug;
    private $optionGroup;
    private $optionNameOfDatabase;

    public function getSettingPageSlug()
    {
        return $this->settingPageSlug;
    }

    public function getOptionGroup()
    {
        return $this->optionGroup;
    }

    public function getOptionNameOfDatabase()
    {
        return $this->optionNameOfDatabase;
    }

    public function setSettingPageSlug($settingPageSlug)
    {
        $this->settingPageSlug = $settingPageSlug;
    }

    public function setOptionGroup($optionGroup)
    {
        $this->optionGroup = $optionGroup;
    }

    public function setOptionNameOfDatabase($optionNameOfDatabase)
    {
        $this->optionNameOfDatabase = $optionNameOfDatabase;
    }
}
