<?php
/**
 * @author Di.Zhang <zhangdi_me@163.com>
 */

namespace yiizh\storage;


use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

/**
 * Class LocalStorage
 *
 * @package yiizh\storage
 */
class LocalStorage extends Component implements StorageInterface
{
    public $basePath;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        if ($this->basePath == null) {
            throw new InvalidParamException('The "basePath" property must be set.');
        }
    }


    /**
     * @inheritDoc
     */
    public function save($file, $content)
    {
        if (!$file || !$content) {
            return false;
        }

        $file = $this->normalizeFile($file);
        $realPath = $this->getRealPath($file);
        echo $realPath;
        if ($this->makeDir(dirname($realPath))) {
            return false !== file_put_contents($realPath, $content);
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function read($file)
    {
        $file = $this->normalizeFile($file);

        if (!$this->exists($file)) {
            throw new Exception("File not found.");
        }

        $filename = $this->getRealPath($file);

        return file_get_contents($filename);
    }

    /**
     * @inheritDoc
     */
    public function exists($file)
    {
        $file = $this->normalizeFile($file);

        return file_exists($this->getRealPath($file));
    }

    /**
     * 标准化
     *
     * @param string $file
     * @return string
     */
    protected function normalizeFile($file)
    {
        $file = str_replace("\\", '/', $file);
        $nodes = explode('/', $file);
        $sections = [];
        foreach ($nodes as $node) {
            if ($node != '') {
                $sections[] = $node;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $sections);
    }

    /**
     * @param string $file
     * @return string
     */
    protected function getRealPath($file)
    {
        $realPath = \Yii::getAlias($this->basePath) . DIRECTORY_SEPARATOR . $file;
        $dir = dirname($realPath);
        $name = basename($realPath);
        return $dir . DIRECTORY_SEPARATOR . $name;
    }

    /**
     * @param string $dir
     * @param int $mode
     * @return bool
     */
    protected function makeDir($dir, $mode = 0777)
    {
        if (!$dir) {
            return false;
        }
        if (!file_exists($dir)) {
            return mkdir($dir, $mode, true);
        } else {
            return true;
        }
    }
}