JSend port for Yii2
===================

[![Build Status](https://travis-ci.org/razonyang/yii2-jsend.svg?branch=master)](https://travis-ci.org/razonyang/yii2-jsend)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/razonyang/yii2-jsend/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/razonyang/yii2-jsend/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/razonyang/yii2-jsend/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/razonyang/yii2-jsend/?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/razonyang/yii2-jsend.svg)](https://packagist.org/packages/razonyang/yii2-jsend)
[![Total Downloads](https://img.shields.io/packagist/dt/razonyang/yii2-jsend.svg)](https://packagist.org/packages/razonyang/yii2-jsend)
[![LICENSE](https://img.shields.io/github/license/razonyang/yii2-jsend)](LICENSE)


The package is a Yii2's implementation of [JSend](https://github.com/omniti-labs/jsend) specification.

Installation
------------

```
composer require razonyang/yii2-jsend
```

Usage
-----

Update resposne formater and error handler:

```php
return [
    'components' => [
        'response' => [
            'formatters' => [
                \yii\web\Response::JSON => [
                    'class' => \RazonYang\Yii2\JSend\Formatter::class,
                ],
            ],
        ],
        'errorHandler' => [
            'class' => \RazonYang\Yii2\JSend\ErrorHandler::class,
        ],
    ],
];
```

Change you rest controller serializer:

```php
public $serializer = \RazonYang\Yii2\JSend\Serializer::class;
```

Error Handler
-------------

`ErrorHandler` converts exception to error payload:

```json
{
    "status": "error",
    "code": "exception code",
    "message": "exception message"
}
```

It can also returns the optional data field by throwing a JSend's Exception:

```php
throws new RazonYang\Jsend\Exception($message, $code, $data, $previous);

// you can also define your own exception:
class MyException extends RazonYang\Jsend\Exception
{
}

throws new MyException();
```

```json
{
    "status": "error",
    "code": "exception code",
    "message": "exception message",
    "data": "exception data"
}
```
