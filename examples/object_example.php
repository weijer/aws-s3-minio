<?php
/**
 * Created by PhpStorm.
 * User: klinson <klinson@163.com>
 * Date: 18-7-18
 * Time: 上午10:02
 */

require __DIR__.'/_header.php';

use Minio\Object\ObjectClient;

$ObjectClient = new ObjectClient($minio_config);

//根据文件路径上传文件，返回存储路径（key）
$save_path = $ObjectClient->putObjectBySavePath(__DIR__.'/downloads/.gitignore', 'object_example/putObjectBySavePath.txt');
if ($save_path === false) {
    echo_error_info($ObjectClient);
    return ;
}
echo 'save_path: ' . $save_path . PHP_EOL;

// 写入内容并上传，返回存储路径（key）
$save_path = $ObjectClient->putObjectByContent('object_example/putObjectByContent.txt', 'hello world;');
if ($save_path === false) {
    echo_error_info($ObjectClient);
    return ;
}
echo 'save_path: ' . $save_path . PHP_EOL;

// 获取文件
$result = $ObjectClient->getObject($save_path);
if ($result === false) {
    echo_error_info($ObjectClient);
    return ;
}
print_r($result);
echo PHP_EOL;

// 获取文件并下载到本地
$result = $ObjectClient->getObjectSaveAs($save_path, __DIR__.'/downloads/tmp');
if ($result === false) {
    echo_error_info($ObjectClient);
    return ;
}
print_r($result);
echo PHP_EOL;

// 获取访问url，有效期60s
$url = $ObjectClient->getObjectUrl($save_path, time() + 60);
if ($url === false) {
    echo_error_info($ObjectClient);
    return ;
}
echo 'download_url: ' . $url . PHP_EOL;

// 复制单个对象
$targetStorageSavePath = $ObjectClient->copyObject('111.jpg', '111_copy.jpg');
if ($targetStorageSavePath === false) {
    echo_error_info($ObjectClient);
    return ;
}
echo 'copyObject save path: ' . $targetStorageSavePath .PHP_EOL;

// 获取1000个对象
$result = $ObjectClient->listObjects();
if ($result === false) {
    echo_error_info($ObjectClient);
    return ;
}
print_r($result);
echo PHP_EOL;

// 获取所有
$result = $ObjectClient->getAllObjects();
if ($result === false) {
    echo_error_info($ObjectClient);
    return ;
}
print_r($result);
echo PHP_EOL;

//remove objects
$remove_list = [
    'testkey',
    'test1/3.txt'
];
$ObjectClient->removeObject($remove_list);
if ($result === false) {
    echo_error_info($ObjectClient);
    return ;
}
print_r($result);
echo PHP_EOL;

//remove a object
$remove_list = 'test1/5.txt';
$ObjectClient->removeObject($remove_list);
if ($result === false) {
    echo_error_info($ObjectClient);
    return ;
}
print_r($result);
echo PHP_EOL;