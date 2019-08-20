<?php
namespace RazonYang\Yii2\JSend\Tests;

use PHPUnit\Framework\TestCase;
use RazonYang\JSend\PayloadFactory;
use RazonYang\JSend\PayloadInterface;
use RazonYang\JSend\Status;
use RazonYang\Yii2\JSend\Serializer;
use yii\base\Model;

class SerializerTest extends TestCase
{
    public function createSerializer(): Serializer
    {
        return new Serializer();
    }

    /**
     * @dataProvider dataProviderData
     */
    public function testSerialize($data): void
    {
        $serializer = $this->createSerializer();
        $payload = $serializer->serialize($data);
        $this->assertInstanceOf(PayloadInterface::class, $payload);
        if ($data instanceof PayloadInterface) {
            $this->assertSame($data, $payload);
        } else {
            $this->assertSame(Status::SUCCESS, $payload->getStatus());
            $this->assertSame($data, $payload->getData());
        }
    }

    public function dataProviderData(): array
    {
        return [
            ['foo'],
            [['foo', 'bar']],
            [PayloadFactory::fail($this)]
        ];
    }

    /**
     * @dataProvider dataProviderModel
     */
    public function testSerializeModelErrors(Model $model)
    {
        $serializer = $this->createSerializer();
        $method = new \ReflectionMethod(Serializer::class, 'serializeModelErrors');
        $method->setAccessible(true);
        $payload = $method->invoke($serializer, $model);
        $this->assertEquals($model->getFirstErrors(), $payload->getData());
    }

    public function dataProviderModel(): array
    {
        $model1 = new Model();
        $model1->addErrors(['name' => 'name is required']);

        $model2 = new Model();
        $model2->addErrors(['name' => 'name is required', 'age' => 'age is required']);
        
        return [
            [$model1],
            [$model2],
        ];
    }
}
