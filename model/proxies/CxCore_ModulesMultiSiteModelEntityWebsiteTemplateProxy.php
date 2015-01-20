<?php

namespace Cx\Model\Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class CxCore_ModulesMultiSiteModelEntityWebsiteTemplateProxy extends \Cx\Core_Modules\MultiSite\Model\Entity\WebsiteTemplate implements \Doctrine\ORM\Proxy\Proxy
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

    public function setName($name)
    {
        $this->_load();
        return parent::setName($name);
    }

    public function getName()
    {
        $this->_load();
        return parent::getName();
    }

    public function setCodeBase($codeBase)
    {
        $this->_load();
        return parent::setCodeBase($codeBase);
    }

    public function getCodeBase()
    {
        $this->_load();
        return parent::getCodeBase();
    }

    public function setWebsiteServiceServer($websiteServiceServer)
    {
        $this->_load();
        return parent::setWebsiteServiceServer($websiteServiceServer);
    }

    public function getWebsiteServiceServer()
    {
        $this->_load();
        return parent::getWebsiteServiceServer();
    }

    public function setLicensedComponents($licensedComponents)
    {
        $this->_load();
        return parent::setLicensedComponents($licensedComponents);
    }

    public function getLicensedComponents()
    {
        $this->_load();
        return parent::getLicensedComponents();
    }

    public function setLicenseMessage($licenseMessage)
    {
        $this->_load();
        return parent::setLicenseMessage($licenseMessage);
    }

    public function getLicenseMessage()
    {
        $this->_load();
        return parent::getLicenseMessage();
    }

    public function getWebsiteCollections()
    {
        $this->_load();
        return parent::getWebsiteCollections();
    }

    public function addWebsiteCollection(\Cx\Core_Modules\MultiSite\Model\Entity\WebsiteCollection $websiteCollection)
    {
        $this->_load();
        return parent::addWebsiteCollection($websiteCollection);
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
        return array('__isInitialized__', 'id', 'name', 'codeBase', 'licensedComponents', 'licenseMessage', 'websiteCollections', 'websiteServiceServer');
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