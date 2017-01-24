<?php

namespace Cx\Model\Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class CxModulesBlockModelEntityRelPagesProxy extends \Cx\Modules\Block\Model\Entity\RelPages implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function setBlockId($blockId)
    {
        $this->_load();
        return parent::setBlockId($blockId);
    }

    public function getBlockId()
    {
        $this->_load();
        return parent::getBlockId();
    }

    public function setPageId($pageId)
    {
        $this->_load();
        return parent::setPageId($pageId);
    }

    public function getPageId()
    {
        $this->_load();
        return parent::getPageId();
    }

    public function setPlaceholder($placeholder)
    {
        $this->_load();
        return parent::setPlaceholder($placeholder);
    }

    public function getPlaceholder()
    {
        $this->_load();
        return parent::getPlaceholder();
    }

    public function setBlocks(\Cx\Modules\Block\Model\Entity\Blocks $blocks)
    {
        $this->_load();
        return parent::setBlocks($blocks);
    }

    public function getBlocks()
    {
        $this->_load();
        return parent::getBlocks();
    }

    public function setContentPage(\Cx\Core\ContentManager\Model\Entity\Page $contentPage)
    {
        $this->_load();
        return parent::setContentPage($contentPage);
    }

    public function getContentPage()
    {
        $this->_load();
        return parent::getContentPage();
    }

    public function __get($name)
    {
        $this->_load();
        return parent::__get($name);
    }

    public function getComponentController()
    {
        $this->_load();
        return parent::getComponentController();
    }

    public function setVirtual($virtual)
    {
        $this->_load();
        return parent::setVirtual($virtual);
    }

    public function isVirtual()
    {
        $this->_load();
        return parent::isVirtual();
    }

    public function validate()
    {
        $this->_load();
        return parent::validate();
    }

    public function __call($methodName, $arguments)
    {
        $this->_load();
        return parent::__call($methodName, $arguments);
    }

    public function __toString()
    {
        $this->_load();
        return parent::__toString();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'blockId', 'pageId', 'placeholder', 'blocks', 'contentPage');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}