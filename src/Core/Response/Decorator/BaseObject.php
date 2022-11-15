<?php
namespace RakutenSDK\Core\Response\Decorator;

use RakutenSDK\Core\Response\ResponseDecoratorInterface;
use Psr\Http\Message\ResponseInterface;

class BaseObject implements ResponseDecoratorInterface
{

    use ErrorTrait;

    /**
     * @var string
     */
    protected string $class;

    /**
     * @var string
     */
    protected string $key;

    /**
     * @param string $class
     * @param string|null $key
     */
    public function __construct(string $class = \RakutenSDK\Core\Domain\BaseObject::class, ?string $key = null)
    {
        $this->class = $class;
        $this->key = $key;
    }

    /**
     * @inheritdoc
     */
    public function decorate(ResponseInterface $response):mixed
    {
        $this->beforeDecorate($response);
        $data = (new AssocArray())->decorate($response);
        $data = $this->afterDecorate($data);
        if ($this->key) {
            if (isset($data['request'])){
                $dataRequest = $data['request'];
            }
            $keys = explode('.', $this->key);
            foreach ($keys as $k) {
                $data = $data[$k];
            }
            if (isset($dataRequest)){
                $data['request'] = $dataRequest;
            }
        }

        return new $this->class($data);
    }
}
