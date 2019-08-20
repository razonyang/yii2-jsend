<?php
namespace RazonYang\Yii2\JSend;

use RazonYang\JSend\PayloadFactory;
use RazonYang\JSend\PayloadInterface;
use yii\rest\Serializer as BaseSerializer;

class Serializer extends BaseSerializer
{
    /**
     * {@inheritdoc}
     *
     * @return PayloadInterface
     */
    protected function serializeModelErrors($model)
    {
        return PayloadFactory::fail($model->getFirstErrors());
    }

    /**
     * {@inheritdoc}
     *
     * @return PayloadInterface
     */
    public function serialize($data)
    {
        $data = parent::serialize($data);
        if (!$data instanceof PayloadInterface) {
            $data = PayloadFactory::success($data);
        }

        return $data;
    }
}
