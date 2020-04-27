<?php

namespace Cx\Model\Proxies\__CG__\Cx\Core\ContentManager\Model\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Page extends \Cx\Core\ContentManager\Model\Entity\Page implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }

    /**
     * {@inheritDoc}
     * @param string $name
     */
    public function __get($name)
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__get', array($name));

        return parent::__get($name);
    }





    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'nodeIdShadowed', 'lang', 'title', 'content', 'sourceMode', 'customContent', 'useCustomContentForAllChannels', 'applicationTemplate', 'useCustomApplicationTemplateForAllChannels', 'cssName', 'metatitle', 'metadesc', 'metakeys', 'metarobots', 'metaimage', 'start', 'end', 'editingStatus', 'display', 'active', 'target', 'module', 'cmd', 'node', 'slugSuffix', 'slugBase', 'skin', 'useSkinForAllChannels', 'type', 'updatedAt', 'slug', 'contentTitle', 'linkTarget', 'frontendAccessId', 'backendAccessId', 'protection', 'cssNavName', 'updatedBy', 'isVirtual', '' . "\0" . 'Cx\\Core\\ContentManager\\Model\\Entity\\Page' . "\0" . 'caching', 'validators', 'virtual');
        }

        return array('__isInitialized__', 'id', 'nodeIdShadowed', 'lang', 'title', 'content', 'sourceMode', 'customContent', 'useCustomContentForAllChannels', 'applicationTemplate', 'useCustomApplicationTemplateForAllChannels', 'cssName', 'metatitle', 'metadesc', 'metakeys', 'metarobots', 'metaimage', 'start', 'end', 'editingStatus', 'display', 'active', 'target', 'module', 'cmd', 'node', 'slugSuffix', 'slugBase', 'skin', 'useSkinForAllChannels', 'type', 'updatedAt', 'slug', 'contentTitle', 'linkTarget', 'frontendAccessId', 'backendAccessId', 'protection', 'cssNavName', 'updatedBy', 'isVirtual', '' . "\0" . 'Cx\\Core\\ContentManager\\Model\\Entity\\Page' . "\0" . 'caching', 'validators', 'virtual');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Page $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function initializeValidators()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'initializeValidators', array());

        return parent::initializeValidators();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setNodeIdShadowed($nodeIdShadowed)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNodeIdShadowed', array($nodeIdShadowed));

        return parent::setNodeIdShadowed($nodeIdShadowed);
    }

    /**
     * {@inheritDoc}
     */
    public function getNodeIdShadowed()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNodeIdShadowed', array());

        return parent::getNodeIdShadowed();
    }

    /**
     * {@inheritDoc}
     */
    public function setLang($lang)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLang', array($lang));

        return parent::setLang($lang);
    }

    /**
     * {@inheritDoc}
     */
    public function getLang()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLang', array());

        return parent::getLang();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitle($title)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitle', array($title));

        return parent::setTitle($title);
    }

    /**
     * {@inheritDoc}
     */
    public function nextSlug()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'nextSlug', array());

        return parent::nextSlug();
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitle', array());

        return parent::getTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContent', array($content));

        return parent::setContent($content);
    }

    /**
     * {@inheritDoc}
     */
    public function setSourceMode($sourceMode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSourceMode', array($sourceMode));

        return parent::setSourceMode($sourceMode);
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContent', array());

        return parent::getContent();
    }

    /**
     * {@inheritDoc}
     */
    public function getSourceMode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSourceMode', array());

        return parent::getSourceMode();
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomContent($customContent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCustomContent', array($customContent));

        return parent::setCustomContent($customContent);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomContent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCustomContent', array());

        return parent::getCustomContent();
    }

    /**
     * {@inheritDoc}
     */
    public function setUseCustomContentForAllChannels($useCustomContentForAllChannels)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUseCustomContentForAllChannels', array($useCustomContentForAllChannels));

        return parent::setUseCustomContentForAllChannels($useCustomContentForAllChannels);
    }

    /**
     * {@inheritDoc}
     */
    public function getUseCustomContentForAllChannels()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUseCustomContentForAllChannels', array());

        return parent::getUseCustomContentForAllChannels();
    }

    /**
     * {@inheritDoc}
     */
    public function setApplicationTemplate($applicationTemplate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setApplicationTemplate', array($applicationTemplate));

        return parent::setApplicationTemplate($applicationTemplate);
    }

    /**
     * {@inheritDoc}
     */
    public function getApplicationTemplate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApplicationTemplate', array());

        return parent::getApplicationTemplate();
    }

    /**
     * {@inheritDoc}
     */
    public function setUseCustomApplicationTemplateForAllChannels($useCustomApplicationTemplateForAllChannels)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUseCustomApplicationTemplateForAllChannels', array($useCustomApplicationTemplateForAllChannels));

        return parent::setUseCustomApplicationTemplateForAllChannels($useCustomApplicationTemplateForAllChannels);
    }

    /**
     * {@inheritDoc}
     */
    public function getUseCustomApplicationTemplateForAllChannels()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUseCustomApplicationTemplateForAllChannels', array());

        return parent::getUseCustomApplicationTemplateForAllChannels();
    }

    /**
     * {@inheritDoc}
     */
    public function setCssName($cssName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCssName', array($cssName));

        return parent::setCssName($cssName);
    }

    /**
     * {@inheritDoc}
     */
    public function getCssName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCssName', array());

        return parent::getCssName();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetatitle($metatitle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetatitle', array($metatitle));

        return parent::setMetatitle($metatitle);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetatitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetatitle', array());

        return parent::getMetatitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetadesc($metadesc)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetadesc', array($metadesc));

        return parent::setMetadesc($metadesc);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadesc()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetadesc', array());

        return parent::getMetadesc();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetakeys($metakeys)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetakeys', array($metakeys));

        return parent::setMetakeys($metakeys);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetakeys()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetakeys', array());

        return parent::getMetakeys();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetarobots($metarobots)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetarobots', array($metarobots));

        return parent::setMetarobots($metarobots);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetarobots()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetarobots', array());

        return parent::getMetarobots();
    }

    /**
     * {@inheritDoc}
     */
    public function setMetaimage($metaimage)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetaimage', array($metaimage));

        return parent::setMetaimage($metaimage);
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaimage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetaimage', array());

        return parent::getMetaimage();
    }

    /**
     * {@inheritDoc}
     */
    public function setStart($start)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStart', array($start));

        return parent::setStart($start);
    }

    /**
     * {@inheritDoc}
     */
    public function getStart()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStart', array());

        return parent::getStart();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnd($end)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnd', array($end));

        return parent::setEnd($end);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnd()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnd', array());

        return parent::getEnd();
    }

    /**
     * {@inheritDoc}
     */
    public function setEditingStatus($editingStatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEditingStatus', array($editingStatus));

        return parent::setEditingStatus($editingStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getEditingStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEditingStatus', array());

        return parent::getEditingStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setDisplay($display)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDisplay', array($display));

        return parent::setDisplay($display);
    }

    /**
     * {@inheritDoc}
     */
    public function getDisplay()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDisplay', array());

        return parent::getDisplay();
    }

    /**
     * {@inheritDoc}
     */
    public function setActive($active)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActive', array($active));

        return parent::setActive($active);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getActive($disregardScheduledPublishing = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActive', array($disregardScheduledPublishing));

        return parent::getActive($disregardScheduledPublishing);
    }

    /**
     * {@inheritDoc}
     */
    public function setTarget($target)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTarget', array($target));

        return parent::setTarget($target);
    }

    /**
     * {@inheritDoc}
     */
    public function getTarget()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTarget', array());

        return parent::getTarget();
    }

    /**
     * {@inheritDoc}
     */
    public function isTargetInternal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isTargetInternal', array());

        return parent::isTargetInternal();
    }

    /**
     * {@inheritDoc}
     */
    public function getTargetNodeId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTargetNodeId', array());

        return parent::getTargetNodeId();
    }

    /**
     * {@inheritDoc}
     */
    public function getTargetLangId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTargetLangId', array());

        return parent::getTargetLangId();
    }

    /**
     * {@inheritDoc}
     */
    public function getTargetModule()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTargetModule', array());

        return parent::getTargetModule();
    }

    /**
     * {@inheritDoc}
     */
    public function getTargetCmd()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTargetCmd', array());

        return parent::getTargetCmd();
    }

    /**
     * {@inheritDoc}
     */
    public function getTargetQueryString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTargetQueryString', array());

        return parent::getTargetQueryString();
    }

    /**
     * {@inheritDoc}
     */
    public function setModule($module)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModule', array($module));

        return parent::setModule($module);
    }

    /**
     * {@inheritDoc}
     */
    public function getModule()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModule', array());

        return parent::getModule();
    }

    /**
     * {@inheritDoc}
     */
    public function setCmd($cmd)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCmd', array($cmd));

        return parent::setCmd($cmd);
    }

    /**
     * {@inheritDoc}
     */
    public function getCmd()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCmd', array());

        return parent::getCmd();
    }

    /**
     * {@inheritDoc}
     */
    public function setNode(\Cx\Core\ContentManager\Model\Entity\Node $node)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNode', array($node));

        return parent::setNode($node);
    }

    /**
     * {@inheritDoc}
     */
    public function getNode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNode', array());

        return parent::getNode();
    }

    /**
     * {@inheritDoc}
     */
    public function setSkin($skin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSkin', array($skin));

        return parent::setSkin($skin);
    }

    /**
     * {@inheritDoc}
     */
    public function getSkin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSkin', array());

        return parent::getSkin();
    }

    /**
     * {@inheritDoc}
     */
    public function setUseSkinForAllChannels($useSkinForAllChannels)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUseSkinForAllChannels', array($useSkinForAllChannels));

        return parent::setUseSkinForAllChannels($useSkinForAllChannels);
    }

    /**
     * {@inheritDoc}
     */
    public function getUseSkinForAllChannels()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUseSkinForAllChannels', array());

        return parent::getUseSkinForAllChannels();
    }

    /**
     * {@inheritDoc}
     */
    public function setCaching($caching)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCaching', array($caching));

        return parent::setCaching($caching);
    }

    /**
     * {@inheritDoc}
     */
    public function getCaching()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCaching', array());

        return parent::getCaching();
    }

    /**
     * {@inheritDoc}
     */
    public function setType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setType', array($type));

        return parent::setType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getType', array());

        return parent::getType();
    }

    /**
     * {@inheritDoc}
     */
    public function validate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'validate', array());

        return parent::validate();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAtToNow()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAtToNow', array());

        return parent::setUpdatedAtToNow();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt($updatedAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', array($updatedAt));

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', array());

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedBy($updatedBy)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedBy', array($updatedBy));

        return parent::setUpdatedBy($updatedBy);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedBy', array());

        return parent::getUpdatedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function isFrontendProtected()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isFrontendProtected', array());

        return parent::isFrontendProtected();
    }

    /**
     * {@inheritDoc}
     */
    public function isBackendProtected()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isBackendProtected', array());

        return parent::isBackendProtected();
    }

    /**
     * {@inheritDoc}
     */
    public function setFrontendProtection($enabled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFrontendProtection', array($enabled));

        return parent::setFrontendProtection($enabled);
    }

    /**
     * {@inheritDoc}
     */
    public function setBackendProtection($enabled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBackendProtection', array($enabled));

        return parent::setBackendProtection($enabled);
    }

    /**
     * {@inheritDoc}
     */
    public function isVisible()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isVisible', array());

        return parent::isVisible();
    }

    /**
     * {@inheritDoc}
     */
    public function isActive($disregardScheduledPublishing = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isActive', array($disregardScheduledPublishing));

        return parent::isActive($disregardScheduledPublishing);
    }

    /**
     * {@inheritDoc}
     */
    public function setSlug($slug, $nextSlugCall = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSlug', array($slug, $nextSlugCall));

        return parent::setSlug($slug, $nextSlugCall);
    }

    /**
     * {@inheritDoc}
     */
    public function getSlug()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSlug', array());

        return parent::getSlug();
    }

    /**
     * {@inheritDoc}
     */
    public function copy($includeContent = true, $includeModuleAndCmd = true, $includeName = true, $includeMetaData = true, $includeProtection = true, $includeEditingStatus = true, $followRedirects = false, $followFallbacks = false, $page = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'copy', array($includeContent, $includeModuleAndCmd, $includeName, $includeMetaData, $includeProtection, $includeEditingStatus, $followRedirects, $followFallbacks, $page));

        return parent::copy($includeContent, $includeModuleAndCmd, $includeName, $includeMetaData, $includeProtection, $includeEditingStatus, $followRedirects, $followFallbacks, $page);
    }

    /**
     * {@inheritDoc}
     */
    public function copyProtection($page, $frontend)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'copyProtection', array($page, $frontend));

        return parent::copyProtection($page, $frontend);
    }

    /**
     * {@inheritDoc}
     */
    public function copyToNode($destinationNode, $includeContent = true, $includeModuleAndCmd = true, $includeName = true, $includeMetaData = true, $includeProtection = true, $includeEditingStatus = true, $followRedirects = false, $followFallbacks = false, $page = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'copyToNode', array($destinationNode, $includeContent, $includeModuleAndCmd, $includeName, $includeMetaData, $includeProtection, $includeEditingStatus, $followRedirects, $followFallbacks, $page));

        return parent::copyToNode($destinationNode, $includeContent, $includeModuleAndCmd, $includeName, $includeMetaData, $includeProtection, $includeEditingStatus, $followRedirects, $followFallbacks, $page);
    }

    /**
     * {@inheritDoc}
     */
    public function copyToLang($destinationLang, $includeContent = true, $includeModuleAndCmd = true, $includeName = true, $includeMetaData = true, $includeProtection = true, $includeEditingStatus = true, $followRedirects = false, $followFallbacks = false, $page = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'copyToLang', array($destinationLang, $includeContent, $includeModuleAndCmd, $includeName, $includeMetaData, $includeProtection, $includeEditingStatus, $followRedirects, $followFallbacks, $page));

        return parent::copyToLang($destinationLang, $includeContent, $includeModuleAndCmd, $includeName, $includeMetaData, $includeProtection, $includeEditingStatus, $followRedirects, $followFallbacks, $page);
    }

    /**
     * {@inheritDoc}
     */
    public function setContentTitle($contentTitle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContentTitle', array($contentTitle));

        return parent::setContentTitle($contentTitle);
    }

    /**
     * {@inheritDoc}
     */
    public function getContentTitle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContentTitle', array());

        return parent::getContentTitle();
    }

    /**
     * {@inheritDoc}
     */
    public function setLinkTarget($linkTarget)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLinkTarget', array($linkTarget));

        return parent::setLinkTarget($linkTarget);
    }

    /**
     * {@inheritDoc}
     */
    public function getLinkTarget()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLinkTarget', array());

        return parent::getLinkTarget();
    }

    /**
     * {@inheritDoc}
     */
    public function setFrontendAccessId($frontendAccessId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFrontendAccessId', array($frontendAccessId));

        return parent::setFrontendAccessId($frontendAccessId);
    }

    /**
     * {@inheritDoc}
     */
    public function getFrontendAccessId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFrontendAccessId', array());

        return parent::getFrontendAccessId();
    }

    /**
     * {@inheritDoc}
     */
    public function setBackendAccessId($backendAccessId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBackendAccessId', array($backendAccessId));

        return parent::setBackendAccessId($backendAccessId);
    }

    /**
     * {@inheritDoc}
     */
    public function getBackendAccessId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBackendAccessId', array());

        return parent::getBackendAccessId();
    }

    /**
     * {@inheritDoc}
     */
    public function getProtection()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProtection', array());

        return parent::getProtection();
    }

    /**
     * {@inheritDoc}
     */
    public function isVirtual()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isVirtual', array());

        return parent::isVirtual();
    }

    /**
     * {@inheritDoc}
     */
    public function setVirtual($virtual = true)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVirtual', array($virtual));

        return parent::setVirtual($virtual);
    }

    /**
     * {@inheritDoc}
     */
    public function setContentOf($page, $includeThemeOptions = false)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContentOf', array($page, $includeThemeOptions));

        return parent::setContentOf($page, $includeThemeOptions);
    }

    /**
     * {@inheritDoc}
     */
    public function setCssNavName($cssNavName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCssNavName', array($cssNavName));

        return parent::setCssNavName($cssNavName);
    }

    /**
     * {@inheritDoc}
     */
    public function getCssNavName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCssNavName', array());

        return parent::getCssNavName();
    }

    /**
     * {@inheritDoc}
     */
    public function setAlias($data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAlias', array($data));

        return parent::setAlias($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getAliases()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAliases', array());

        return parent::getAliases();
    }

    /**
     * {@inheritDoc}
     */
    public function updateFromArray($newData)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'updateFromArray', array($newData));

        return parent::updateFromArray($newData);
    }

    /**
     * {@inheritDoc}
     */
    public function setProtection($protection)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProtection', array($protection));

        return parent::setProtection($protection);
    }

    /**
     * {@inheritDoc}
     */
    public function setupPath($targetLang)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setupPath', array($targetLang));

        return parent::setupPath($targetLang);
    }

    /**
     * {@inheritDoc}
     */
    public function getPath()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPath', array());

        return parent::getPath();
    }

    /**
     * {@inheritDoc}
     */
    public function getURL($protocolAndDomainWithPathOffset, $params)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getURL', array($protocolAndDomainWithPathOffset, $params));

        return parent::getURL($protocolAndDomainWithPathOffset, $params);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParent', array());

        return parent::getParent();
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getChildren', array());

        return parent::getChildren();
    }

    /**
     * {@inheritDoc}
     */
    public function getFallback()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFallback', array());

        return parent::getFallback();
    }

    /**
     * {@inheritDoc}
     */
    public function getLastModificationDateTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLastModificationDateTime', array());

        return parent::getLastModificationDateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function getChangeFrequency()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getChangeFrequency', array());

        return parent::getChangeFrequency();
    }

    /**
     * {@inheritDoc}
     */
    public function getRelatedBlocks()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRelatedBlocks', array());

        return parent::getRelatedBlocks();
    }

    /**
     * {@inheritDoc}
     */
    public function setRelatedBlocks($relatedBlocks)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRelatedBlocks', array($relatedBlocks));

        return parent::setRelatedBlocks($relatedBlocks);
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVersion', array());

        return parent::getVersion();
    }

    /**
     * {@inheritDoc}
     */
    public function isDraft()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isDraft', array());

        return parent::isDraft();
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'serialize', array());

        return parent::serialize();
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($data)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'unserialize', array($data));

        return parent::unserialize($data);
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgetContentAttributeName($widgetName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWidgetContentAttributeName', array($widgetName));

        return parent::getWidgetContentAttributeName($widgetName);
    }

    /**
     * {@inheritDoc}
     */
    public function titleExists($parentNode, $lang, $title)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'titleExists', array($parentNode, $lang, $title));

        return parent::titleExists($parentNode, $lang, $title);
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgetContent($widgetName, $theme, $page, $channel)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWidgetContent', array($widgetName, $theme, $page, $channel));

        return parent::getWidgetContent($widgetName, $theme, $page, $channel);
    }

    /**
     * {@inheritDoc}
     */
    public function getComponentController()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComponentController', array());

        return parent::getComponentController();
    }

    /**
     * {@inheritDoc}
     */
    public function __call($methodName, $arguments)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__call', array($methodName, $arguments));

        return parent::__call($methodName, $arguments);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__toString', array());

        return parent::__toString();
    }

}
