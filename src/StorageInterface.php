<?php
/**
 * @author Di.Zhang <zhangdi_me@163.com>
 */

namespace yiizh\storage;

use yii\base\Object;


/**
 * Storage Interface
 *
 * @package yiizh\storage
 *
 */
interface StorageInterface
{

    /**
     * 保存文件
     *
     * @param string $file 文件
     * @param string $content 文件内容
     * @return boolean 是否保存成功
     */
    public function save($file, $content);

    /**
     * 读取文件
     *
     * @param string $file
     * @return string
     */
    public function read($file);

    /**
     * 文件是否存在
     *
     * @param string $file
     * @return string
     */
    public function exists($file);
}