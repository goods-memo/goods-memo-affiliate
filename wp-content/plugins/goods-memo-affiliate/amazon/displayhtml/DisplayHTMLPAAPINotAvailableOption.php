<?php

namespace goodsmemo\amazon\displayhtml;

/**
 *
 * @author kijim
 *        
 */
class DisplayHTMLPAAPINotAvailableOption {
	private string $displayHTMLPAAPINotAvailable = "";
	private bool $displayHTMLPAAPINotAvailableAlwaysEnabled = false;

	/**
	 *
	 * @return string
	 */
	public function getDisplayHTMLPAAPINotAvailable(): string {

		return $this->displayHTMLPAAPINotAvailable;
	}

	/**
	 *
	 * @param string $displayHTMLPAAPINotAvailable
	 */
	public function setDisplayHTMLPAAPINotAvailable(string $displayHTMLPAAPINotAvailable) {

		$this->displayHTMLPAAPINotAvailable = $displayHTMLPAAPINotAvailable;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getDisplayHTMLPAAPINotAvailableAlwaysEnabled(): bool {

		return $this->displayHTMLPAAPINotAvailableAlwaysEnabled;
	}

	/**
	 *
	 * @param boolean $displayHTMLPAAPINotAvailableAlwaysEnabled
	 */
	public function setDisplayHTMLPAAPINotAvailableAlwaysEnabled(bool $displayHTMLPAAPINotAvailableAlwaysEnabled) {

		$this->displayHTMLPAAPINotAvailableAlwaysEnabled = $displayHTMLPAAPINotAvailableAlwaysEnabled;
	}
}

