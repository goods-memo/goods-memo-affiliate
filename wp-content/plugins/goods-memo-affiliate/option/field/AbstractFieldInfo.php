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

	public function getFieldID(): string {

		return $this->fieldID;
	}

	public function getFieldLabel(): string {

		return $this->fieldLabel;
	}

	public function setFieldID(string $fieldID) {

		$this->fieldID = $fieldID;
	}

	public function setFieldLabel(string $fieldLabel) {

		$this->fieldLabel = $fieldLabel;
	}
}

