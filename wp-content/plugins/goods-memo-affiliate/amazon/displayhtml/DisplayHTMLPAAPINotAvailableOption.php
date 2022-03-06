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

		return $this->displayHTML;
	}

	/**
	 *
	 * @param string $displayHTML
	 */
	public function setDisplayHTMLPAAPINotAvailable(string $displayHTML) {

		$this->displayHTML = $displayHTML;
	}

	/**
	 *
	 * @return boolean
	 */
	public function getDisplayHTMLPAAPINotAvailableAlwaysEnabled(): bool {

		return $this->displayHTMLAlwaysEnabled;
	}

	/**
	 *
	 * @param boolean $displayHTMLAlwaysEnabled
	 */
	public function setDisplayHTMLPAAPINotAvailableAlwaysEnabled(bool $displayHTMLAlwaysEnabled) {

		$this->displayHTMLAlwaysEnabled = $displayHTMLAlwaysEnabled;
	}
}

