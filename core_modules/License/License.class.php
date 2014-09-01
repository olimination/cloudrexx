<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Cx\Core_Modules\License;

/**
 * Description of License
 *
 * @author ritt0r
 */
class License {
    const LICENSE_OK = 'OK';
    const LICENSE_NOK = 'NOK';
    const LICENSE_DEMO = 'DEMO';
    const LICENSE_ERROR = 'ERROR';
    const INFINITE_VALIDITY = 0;
    private static $staticModules = array(
        'license',
        'logout',
        'Error',
        'Captcha',
        'upgrade',
        'noaccess',
        'fulllanguage'
    );
    private $state;
    private $frontendLocked = false;
    private $editionName;
    private $availableComponents;
    private $legalComponents;
    private $legalFrontendComponents;
    private $validTo;
    private $upgradeUrl;
    private $createdAt;
    private $registeredDomains = array();
    private $instId;
    private $licenseKey;
    private $messages;
    private $version;
    private $partner;
    private $customer;
    private $grayzoneTime;
    private $grayzoneMessages;
    private $frontendLockTime;
    private $requestInterval;
    private $firstFailedUpdate;
    private $lastSuccessfulUpdate;
    private $isUpgradable = false;
    private $dashboardMessages;
    
    public function __construct(
            $state = self::LICENSE_DEMO,
            $editionName = '',
            $availableComponents = array(),
            $legalComponents = array(),
            $validTo = '',
            $createdAt = '',
            $registeredDomains = array(),
            $instId = '',
            $licenseKey = '',
            $messages = array(),
            $version = '',
            $partner = null,
            $customer = null,
            $grayzoneTime = 14,
            $grayzoneMessages = array(),
            $frontendLockTime = 10,
            $requestInterval = 1,
            $firstFailedUpdate = 0,
            $lastSuccessfulUpdate = 0,
            $upgradeUrl = '',
            $isUpgradable,
            $dashboardMessages
    ) {
        $this->state = $state;
        $this->editionName = $editionName;
        $this->availableComponents = $availableComponents;
        $this->legalComponents = $legalComponents;
        $this->validTo = $validTo;
        $this->createdAt = $createdAt;
        $this->registeredDomains = is_array($registeredDomains) ? $registeredDomains : array();
        $this->instId = $instId;
        $this->licenseKey = $licenseKey;
        $this->messages = is_array($messages) ? $messages : array();
        $this->version = $version;

        if ($partner instanceof Person) {
            $this->partner = $partner;
        } else { 
            $this->partner = new Person();
        }

        if ($customer instanceof Person) {
            $this->customer = $customer;
        } else {
            $this->customer = new Person();
        }

        $this->grayzoneTime = $grayzoneTime;
        $this->grayzoneMessages = is_array($grayzoneMessages) ? $grayzoneMessages : array();
        $this->frontendLockTime = $frontendLockTime;
        $this->requestInterval = $requestInterval;
        $this->upgradeUrl = $upgradeUrl;
        $this->isUpgradable = $isUpgradable;
        $this->dashboardMessages = $dashboardMessages;
        $this->setFirstFailedUpdateTime($firstFailedUpdate);
        $this->setLastSuccessfulUpdateTime($lastSuccessfulUpdate);
    }
    
    public function getState() {
        return $this->state;
    }
    
    public function setState($state) {
        $this->state = $state;
        if ($this->state == self::LICENSE_ERROR) {
            $this->setFirstFailedUpdateTime(time());
        }
    }
    
    public function isFrontendLocked() {
        return $this->frontendLocked;
    }
    
    public function getEditionName() {
        return $this->editionName;
    }
    
    public function getAvailableComponents() {
        return $this->availableComponents;
    }
    
    public function getLegalComponentsList() {
        return $this->legalComponents;
    }

    public function setLegalComponents($legalComponents) {
        $this->legalComponents = $legalComponents;
    }
    
    public function isInLegalComponents($componentName) {
        return in_array($componentName, $this->legalComponents);
    }
    
    public function getLegalFrontendComponentsList() {
        if (!$this->legalFrontendComponents) {
            return $this->getLegalComponentsList();
        }
        return $this->legalFrontendComponents;
    }
    
    public function isInLegalFrontendComponents($componentName) {
        return in_array($componentName, $this->getLegalFrontendComponentsList());
    }
    
    public function getValidToDate() {
        return $this->validTo;
    }
    
    public function setValidToDate($timestamp) {
        $this->validTo = $timestamp;
    }
    
    public function getUpgradeUrl() {
        return $this->upgradeUrl;
    }
    
    public function getCreatedAtDate() {
        return $this->createdAt;
    }
    
    public function getRegisteredDomains() {
        return $this->registeredDomains;
    }
    
    public function getInstallationId() {
        return $this->instId;
    }
    
    public function getLicenseKey() {
        return $this->licenseKey;
    }
    
    public function setLicenseKey($key) {
        $this->licenseKey = $key;
    }
    
    public function getMessages() {
        return $this->messages;
    }
    
    public function getDashboardMessages() {
        return $this->dashboardMessages;
    }

    public function setMessages($messages) {
        $this->messages = $messages;
    }    

    public function setGrayZoneMessages($grayzoneMessages) {
        $this->grayzoneMessages = $grayzoneMessages;
    }    

    /**
     *
     * @return Message
     */
    public function getMessage($dashboard, $langCode, $_CORELANG) {
        // return gray zone message in case of an error
        if ($this->getState() == self::LICENSE_ERROR) {
            return $this->getGrayzoneMessage($langCode, $_CORELANG);
        }

        $messages = $this->messages;
        if ($dashboard) {
            $messages = $this->dashboardMessages;
        }
        // return message in prefered localized version
        return $this->getMessageInPreferedLanguage($messages, $langCode);
    }

    /**
     * Select the prefered locale version of a message
     * @param   array   Array containing all localized versions of a message with its language code as index
     * @param   string  Preferend Language code
     * @return  mixed   Either the prefered message as string or NULL if $messages is empty
     */
    private function getMessageInPreferedLanguage($messages, $langCode)
    {
        // check if a message is available
        if (empty($messages)) {
            return new Message();
        }

        // return message in selected (=> current interface) language
        if (isset($messages[$langCode])) {
            return $messages[$langCode];
        }

        // return message in default language
        if (isset($messages[\FWLanguage::getLanguageCodeById(\FWLanguage::getDefaultLangId())])) {
            return $messages[\FWLanguage::getLanguageCodeById(\FWLanguage::getDefaultLangId())];
        }

        // return message in what ever language it is available
        reset($messages);
        return current($messages);
    }
    
    public function isUpgradable() {
        return $this->isUpgradable;
    }
    
    /**
     *
     * @return Version
     */
    public function getVersion() {
        return $this->version;
    }
    
    public function getPartner() {
        return $this->partner;
    }
    
    public function getCustomer() {
        return $this->customer;
    }
    
    public function getGrayzoneTime() {
        return $this->grayzoneTime;
    }
    
    public function getGrayzoneMessages() {
        return $this->grayzoneMessages;
    }
    
    /**
     *
     * @return Message
     */
    public function getGrayzoneMessage($langCode, $_CORELANG) {
        if (empty($this->grayzoneMessages)) {
            $this->setGrayzoneMessages(array($langCode => new Message($langCode, $_CORELANG['TXT_LICENSE_DEFAULT_GRAYZONE_MESSAGE'])));
        }

        // return message in prefered localized version
        return $this->getMessageInPreferedLanguage($this->grayzoneMessages, $langCode);
    }
    
    public function getFrontendLockTime() {
        return $this->frontendLockTime;
    }
    
    public function getRequestInterval() {
        return $this->requestInterval;
    }
    
    public function getFirstFailedUpdateTime() {
        return $this->firstFailedUpdate;
    }
    
    public function setFirstFailedUpdateTime($time) {
        if ($this->firstFailedUpdate == 0) {
            $this->firstFailedUpdate = $time;
        }
    }
    
    public function getLastSuccessfulUpdateTime() {
        return $this->lastSuccessfulUpdate;
    }
    
    public function setLastSuccessfulUpdateTime($time) {
        if ($time > $this->firstFailedUpdate) {
            $this->firstFailedUpdate = 0;
            $this->lastSuccessfulUpdate = $time;
        }
    }
    
    public function check() {
        // check checksum
        if (!$this->checkSum($this->instId, false) || !$this->checkSum($this->licenseKey)) {
            $this->state = self::LICENSE_ERROR;
        }
        $validTo = 0;
        switch ($this->state) {
            case self::LICENSE_DEMO:
            case self::LICENSE_OK:
            case self::LICENSE_NOK:
                $validTo = $this->validTo;
                break;
            case self::LICENSE_ERROR:
                $this->setFirstFailedUpdateTime(mktime(0,0,0,date('n'),date('j'),date('Y')));
                $validTo = $this->getFirstFailedUpdateTime() + 60*60*24*$this->grayzoneTime;
                break;
        }

        // in case if one of the following is TRUE, the system will be in lock-down-mode
        // - no installation-ID set
        // - no license-Key available
        // - license has expired
        // - license is invalid
        if ($validTo + 60*60*24 < time() || $validTo === self::INFINITE_VALIDITY || $this->state == self::LICENSE_NOK) {
            $this->state = self::LICENSE_NOK;
            $this->legalFrontendComponents = $this->legalComponents;
            $this->legalComponents = self::$staticModules;
            if ($this->frontendLockTime !== 'false' && $validTo + 60*60*24*($this->frontendLockTime + 1) < time()) {
                $this->frontendLocked = true;
                $this->legalFrontendComponents = self::$staticModules;
            }
        }
        $this->setValidToDate($validTo);
    }
    
    public function checkSum($key, $id = true) {
        $length = 40;
        if ($id) {
            $id = $this->getInstallationId();
            if ($key == $id) {
                return false;
            }
        }
        if (strlen($key) != $length) {
            return false;
        }
        $realKey = substr($key, 0, $length - 8);
        $realChecksum = str_pad(dechex(crc32($realKey)), 8, '0', STR_PAD_LEFT);
        return $key === $realKey.$realChecksum;
    }
    
    /**
     *
     * @global type $_POST
     * @param \settingsManager $settingsManager
     * @param \ADONewConnection $objDb 
     */
    public function save($objDb) {
        \Cx\Core\Setting\Controller\Setting::init('Config', 'license','Yaml');

        \Cx\Core\Setting\Controller\Setting::set('installationId', $this->getInstallationId());
        \Cx\Core\Setting\Controller\Setting::set('licenseKey', $this->getLicenseKey());
        \Cx\Core\Setting\Controller\Setting::set('licenseState', $this->getState());
        \Cx\Core\Setting\Controller\Setting::set('licenseValidTo', $this->getValidToDate());
        \Cx\Core\Setting\Controller\Setting::set('coreCmsEdition', $this->getEditionName());
        
        // we must encode the serialized objects to prevent that non-ascii chars
        // get written into the config/settings.php file
        \Cx\Core\Setting\Controller\Setting::set('licenseMessage', base64_encode(serialize($this->getMessages())));

        \Cx\Core\Setting\Controller\Setting::set('licenseCreatedAt', $this->getCreatedAtDate());
        \Cx\Core\Setting\Controller\Setting::set('licenseDomains', base64_encode(serialize($this->getRegisteredDomains())));
        \Cx\Core\Setting\Controller\Setting::set('licenseGrayzoneMessages', base64_encode(serialize($this->getGrayzoneMessages())));

        \Cx\Core\Setting\Controller\Setting::set('coreCmsVersion', $this->getVersion()->getNumber());
        \Cx\Core\Setting\Controller\Setting::set('coreCmsCodeName', $this->getVersion()->getCodeName());
        \Cx\Core\Setting\Controller\Setting::set('coreCmsStatus', $this->getVersion()->getState());
        \Cx\Core\Setting\Controller\Setting::set('coreCmsReleaseDate', $this->getVersion()->getReleaseDate());
        
        // see comment above why we encode the serialized data here
        \Cx\Core\Setting\Controller\Setting::set('licensePartner', base64_encode(serialize($this->getPartner())));
        \Cx\Core\Setting\Controller\Setting::set('licenseCustomer', base64_encode(serialize($this->getCustomer())));

        \Cx\Core\Setting\Controller\Setting::set('availableComponents', base64_encode(serialize($this->getAvailableComponents())));
        
        \Cx\Core\Setting\Controller\Setting::set('upgradeUrl', $this->getUpgradeUrl());
        \Cx\Core\Setting\Controller\Setting::set('isUpgradable', ($this->isUpgradable() ? 'on' : 'off'));

        \Cx\Core\Setting\Controller\Setting::set('dashboardMessages', base64_encode(serialize($this->getDashboardMessages())));

        \Cx\Core\Setting\Controller\Setting::set('coreCmsName', $this->getVersion()->getName());
                
        \Cx\Core\Setting\Controller\Setting::set('licenseGrayzoneTime', $this->getGrayzoneTime());
        \Cx\Core\Setting\Controller\Setting::set('licenseLockTime', $this->getFrontendLockTime());
        \Cx\Core\Setting\Controller\Setting::set('licenseUpdateInterval', $this->getRequestInterval());
                
        \Cx\Core\Setting\Controller\Setting::set('licenseFailedUpdate', $this->getFirstFailedUpdateTime());
        \Cx\Core\Setting\Controller\Setting::set('licenseSuccessfulUpdate', $this->getLastSuccessfulUpdateTime());

        \Cx\Core\Setting\Controller\Setting::updateAll();
        
        $query = '
            UPDATE
                '.DBPREFIX.'modules
            SET
                `is_licensed` = \'0\'
            WHERE
                `distributor` = \'Comvation AG\'
        ';
        $objDb->Execute($query);
        $query = '
            UPDATE
                '.DBPREFIX.'modules
            SET
                `is_licensed` = \'1\'
            WHERE
                `name` IN(\'' . implode('\', \'', $this->getLegalComponentsList()) . '\')
        ';
        $objDb->Execute($query);
    }
    
    /**
     * @param array             $_CONFIG    Reference to the basic settings ($_CONFIG)
     * @param ADONewConnection  $objDb      Database connection object
     * @return \Cx\Core_Modules\License\License
     */
    public static function getCached(&$_CONFIG, $objDb) {
        $state = isset($_CONFIG['licenseState']) ? htmlspecialchars_decode($_CONFIG['licenseState']) : self::LICENSE_DEMO;
        $validTo = isset($_CONFIG['licenseValidTo']) ? htmlspecialchars_decode($_CONFIG['licenseValidTo']) : null;
        $editionName = isset($_CONFIG['coreCmsEdition']) ? htmlspecialchars_decode($_CONFIG['coreCmsEdition']) : null;
        $instId = isset($_CONFIG['installationId']) ? htmlspecialchars_decode($_CONFIG['installationId']) : null;
        $licenseKey = isset($_CONFIG['licenseKey']) ? htmlspecialchars_decode($_CONFIG['licenseKey']) : null;
        
        $messages = isset($_CONFIG['licenseMessage']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseMessage']))) : array();
        
        $createdAt = isset($_CONFIG['licenseCreatedAt']) ? htmlspecialchars_decode($_CONFIG['licenseCreatedAt']) : null;
        $registeredDomains = isset($_CONFIG['licenseDomains']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseDomains']))) : array();
        
        $grayzoneMessages = isset($_CONFIG['licenseGrayzoneMessages']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseGrayzoneMessages']))) : array();
        $dashboardMessages = isset($_CONFIG['dashboardMessages']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['dashboardMessages']))) : array();
        
        $partner = isset($_CONFIG['licensePartner']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licensePartner']))) : new Person();
        $customer = isset($_CONFIG['licenseCustomer']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['licenseCustomer']))) : new Person();
        
        $versionNumber = isset($_CONFIG['coreCmsVersion']) ? htmlspecialchars_decode($_CONFIG['coreCmsVersion']) : null;
        $versionName = isset($_CONFIG['coreCmsName']) ? htmlspecialchars_decode($_CONFIG['coreCmsName']) : null;
        $versionCodeName = isset($_CONFIG['coreCmsCodeName']) ? htmlspecialchars_decode($_CONFIG['coreCmsCodeName']) : null;
        $versionState = isset($_CONFIG['coreCmsStatus']) ? htmlspecialchars_decode($_CONFIG['coreCmsStatus']) : null;
        $versionReleaseDate = isset($_CONFIG['coreCmsReleaseDate']) ? htmlspecialchars_decode($_CONFIG['coreCmsReleaseDate']) : null;
        $version = new Version($versionNumber, $versionName, $versionCodeName, $versionState, $versionReleaseDate);
        
        $grayzoneTime = isset($_CONFIG['licenseGrayzoneTime']) ? htmlspecialchars_decode($_CONFIG['licenseGrayzoneTime']) : null;
        $lockTime = isset($_CONFIG['licenseLockTime']) ? htmlspecialchars_decode($_CONFIG['licenseLockTime']) : null;
        $updateInterval = isset($_CONFIG['licenseUpdateInterval']) ? htmlspecialchars_decode($_CONFIG['licenseUpdateInterval']) : null;
        $failedUpdate = isset($_CONFIG['licenseFailedUpdate']) ? htmlspecialchars_decode($_CONFIG['licenseFailedUpdate']) : null;
        $successfulUpdate = isset($_CONFIG['licenseSuccessfulUpdate']) ? htmlspecialchars_decode($_CONFIG['licenseSuccessfulUpdate']) : null;
        $upgradeUrl = isset($_CONFIG['upgradeUrl']) ? htmlspecialchars_decode($_CONFIG['upgradeUrl']) : null;
        $isUpgradable = isset($_CONFIG['isUpgradable']) ? $_CONFIG['isUpgradable'] == 'on' : false;
        
        $availableComponents = isset($_CONFIG['availableComponents']) ? unserialize(base64_decode(htmlspecialchars_decode($_CONFIG['availableComponents']))) : array();
        
        $query = '
            SELECT
                `name`
            FROM
                '.DBPREFIX.'modules
            WHERE
                `distributor` != \'Comvation AG\'
                OR
                `is_licensed` = \'1\'
        ';
        $result = $objDb->execute($query);
        $activeComponents = array();
        if ($result) {
            while (!$result->EOF) {
                $activeComponents[] = $result->fields['name'];
                $result->MoveNext();
            }
        }
        return new static(
            $state,
            $editionName,
            $availableComponents,
            $activeComponents,
            $validTo,
            $createdAt,
            $registeredDomains,
            $instId,
            $licenseKey,
            $messages,
            $version,
            $partner,
            $customer,
            $grayzoneTime,
            $grayzoneMessages,
            $lockTime,
            $updateInterval,
            $failedUpdate,
            $successfulUpdate,
            $upgradeUrl,
            $isUpgradable,
            $dashboardMessages
        );
    }
}
