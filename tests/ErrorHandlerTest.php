<?php
namespace RazonYang\Yii2\JSend\Tests;

use PHPUnit\Framework\TestCase;
use RazonYang\JSend\Exception;
use RazonYang\JSend\Status;
use RazonYang\Yii2\JSend\ErrorHandler;

class ErrorHandlerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        defined('YII_DEBUG') || define('YII_DEBUG', true);
    }

    /**
     * @dataProvider dataProviderException
     */
    public function testConvertExceptionToArray($exception): void
    {
        $handler = new ErrorHandler();
        $method = new \ReflectionMethod(ErrorHandler::class, 'convertExceptionToArray');
        $method->setAccessible(true);
        $payload = $method->invoke($handler, $exception);
        $this->assertSame(Status::ERROR, $payload['status']);
        $this->assertSame($exception->getCode(), $payload['code']);
        $this->assertSame($exception->getMessage(), $payload['message']);
        $this->assertSame(explode("\n", $exception->getTraceAsString()), $payload['debug']['traces']);
        if (($prev = $exception->getPrevious()) !== null) {
            $this->assertArrayHasKey('previous', $payload['debug']);
        }
        if ($exception instanceof Exception) {
            $this->assertSame($exception->getData(), $payload['data']);
        }
    }

    public function dataProviderException(): array
    {
        return [
            [new \Exception()],
            [new \Exception('internal error', 500)],
            [new \Exception('previous', 0, new \InvalidArgumentException())],
            [new Exception('foo', 401, 'bar', null)],
        ];
    }
}
