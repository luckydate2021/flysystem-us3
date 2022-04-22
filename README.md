# flysystem-us3
Flysystem adapter for the Ucloud US3 storage.

只适用于league/flysystem ^1.1版本。

在Us3Sdk中使用了new CoroutineHandler()，只限hyperf(^2.2)使用。

use Hyperf\Guzzle\CoroutineHandler;

$stack->setHandler(new CoroutineHandler());

一定要传正确的文件类型mime，不然Ucloud默认的是二进制文件 application/octet-stream，容易格式错误。

例如 $bucket->writeStream($filePathUrl, $stream, ['mime' => 'image/png']);

