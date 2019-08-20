<?php
namespace RazonYang\Yii2\JSend;

use RazonYang\JSend\Exception;
use RazonYang\JSend\Status;
use yii\web\ErrorHandler as BaseErrorHandler;

class ErrorHandler extends BaseErrorHandler
{
    protected function convertExceptionToArray($exception)
    {
        $payload = [
            'status' => Status::ERROR,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];
        if ($exception instanceof Exception) {
            $payload['data'] = $exception->getData();
        }

        if (YII_DEBUG) {
            $payload['debug']['traces'] = explode("\n", $exception->getTraceAsString());
            if (($prev = $exception->getPrevious()) !== null) {
                $payload['debug']['previous'] = $this->convertExceptionToArray($prev);
            }
        }

        return $payload;
    }
}
