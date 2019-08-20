<?php
namespace RazonYang\Yii2\JSend\Tests;

use PHPUnit\Framework\TestCase;
use RazonYang\Yii2\JSend\Formatter;
use yii\web\Response;
use RazonYang\JSend\PayloadInterface;
use RazonYang\JSend\PayloadFactory;

class FormmaterTest extends TestCase
{
    public function testOptions(): void
    {
        $formater = new Formatter();
        $this->assertSame(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES, $formater->getOptions());

        $newOptions = 0;
        $formater->setOptions($newOptions);
        $this->assertSame($newOptions, $formater->getOptions());
    }

    /**
     * @dataProvider dataProviderFormat
     */
    public function testFormat(Response $response): void
    {
        $formater = new Formatter();
        $formater->format($response);
        $this->assertSame('application/json; charset=UTF-8', $response->getHeaders()->get('Content-Type'));
        if ($response->data instanceof PayloadInterface) {
            $data = $response->data->toArray();
        } else {
            $data = $response->data;
        }
        $this->assertSame(json_encode($data, $formater->getOptions()), $response->content);
    }

    public function dataProviderFormat(): array
    {
        $response1 = new Response(['data' => 'foo']);
        $response2 = new Response(['data' => PayloadFactory::fail('fail')]);

        return [
            [$response1],
            [$response2],
        ];
    }
}
