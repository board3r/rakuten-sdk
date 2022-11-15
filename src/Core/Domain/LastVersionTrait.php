<?php
namespace RakutenSDK\Core\Domain;
/**
 * @method array getRequest()
 * @method bool hasRequest()
 */
trait LastVersionTrait
{

    /**
     * @return string
     */
    public function getLastVersion(): string
    {
        return $this->getData('lastversion');
    }

    /**
     * @return bool|null
     */
    public function isLastVersion(): ?bool
    {
        if ($this->hasRequest() && isset($this->getRequest()['version'])) {
            return $this->getRequest()['version'] === $this->getLastVersion();
        }
        return null;
    }

}
