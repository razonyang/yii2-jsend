<?php
namespace RazonYang\Yii2\JSend;

use RazonYang\JSend\PayloadInterface;
use yii\base\Component;
use yii\web\ResponseFormatterInterface;

/**
 * Formatter is a JSend formatter.
 *
 * @property int $options.
 */
class Formatter extends Component implements ResponseFormatterInterface
{
    /**
     * @var int $options JSON encode options.
     */
    private $options = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    /**
     * Returns JSON encode options.
     *
     * @return int
     */
    public function getOptions(): int
    {
        return $this->options;
    }

    /**
     * Sets JSON encode options.
     *
     * @param int $options
     */
    public function setOptions(int $options)
    {
        $this->options = $options;
    }

    public function init()
    {
        parent::init();
    }

    public function format($response)
    {
        if ($response->data instanceof PayloadInterface) {
            $data = $response->data->toArray();
        } else {
            $data = $response->data;
        }
        $response->getHeaders()->set('Content-Type', 'application/json; charset=UTF-8');
        $response->content = json_encode($data, $this->options);
    }
}
