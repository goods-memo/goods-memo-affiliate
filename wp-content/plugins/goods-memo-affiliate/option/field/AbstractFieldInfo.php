<?php

namespace goodsmemo\option\field;

/**
 *
 * @author kijim
 *        
 */
abstract class AbstractFieldInfo {
	private string $fieldID = "";
	private string $fieldLabel = "";
	private string $defaultFieldValue = "";

	public function getFieldID(): string {

		return $this->fieldID;
	}

	public function getFieldLabel(): string {

		return $this->fieldLabel;
	}

	public function getDefaultFieldValue(): string {

		return $this->defaultFieldValue;
	}

	public function setFieldID(string $fieldID) {

		$this->fieldID = $fieldID;
	}

	public function setFieldLabel(string $fieldLabel) {

		$this->fieldLabel = $fieldLabel;
	}

	public function setDefaultFieldValue(string $defaultFieldValue) {

		$this->defaultFieldValue = $defaultFieldValue;
	}
}

