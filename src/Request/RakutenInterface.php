<?php

namespace RakutenSDK\Request;

interface RakutenInterface
{
    public function getVersion();

    public function setVersion(string $version):static;

    public function getAction();

    public function setAction(string $action):static;
}
