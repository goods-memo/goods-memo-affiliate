<?php

namespace goodsmemo\option\paragraph;

use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\paragraph\ParagraphUtils;
use goodsmemo\option\field\AbstractField;
use goodsmemo\option\field\FieldPrinter;

require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/field/AbstractField.php";
require_once GOODS_MEMO_DIR . "option/field/FieldPrinter.php";

abstract class AbstractParagraph
{

    private $optionGroup;
    private $sectionTitle;
    private $fieldInfoArray;
    //
    private $fieldArray = array();

    abstract public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray);

    protected function addField(PageInfo $pageInfo, SectionInfo $sectionInfo, AbstractField $field)
    {

        $fieldInfo = $field->getFieldInfo();

        add_settings_field(
            $fieldInfo->getFieldID(), //入力項目のID
            $fieldInfo->getFieldLabel(), //入力項目名
            array($field, FieldPrinter::PRINT_FIELD_METHOD_NAME), //入力項目のHTMLを出力する関数
            $pageInfo->getSettingPageSlug(),
            $sectionInfo->getSectionID()
        );

        array_push($this->fieldArray, $field);
    }

    public function setOptionMap($optionMap)
    {

        foreach ($this->fieldArray as $field) {

            $field->setOptionMap($optionMap);
        }
    }

    public function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap)
    {
        //sanitizedValueMap：変更するため、配列の参照渡しとする。
        //入力値の検証なし
        ParagraphUtils::sanitizeParagraphValue($inputedValueMap, $sanitizedValueMap, $this->fieldInfoArray);
    }

    public function getOptionGroup()
    {
        return $this->optionGroup;
    }

    public function setOptionGroup($optionGroup)
    {
        $this->optionGroup = $optionGroup;
    }

    public function getSectionTitle()
    {
        return $this->sectionTitle;
    }

    public function setSectionTitle($sectionTitle)
    {
        $this->sectionTitle = $sectionTitle;
    }

    public function getFieldInfoArray()
    {
        return $this->fieldInfoArray;
    }

    public function setFieldInfoArray($fieldInfoArray)
    {
        $this->fieldInfoArray = $fieldInfoArray;
    }
}
