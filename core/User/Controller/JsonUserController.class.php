<?php
/**
 * Cloudrexx
 *
 * @link      http://www.cloudrexx.com
 * @copyright Cloudrexx AG 2007-2019
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Cloudrexx" is a registered trademark of Cloudrexx AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

/**
 * JsonController for DataAccess
 *
 * @copyright   Cloudrexx AG
 * @author      Sam Hawkes <info@cloudrexx.com>
 * @package     cloudrexx
 * @subpackage  core_user
 * @version     5.0.0
 */
namespace Cx\Core\User\Controller;


class JsonUserController
    extends \Cx\Core\Core\Model\Entity\Controller
    implements \Cx\Core\Json\JsonAdapter
{
    /**
     * Returns the internal name used as identifier for this adapter
     * @return String Name of this adapter
     */
    public function getName()
    {
        return 'User';
    }

    /**
     * Returns an array of method names accessable from a JSON request
     *
     * @return array List of method names
     */
    public function getAccessableMethods()
    {
        return array(
            'getAttributeValues',
            'storeUserAttributeValue',
            'getPasswordField',
            'getRoleIcon',
            'filterCallback',
            'storeNewsletter',
            'storeDownloadExtension',
            'storeOnlyNewsletterLists',
        );
    }

    /**
     * Returns all messages as string
     *
     * @return String HTML encoded error messages
     */
    public function getMessagesAsString()
    {
        return implode('<br />', $this->messages);
    }

    /**
     * Returns default permission as object
     *
     * @return \Cx\Core_Modules\Access\Model\Entity\Permission
     */
    public function getDefaultPermissions()
    {
        $permission = new \Cx\Core_Modules\Access\Model\Entity\Permission(
            array('http', 'https'),
            array('get', 'post'),
            true,
            array()
        );

        return $permission;
    }

    /**
     * Store UserAttribute manually because these are custom options
     *
     * @param $param array parameters for callback
     */
    public function storeUserAttributeValue($param)
    {
        global $_ARRAYLANG;

        if (empty($param['fieldName']) || empty($param['entity'])) {
            throw new \Cx\Core\Error\Model\Entity\ShinyException(
                $_ARRAYLANG['TXT_CORE_USER_NOT_FOUND']
            );
        }
        $fieldName = $param['fieldName'];
        $user = $param['entity'];
        $attrId = explode('-', $fieldName)[1];

        if (empty($attrId)) {
            throw new \Cx\Core\Error\Model\Entity\ShinyException(
                $_ARRAYLANG['TXT_CORE_USER_ATTRIBUTE_NOT_FOUND']
            );
        }

        $em = $this->cx->getDb()->getEntityManager();
        $attr = $em->getRepository(
            'Cx\Core\User\Model\Entity\UserAttribute'
        )->findOneBy(array('id' => $attrId));
        $attrValue = $em->getRepository(
            'Cx\Core\User\Model\Entity\UserAttributeValue'
        )->findOneBy(
            array(
                'userId' => $user->getId(),
                'attributeId' => $attrId
            )
        );

        if (empty($attrValue)) {
            $attrValue = new \Cx\Core\User\Model\Entity\UserAttributeValue();
            $attrValue->setUserId($user->getId());
            $attrValue->setUser($user);
            $attrValue->setAttributeId($attrId);
            $attrValue->setUserAttribute($attr);
            $attrValue->setHistory(0);
        }
        $attrValue->setValue($param['postedValue']);
        $em->persist($attrValue);
        $user->addUserAttributeValue($attrValue);
    }

    /**
     * Get a custom password field to hide the password and disable
     * auto-complete
     *
     * @param $params array params for callback
     * @return \Cx\Core\Html\Model\Entity\HtmlElement password field
     */
    public function getPasswordField($params)
    {
        global $_ARRAYLANG, $_CONFIG;

        $name = $params['name'];

        $wrapper = new \Cx\Core\Html\Model\Entity\HtmlElement('div');
        $password = new \Cx\Core\Html\Model\Entity\DataElement($name);
        $password->setAttributes(
            array(
                'type' => 'text',
                'class' => 'access-pw-noauto form-control',
                'id' => 'form-0-' . $name
            )
        );

        $star = new \Cx\Core\Html\Model\Entity\HtmlElement('font');
        $starText = new \Cx\Core\Html\Model\Entity\TextElement('&nbsp;*&nbsp;');
        $star->addChild($starText);
        $star->setAttribute('color', 'red');

        $status = new \Cx\Core\Html\Model\Entity\HtmlElement('span');
        $status->setAttribute('id', 'password-complexity');

        $wrapper->addChildren(
            array($password, $star, $status)
        );

        // Set JavaScript Variables
        $cxJs = \ContrexxJavascript::getInstance();
        $scope = 'user-password';
        $cxJs->setVariable(
            'TXT_CORE_USER_PASSWORD_TOO_SHORT',
            $_ARRAYLANG['TXT_CORE_USER_PASSWORD_TOO_SHORT'],
            $scope
        );
        $cxJs->setVariable(
            'TXT_CORE_USER_PASSWORD_INVALID',
            $_ARRAYLANG['TXT_CORE_USER_PASSWORD_INVALID'],
            $scope
        );
        $cxJs->setVariable(
            'TXT_CORE_USER_PASSWORD_WEAK',
            $_ARRAYLANG['TXT_CORE_USER_PASSWORD_WEAK'],
            $scope
        );
        $cxJs->setVariable(
            'TXT_CORE_USER_PASSWORD_GOOD',
            $_ARRAYLANG['TXT_CORE_USER_PASSWORD_GOOD'],
            $scope
        );
        $cxJs->setVariable(
            'TXT_CORE_USER_PASSWORD_STRONG',
            $_ARRAYLANG['TXT_CORE_USER_PASSWORD_STRONG'],
            $scope
        );
        $cxJs->setVariable(
            'CORE_USER_PASSWORT_COMPLEXITY',
            isset($_CONFIG['passwordComplexity'])
                ? $_CONFIG['passwordComplexity'] : 'off',
            $scope
        );

        return $wrapper;
    }

    /**
     * Get the appropriate role icon to display the roles graphically
     *
     * @param $params array params for table->parse callback
     * @return \Cx\Core\Html\Model\Entity\HtmlElement image with role icon
     */
    public function getRoleIcon($params)
    {
        global $_ARRAYLANG;

        if (empty($params['data'])) {
            $source = $this->cx->getCodeBaseCoreWebPath()
                . '/Core/View/Media/icons/no_admin.png';
            $title = $_ARRAYLANG['TXT_CORE_USER_NO_ADMINISTRATOR'];
        } else {
            $source = $this->cx->getCodeBaseCoreWebPath()
                . '/Core/View/Media/icons/admin.png';
            $title = $_ARRAYLANG['TXT_CORE_USER_ADMINISTRATOR'];
        }

        $img = new \Cx\Core\Html\Model\Entity\HtmlElement('img');
        $img->setAttributes(
            array(
                'title' => $title,
                'src' => $source,
                'class' => 'user-is-admin'
            )
        );

        return $img;
    }

    public function getAttributeValues($par)
    {
        // Todo: Übernehmen der ValueCallback Funktion
    }

    /**
     * Custom filter callback function to filter the users by user groups and
     * account type
     *
     * @param $params array contains all params for filter callback
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function filterCallback($params)
    {
        $qb = $params['qb'];
        $crit = $params['crit'];

        $i = 1;
        foreach ($crit as $field=>$value) {
            if ($field == 'group') {
                $qb->andWhere('?'. $i .' MEMBER OF x.group');
            } else if ($field == 'accountType') {
                continue;
                //$arrCustomJoins[] = 'INNER JOIN `'.DBPREFIX.'module_crm_contacts` AS tblCrm ON tblCrm.`user_account` = tblU.`id`';
                $qb->join(
                    'Cx\Modules\Crm\Model\Entity\CrmContact',
                    'c',
                    'WITH',
                    'c.userAccount = u.id'
                );
                continue;
            } else {
                $qb->andWhere(
                    $qb->expr()->eq('x.' . $field, '?' . $i)
                );
            }

            $qb->setParameter($i, $value);
            $i++;
        }

        return $qb;
    }

    /**
     * If only newsletter lists are to be removed, the entity is not persisted
     * and as a result the storeNewsletter function is not called. To remove the
     * newsletter lists this method is called as StoreCallback. To prevent the
     * newsletter lists from being saved twice, the storeNewsletter method is
     * only called if newsletter lists are to be removed
     *
     * @param $params array contains all params for store callback
     * @throws \Cx\Core\Error\Model\Entity\ShinyException
     */
    public function storeOnlyNewsletterLists($params)
    {
        if (isset($params) && empty($params['postedValue'])) {
            $this->storeNewsletter($params);
        }
    }

    public function storeNewsletter($params)
    {
        global $_ARRAYLANG, $objDatabase;

        if (!isset($params) || empty($params['entity'])) {
            throw new \Cx\Core\Error\Model\Entity\ShinyException(
                $_ARRAYLANG['TXT_CORE_USER_NOT_FOUND']
            );
        }
        $user = $params['entity'];
        $values = array();
        if ($this->cx->getRequest()->hasParam('newsletter', false)) {
            $values = $this->cx->getRequest()->getParam('newsletter', false);
        }

        // Original FWUSer storeNewsletterSubscriptions
        if (count($values)) {
            foreach ($values as $key) {
                $query = sprintf(
                    'INSERT IGNORE INTO `%smodule_newsletter_access_user`
                    (
                        `accessUserId`, `newsletterCategoryID`, `code`
                    ) VALUES (
                        %s, %s, \'%s\'
                    )',
                    DBPREFIX,
                    $user->getId(),
                    intval($key),
                    \Cx\Modules\Newsletter\Controller\NewsletterLib::_emailCode()
                );
                $objDatabase->Execute($query);
            }
            $delString = implode(',', $values);
            $query = sprintf(
                'DELETE FROM `%smodule_newsletter_access_user`
                WHERE `newsletterCategoryID` NOT IN (%s)
                AND `accessUserId`=%s',
                DBPREFIX,
                $delString,
                $user->getId()
            );
        } else {
            $query = sprintf(
                'DELETE FROM `%smodule_newsletter_access_user`
                WHERE `accessUserId`=%s',
                DBPREFIX,
                $user->getId()
            );
        }

        if ($objDatabase->Execute($query) === false) {
            throw new \Cx\Core\Error\Model\Entity\ShinyException(
                $_ARRAYLANG['TXT_CORE_USER_NOT_BE_SAVED']
            );
        }
    }

    /**
     * Creates a new user group and assigns it to the user. A new category is
     * created in the DAM, which is named after the user and assigned to the
     * created user group
     *
     * @param $params array contains the user and the entity manager
     * @return bool if the category could be created
     */
    public function storeDownloadExtension($params)
    {
        global $_ARRAYLANG;

        if (!isset($params) || empty($params['entity'])) {
            return false;
        }
        $user = $params['entity'];
        $em = $params['em'];
        $objUser = \FWUser::getFWUserObject()->objUser->getUser($user->getId());
        $objDownloadLib = new \Cx\Modules\Downloads\Controller\DownloadsLibrary();
        $arrDownloadSettings = $objDownloadLib->getSettings();

        // Set associated download groups
        $groupIds = array();
        if ($objUser) {
            $groupIds = array_merge(
                $objUser->getAssociatedGroupIds(),
                array_map(
                    'trim',
                    explode(
                        ',',
                        $arrDownloadSettings['associate_user_to_groups']
                    )
                )
            );
        };
        if (!empty($groupIds) && !empty($groupIds[0])) {
            $groupRepo = $em->getRepository(
                'Cx\Core\Model\Entity\Group'
            );
            foreach ($groupRepo->findBy($groupIds) as $group) {
                $user->addGroup($group);
            }
            $em->persist($user);
        }

        $userName = $user->__toString();

        $group = new \Cx\Core\User\Model\Entity\Group();
        $group->setGroupName(
            sprintf($_ARRAYLANG['TXT_CORE_USER_CUSTOMER_TITLE'], $userName)
        );
        $group->setGroupDescription(
            sprintf($_ARRAYLANG['TXT_CORE_USER_ACCOUNT_GROUP_DESC'], $userName)
        );
        $group->setIsActive(true);
        $group->setType('frontend');
        $group->addUser($user);
        $em->persist($group);
        $em->flush();

        $arrLanguageIds = array_keys(\FWLanguage::getLanguageArray());
        $arrNames = array();
        $arrDescription = array();
        foreach ($arrLanguageIds as $langId) {
            $arrNames[$langId] = sprintf(
                $_ARRAYLANG['TXT_CORE_USER_CUSTOMER_TITLE'],
                $userName
            );
            $arrDescription[$langId] = '';
        }

        $objCategory = new \Cx\Modules\Downloads\Controller\Category();
        $objCategory->setActiveStatus(true);
        $objCategory->setVisibility(false);
        $objCategory->setNames($arrNames);
        $objCategory->setDescriptions($arrDescription);
        $objCategory->setOwner($user->getId());
        $objCategory->setDeletableByOwner(false);
        $objCategory->setModifyAccessByOwner(false);
        $objCategory->setPermissions(
            array(
                'read'  => array(
                    'protected' => true,
                    'groups'    => array($group->getGroupId())
                ),
                'add_subcategories' => array(
                    'protected' => true,
                    'groups'    => array($group->getGroupId())
                ),
                'manage_subcategories' => array(
                    'protected' => true,
                    'groups'    => array($group->getGroupId())
                ),
                'add_files' => array(
                    'protected' => true,
                    'groups'    => array($group->getGroupId())
                ),
                'manage_files' => array(
                    'protected' => true,
                    'groups'    => array($group->getGroupId())
                )
            )
        );

        if (!$objCategory->store()) {
            return false;
        }

        $damCategoryUrl = \Cx\Core\Routing\Url::fromBackend('Downloads');
        $damCategoryUrl->setParams(
            array(
                'act' => 'categories',
                'parent_id' => $objCategory->getId()
            )
        );
        $damCategoryAnchor = new \Cx\Core\Html\Model\Entity\HtmlElement('a');
        $damCategoryAnchor->setAttribute('href', $damCategoryUrl);
        $damCategoryAnchorText = new \Cx\Core\Html\Model\Entity\TextElement(
            htmlentities(
                $objCategory->getName(LANG_ID), ENT_QUOTES, CONTREXX_CHARSET
            )
        );
        $damCategoryAnchor->addChild($damCategoryAnchorText);

        $message = sprintf(
            $_ARRAYLANG['TXT_CORE_USER_NEW_DAM_CATEGORY_CREATED_TXT'],
            $user->__toString(),
            $damCategoryAnchor
        );

        \Message::add($message);
        return true;
    }
}