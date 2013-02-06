<?php

namespace Cx\Lib;

/**
 * Social Login
 *
 * This class is used to provide a support for social media login.
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Ueli Kramer <ueli.kramer@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  lib_framework
 */
class SocialLogin
{
    private static $providers = array();

    public function __construct()
    {
        self::$providers = self::getProviders();
    }

    /**
     * Login with a provider.
     * Loads the correct provider class from Lib\OAuth\.. and uses his methods to
     * login to the social platform
     *
     * @param string $provider the chosen oauth provider
     * @return null if the chosen oauth provider does not exist
     */
    public function loginWithProvider($provider)
    {
        if (!self::$providers[$provider]->isActive()
            || !isset(self::$providers[$provider])
        ) {
            return null;
        }
        self::$providers[$provider]->login();
    }

    /**
     * Get the oauth class of the provider
     *
     * @static
     * @param string $provider the provider name
     * @return null|OAuth
     */
    public static function getClassByProvider($provider)
    {
        $class = '\Cx\Lib\OAuth\\' . ucfirst($provider);
        if (class_exists($class)) {
            return $class;
        }
        return null;
    }

    /**
     * Gets all the providers from the setting db.
     *
     * @static
     * @return array the providers and their data
     */
    public static function getProviders()
    {
        \SettingDb::init('access', 'sociallogin');

        $settingProviders = json_decode(\SettingDb::getValue('providers'));
        foreach ($settingProviders as $providerName => $providerData) {
            $class = self::getClassByProvider($providerName);
            if ($class != null) {
                $oauthProvider = new $class;
                $oauthProvider->setApplicationData($providerData->settings);
                $oauthProvider->setActive($providerData->active);
                self::$providers[$providerName] = $oauthProvider;
            }
        }
        return self::$providers;
    }

    /**
     * Updates the providers and write changes to the setting db.
     * The provider array has to be two dimensional.
     *
     * array(
     *     ProviderName1 => array(provider_app_id, provider_app_secret),
     *     ProviderName1 => array(provider_app_id, provider_app_secret),
     * )
     *
     * @static
     * @param array $providers the new provider data
     */
    public static function updateProviders($providers)
    {
        \SettingDb::init('access', 'sociallogin');
        \SettingDb::set('providers', json_encode($providers));
        \SettingDb::update('providers');
    }

    /**
     * Generates the contrexx login link to log in with the given provider.
     * This can be used to generate the redirect url.
     *
     * @static
     * @param string $provider the provider name
     * @param string|null $redirect the redirect url
     * @return string
     */
    public static function getLoginUrl($provider, $redirect = null)
    {
        global $_CONFIG, $objInit;
        return ASCMS_PROTOCOL . '://' . $_CONFIG['domainUrl'] . ASCMS_PATH_OFFSET . '/' .
            \FWLanguage::getLanguageCodeById($objInit->getDefaultFrontendLangId()) .
            '/index.php?section=login&provider=' . $provider . (!empty($redirect) ? '&redirect=' . $redirect : '');
    }

    /**
     * Parse the sociallogin login buttons in the template given.
     *
     * @static
     * @param $objTpl template object to parse
     * @param string $prefix the prefix for the template blocks and variables
     */
    public static function parseSociallogin($objTpl, $prefix = 'login_')
    {
        $arrSettings = \User_Setting::getSettings();
        if ($arrSettings['sociallogin']['status'] && !isset($_SESSION['user_id'])) {
            if (!empty($_GET['redirect'])) {
                $_SESSION['redirect'] = $_GET['redirect'];
            }
            $redirect = $_SESSION['redirect'];
            $socialloginProviders = \Cx\Lib\SocialLogin::getProviders();
            foreach ($socialloginProviders as $provider => $providerData) {
                if (!$objTpl->blockExists($prefix . 'social_networks_' . $provider)) {
                    continue;
                }

                $objTpl->setVariable(strtoupper($prefix) . 'SOCIALLOGIN_' . strtoupper($provider), contrexx_raw2xhtml(\Cx\Lib\SocialLogin::getLoginUrl($provider, $redirect)));
                if ($providerData->isActive()) {
                    $objTpl->touchBlock($prefix . 'social_networks_' . $provider);
                } else {
                    $objTpl->hideBlock($prefix . 'social_networks_' . $provider);
                }
            }
        } else {
            if ($objTpl->blockExists($prefix . 'social_networks')) {
                $objTpl->hideBlock($prefix . 'social_networks');
            }
        }
    }
}
