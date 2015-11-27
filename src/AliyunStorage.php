<?php
/**
 * @author Di.Zhang <zhangdi_me@163.com>
 */

namespace yiizh\storage;

use OSS\Core\OssException;
use OSS\OssClient;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\log\Logger;

/**
 * Class AliyunStorage
 *
 * @package yiizh\storage
 */
class AliyunStorage extends Component implements StorageInterface
{
    /**
     * @var string
     */
    public $accessKey;

    /**
     * @var string
     */
    public $accessSecret;

    /**
     * @var string
     */
    public $endpoint;

    /**
     * @var bool
     */
    public $isCName = false;

    /**
     * @var string default null
     */
    public $securityToken = null;

    /**
     * @var string
     */
    public $bucket;

    private $_client;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        if ($this->accessKey == null) {
            throw new InvalidParamException('The "accessKey" property must be set.');
        }

        if ($this->accessSecret == null) {
            throw new InvalidParamException('The "accessSecret" property must be set.');
        }

        if ($this->endpoint == null) {
            throw new InvalidParamException('The "endpoint" property must be set.');
        }
    }


    /**
     * @inheritDoc
     */
    public function save($file, $content)
    {
        try {
            $file = $this->normalizeFile($file);
            $this->getClient()->putObject($this->bucket, $file, $content);
            return true;
        } catch (OssException $e) {
            \Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function read($file)
    {
        $file = $this->normalizeFile($file);
        return $this->getClient()->getObject($this->bucket, $file);
    }

    /**
     * @inheritDoc
     */
    public function exists($file)
    {
        $file = $this->normalizeFile($file);
        return $this->getClient()->doesObjectExist($this->bucket, $file);
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
        return implode('/', $sections);
    }

    /**
     * @return OssClient
     */
    public function getClient()
    {
        if ($this->_client == null) {
            $this->_client = new OssClient(
                $this->accessKey,
                $this->accessSecret,
                $this->endpoint,
                $this->isCName,
                $this->securityToken
            );
        }
        return $this->_client;
    }

}