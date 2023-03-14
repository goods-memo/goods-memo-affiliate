<?php

namespace goodsmemo\amazon\displayhtml;

class DisplayHTMLPAAPINotAvailableOption {
	private string $displayHTML = "";
	private bool $displayHTMLAlwaysEnabled = false;

	public function getDisplayHTMLPAAPINotAvailable(): string {

		return $this->displayHTML;
	}

	public function setDisplayHTMLPAAPINotAvailable(string $displayHTML) {

		$this->displayHTML = $displayHTML;
	}

	public function getDisplayHTMLPAAPINotAvailableAlwaysEnabled(): bool {

		return $this->displayHTMLAlwaysEnabled;
	}

	public function setDisplayHTMLPAAPINotAvailableAlwaysEnabled(bool $displayHTMLAlwaysEnabled) {

		$this->displayHTMLAlwaysEnabled = $displayHTMLAlwaysEnabled;
	}
}

