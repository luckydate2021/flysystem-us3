# flysystem-us3
Flysystem adapter for the Ucloud US3 storage.

### 使用
1. 拉取

    composer require luckdate2021/flysystem-us3

    如果提示找不到就还原composer的默认仓库再试。注意只限hyperf(^2.2)使用


2. 按照 hyperf 的手册加入filesystem，和发版

    composer require hyperf/filesystem

    发布
   
    php bin/hyperf.php vendor:publish hyperf/filesystem


3. 发布后在config下autoload有个file.php，修改增加
   ```
   'us3' => [
   'driver' => \Luckydate2021\Flysystem\Us3\Us3AdapterFactory::class, 
   'public_key' => env('US3_PUBLIC_KEY'),
   'secret_key' => env('US3_SECRET_KEY'),
   'bucket' => env('US3_BUCKET'),
   'suffix' => env('US3_SUFFIX'), //eg. ".ufile.ucloud.cn"
   'path_prefix' => '',
   'https' => false,
   ]

### 示例
```
use Hyperf\Filesystem\FilesystemFactory;
use Hyperf\Di\Annotation\Inject;

----- class -----

/**
* @Inject()
* @var FilesystemFactory
*/
protected $filesystemFactory;

public function index()
    {
        $file = $this->request->file('avatar');
        if ($file->isValid()) {

            $ext = strtolower($file->getExtension());

            $filePathUrl = rand(1000, 9999) . '.' . $ext;

            try {
                $stream = fopen($file->getRealPath(), 'r+');
                $bucket = $this->filesystemFactory->get('us3');
                $bucket->writeStream($filePathUrl, $stream, ['mime' => 'image/png']); //主要这里的mine要根据文件来传，这里只是示例
                if (is_resource($stream)) {
                    fclose($stream);
                }else{
                    return '注意:如果显示这句，检查key之类的是否正确，还是不知道就改一下拉下来的Us3Adapter.php，把writeStream返回的结果打印下，看ucloud的报错信息';
                }

            } catch (\Exception $e) {
                return '上传失败';
            }

        }  
```


### 其他注意

只适用于league/flysystem ^1.1版本。

在Us3Sdk中使用了new CoroutineHandler()，只限hyperf(^2.2)使用。

use Hyperf\Guzzle\CoroutineHandler;

$stack->setHandler(new CoroutineHandler());

一定要传正确的文件类型mime，不然Ucloud默认的是二进制文件 application/octet-stream，容易格式错误。

例如 $bucket->writeStream($filePathUrl, $stream, ['mime' => 'image/png']);

