<?php
namespace RazonYang\Yii2\JSend;

use RazonYang\JSend\Exception;
use RazonYang\JSend\Status;
use Yii;
use yii\base\UserException;
use yii\web\ErrorHandler as BaseErrorHandler;
use yii\web\HttpException;

class ErrorHandler extends BaseErrorHandler
{
    protected function convertExceptionToArray($exception)
    {
        if (!YII_DEBUG && !$exception instanceof UserException && !$exception instanceof HttpException) {
            $exception = new Exception(Yii::t('yii', 'An internal server error occurred.'), 500);
        }

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
