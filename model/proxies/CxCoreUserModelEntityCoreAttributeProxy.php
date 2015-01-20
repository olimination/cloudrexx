<?php

namespace Cx\Model\Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class CxCoreUserModelEntityCoreAttributeProxy extends \Cx\Core\User\Model\Entity\CoreAttribute implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function setId($id)
    {
        $this->_load();
        return parent::setId($id);
    }

    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setMandatory($mandatory)
    {
        $this->_load();
        return parent::setMandatory($mandatory);
    }

    public function getMandatory()
    {
        $this->_load();
        return parent::getMandatory();
    }

    public function setSortType($sortType)
    {
        $this->_load();
        return parent::setSortType($sortType);
    }

    public function getSortType()
    {
        $this->_load();
        return parent::getSortType();
    }

    public function setOrderId($orderId)
    {
        $this->_load();
        return parent::setOrderId($orderId);
    }

    public function getOrderId()
    {
        $this->_load();
        return parent::getOrderId();
    }

    public function setAccessSpecial($accessSpecial)
    {
        $this->_load();
        return parent::setAccessSpecial($accessSpecial);
    }

    public function getAccessSpecial()
    {
        $this->_load();
        return parent::getAccessSpecial();
    }

    public function setAccessId(\Cx\Core_Modules\Access\Model\Entity\AccessId $accessId)
    {
        $this->_load();
        return parent::setAccessId($accessId);
    }

    public function getAccessId()
    {
        $this->_load();
        return parent::getAccessId();
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

    public function __toString()
    {
        $this->_load();
        return parent::__toString();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'mandatory', 'sortType', 'orderId', 'accessSpecial', 'accessId');
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