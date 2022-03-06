<?php

namespace goodsmemo\amazon\displayhtml;

/**
 *
 * @author kijim
 *        
 */
class DisplayHTMLPAAPINotAvailableOption {
	private string $displayHTML = "";
	private bool $displayHTMLAlwaysEnabled = false;

	/**
	 *
	 * @return string
	 */
	public function getDisplayHTMLPAAPINotAvailable(): string {

		return $this->displayHTMLPAAPINotAvailable;
	}

	/**
	 *
	 * @param string $displayHTML
	 */
	public function setDisplayHTMLPAAPINotAvailable(string $displayHTML) {

		$this->displayHTMLPAAPINotAvailable = $displayHTML;
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
	 * @param boolean $displayHTMLAlwaysEnabled
	 */
	public function setDisplayHTMLPAAPINotAvailableAlwaysEnabled(bool $displayHTMLAlwaysEnabled) {

		$this->displayHTMLPAAPINotAvailableAlwaysEnabled = $displayHTMLAlwaysEnabled;
	}
}

