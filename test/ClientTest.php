<?php

namespace RakutenSDK\Test;

use RakutenSDK\Client;

class ClientTest extends BaseTest
{
    public function testClient()
    {
        $client = $this->getClient();
        $this->assertEquals(Client::class, is_object($client) ? $client::class : null);
    }


    public function testGetAccount()
    {
        $this->assertEquals($this->getClient()->getAccount(), getenv(self::ENV_ACCOUNT));
    }


    public function testGetSandbox()
    {
        $this->assertEquals($this->getClient()->getSandbox(), getenv(self::ENV_SANDBOX));
    }

    public function testGetToken()
    {
        $this->assertEquals($this->getClient()->getToken(), getenv(self::ENV_TOKEN));
    }


    public function testGetBaseUrl()
    {
        $client = new Client('foo', 'foo', true);
        $this->assertEquals('https://sandbox.fr.shopping.rakuten.com', $client->getBaseUrl());
        $client = new Client('foo', 'foo', false);
        $this->assertEquals('https://ws.fr.shopping.rakuten.com', $client->getBaseUrl());
    }

    public function testSetToken()
    {
        $client = new Client('foo', 'foo', false);
        $client->setToken('baz');
        $this->assertEquals('baz', $client->getToken());
    }

    public function testSetAccount()
    {
        $client = new Client('foo', 'foo', false);
        $client->setAccount('baz');
        $this->assertEquals('baz', $client->getAccount());
    }

    public function testSetSandbox()
    {
        $client = new Client('foo', 'foo', false);
        $client->setSandbox(true);
        $this->assertEquals(true, $client->getSandbox());
        $client->setSandbox(false);
        $this->assertEquals(false, $client->getSandbox());
    }
}
