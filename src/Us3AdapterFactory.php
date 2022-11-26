<?php


namespace Luckydate2021\Flysystem\Us3;

use Hyperf\Filesystem\Contract\AdapterFactoryInterface;
use Luckydate2021\Flysystem\Us3\Us3Adapter;
class Us3AdapterFactory implements AdapterFactoryInterface
{
    public function make(array $options)
    {
        return new Us3Adapter(
            $options['bucket'],
            $options['public_key'],
            $options['secret_key'],
            $suffix = $options['suffix'], //'.ufile.ucloud.cn',
            $pathPrefix = $options['path_prefix'],
            $https = false
        );
    }
}