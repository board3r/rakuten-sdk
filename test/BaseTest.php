<?php

namespace RakutenSDK\Test;

use PHPUnit\Framework\TestCase;
use RakutenSDK\Client;

abstract class BaseTest extends TestCase
{
    const ENV_ACCOUNT = "ACCOUNT";
    const ENV_TOKEN = "TOKEN";
    const ENV_SANDBOX = "SANDBOX";
    protected static ?Client $client;

    protected function getClient(bool $reset = false): Client
    {
        if (!isset(self::$client) || $reset) {
            self::$client = new Client(getenv(self::ENV_ACCOUNT), getenv(self::ENV_TOKEN), getenv(self::ENV_SANDBOX));
        }
        return self::$client;
    }

    protected function success($message)
    {
        $this->message("\033[32m" . $message . "\033[0m");
    }

    protected function info($message)
    {
        $this->message("\033[36m" . $message . "\033[0m");
    }

    protected function error($message)
    {
        $this->message("\033[91m" . $message . "\0330m");
    }

    protected function warning($message)
    {
        $this->message("\033[93m" . $message . "\033[0m");
    }

    protected function message($message)
    {
        fwrite(STDOUT, $message . "\n");
    }
}
