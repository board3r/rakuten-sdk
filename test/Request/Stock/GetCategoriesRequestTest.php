<?php

namespace RakutenSDK\TestRequest\Stock;

use RakutenSDK\Request\Stock\GetCategoriesRequest;
use RakutenSDK\Test\BaseTest;

class GetCategoriesRequestTest extends BaseTest
{
    public function testCreateRequest()
    {
        $request = new  GetCategoriesRequest();
        $this->assertEquals(GetCategoriesRequest::class, $request::class);
    }

    public function testRequestAction()
    {
        $request = new  GetCategoriesRequest();
        $action = $request->getAction();
        $this->assertEquals('categorymap', $action);
    }

    public function testRequestEndpoint()
    {
        $request = new  GetCategoriesRequest();
        $endPoint = $request->getEndpoint();
        $this->assertEquals('/categorymap_ws', $endPoint);
    }

    public function testRequestMethod()
    {
        $request = new  GetCategoriesRequest();
        $method = $request->getMethod();
        $this->assertEquals('GET', $method);
    }

    public function testCallRequest()
    {
        $request = new  GetCategoriesRequest();
        $client = $this->getClient();
        $result = $client->getCategories($request);
        $lastVersion = $result->isLastVersion();
        $this->assertEquals(true, $lastVersion);
        $this->assertEquals(\RakutenSDK\Domain\Stock\Category::class, $result::class);
        $hasCategories = $result->hasCategories();
        $this->assertEquals(true, $hasCategories);
        $categories = $result->getCategories();
        $this->assertEquals(\RakutenSDK\Domain\Stock\Collection\CategoryCollection::class, $categories::class);
        $this->assertIsIterable($categories);
        $count = $categories->getTotalCount();
        $this->assertIsInt($count);
        $this->info($count . ' main categories found');
        $subCount = 0;
        foreach ($categories as $category) {
            $code = $category->getCode();
            $this->assertIsString($code);
            if ($category->hasCategories()) {
                $subCategories = $result->getCategories();
                $this->assertEquals(\RakutenSDK\Domain\Stock\Collection\CategoryCollection::class, $subCategories::class);
                $this->assertIsIterable($subCategories);
                $subCount += $subCategories->getTotalCount();
                $this->assertIsInt($subCount);
            }
        }
        $this->info($subCount . ' sub categories found');
    }
}
