<?php


namespace goodsmemo\item\html;

class PriceItemHTMLOption
{

    private $priceFooterText;
    private $priceTimeLinkVisible;

    public function getPriceFooterText()
    {
        return $this->priceFooterText;
    }

    public function setPriceFooterText($priceFooterText)
    {
        $this->priceFooterText = $priceFooterText;
    }

    public function getPriceTimeLinkVisible(): bool
    {
        return $this->priceTimeLinkVisible;
    }

    public function setPriceTimeLinkVisible(bool $priceTimeLinkVisible)
    {
        $this->priceTimeLinkVisible = $priceTimeLinkVisible;
    }
}
