<?php
namespace RakutenSDK\Request;

use InvalidArgumentException;


trait RakutenTrait
{
    protected array $availableVersions = [];

    /**
     * @return string
     */
    public function getVersion(): string
    {
        if (!$this->hasData('version')) {
            if (!$this->availableVersions) throw new InvalidArgumentException(__("Available versions are not defined"));
            $this->setData('version', current($this->availableVersions));
        }
        return $this->getData('version');
    }

    /**
     * @param string|array|null $version
     * @return $this
     */
    public function setVersion(null|string|array $version = null): static
    {
        if (is_array($version)) {
            $this->availableVersions = $version;
            $version = null;
        } else if (!$this->availableVersions && is_string($version)) {
            $this->availableVersions = [$version];
        }

        if (!isset($version)) {
            $this->setData('version', current($this->availableVersions));
        } else {
            if (!in_array($version, $this->availableVersions))
                throw new InvalidArgumentException(__("The version is not valid, it must be in {0}", implode(',', $this->availableVersions)));
            $this->setData('version', $version);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getAction():string
    {
        return $this->getData('action');
    }

    /**
     * @param string|null $action
     * @return $this
     */
    public function setAction(?string $action):static
    {
        return $this->setData('action', $action);
    }
}
