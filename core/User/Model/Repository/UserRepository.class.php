<?php

namespace Cx\Core\User\Model\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Register a successful login.
     *
     * @param \Cx\Core\User\Model\Entity\User $user
     * @throws \Cx\Core\Event\Controller\EventManagerException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function registerSuccessfulLogin($user)
    {
        $this->updateLastAuthTime($user);

        $cx = \Cx\Core\Core\Controller\Cx::instanciate();

        // Flush all cache attached to the current session.
        // This is required as after the sign-in, the user might have a
        // greater access level which provides access to more or different
        // content.
        $cx->getComponent('Cache')->clearUserBasedPageCache(session_id());
        $cx->getComponent('Cache')->clearUserBasedEsiCache(session_id());

        // flush access block widgets (currently signed-in users, etc.)
        $cx->getEvents()->triggerEvent(
            'clearEsiCache',
            array(
                'Widget',
                $cx->getComponent('Access')->getSessionBasedWidgetNames(),
            )
        );

        $user->setLastAuthStatus(1);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Update last auth time of user
     *
     * @param \Cx\Core\User\Model\Entity\User $user
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function updateLastAuthTime($user)
    {
        // destroy expired auth token
        if ($user->getAuthTokenTimeout() < time()) {
            $user->setAuthToken('');
            $user->setAuthTokenTimeout(0);
        }

        // update authentication time
        $user->setLastAuth(time());

        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Find users by group ids
     *
     * @param array $groupIds    group ids to filter users
     * @param array $otherFilter other filters to filter for users
     * @return array user result
     */
    public function findByGroup($groupIds, $otherFilter)
    {
        $qb = $this->createQueryBuilder('u');
        $qb->join('u.group', 'g')
           ->where($qb->expr()->in('g.groupId', ':groupIds'))
           ->setParameter('groupIds', $groupIds);

        foreach ($otherFilter as $field=>$value) {
            $qb->andWhere($qb->expr()->eq('u.' . $field, ':value' . $field))
               ->setParameter('value'. $field, $value);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Finds User entities by a set of filters with a specified pattern
     *
     * @param array $filter Set of filters for filtering users
     */
    public function findByLike($filter)
    {
        $qb = $this->createQueryBuilder('u');
        foreach ($filter as $key=>$value) {
            $qb->andWhere($qb->expr()->like('u'.$key, ':value'. $key))->setParameter('value'.$key, $value);
        }

        $qb->getQuery()->getResult();
    }

    /**
     * Search specific fields that start with a defined first letter to get the associated users
     *
     * @param string $letter initial letter
     * @param array  $fields fields to be searched
     * @return array matching users
     */
    public function searchByInitialLetter($letter, $fields)
    {
        $letter .= '%';
        return $this->search($letter, $fields, 'like');
    }

    /**
     * Search in specific fields and return matching users
     *
     * @param string $term   the search term
     * @param array  $fields fields to be searched
     * @return array matching users
     */
    public function searchByTerm($term, $fields)
    {
        return $this->search($term, $fields, 'eq');
    }

    /**
     * Search user attributes and UserAttributes for a search term and return the matching users.
     * You can specify which operation should be used to search the attributes / UserAttributes.
     *
     * @param string $searchTerm the search term
     * @param array  $fields     fields to be searched
     * @param string $operation  operation to search the attributes / UserAttributes
     * @return array matching users
     */
    protected function search($searchTerm, $fields, $operation)
    {
        $metaData = $this->getClassMetadata()->fieldNames;
        $fwAttribute = \FWUser::getFWUserObject()->objUser->objAttribute;
        $qb = $this->createQueryBuilder('u');
        $attributeIds = array();

        foreach ($fields as $field) {
            if (in_array($field, $metaData)) {
                // User
                $qb->orWhere($this->getExpression('u.'. $field, $operation));
                $qb->setParameter('valueu'.$field, $searchTerm);
            } else {

                // UserAttributeValue
                // Find attribute id from default attribute
                if ($fwAttribute->isCoreAttribute($field)) {
                    $attributeIds[] = $fwAttribute->getAttributeIdByProfileAttributeId($field);
                } else {
                    $attributeIds[] = $field;
                }
            }
        }

        if (!empty($attributeIds)) {
            $qb->join('u.userAttributeValue', 'v');
            $qb->orWhere(
                $qb->expr()->andX(
                    $this->getExpression('v.attributeId', 'in'),
                    $this->getExpression('v.value', $operation)
                )
            );
            $qb->setParameter('valuevattributeId', $attributeIds);
            $qb->setParameter('valuevvalue', $searchTerm);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Get expression by its operation
     *
     * @param string $field     field name
     * @param string $operation operation to use
     * @return \Doctrine\ORM\Query\Expr\Comparison
     */
    protected function getExpression($field, $operation = 'eq')
    {
        $qb = $this->createQueryBuilder('e');
        $valueName = preg_replace('/\./', '', 'value'.$field);
        switch ($operation) {
            case 'like':
                $expr = $qb->expr()->like($field, ':'.$valueName);
                break;
            case 'in':
                $expr = $qb->expr()->in($field, ':'.$valueName);
                break;
            default:
                $expr = $qb->expr()->eq($field, ':'.$valueName);
        }

        return $expr;
    }

    /**
     * Add a group filter to the given QueryBuilder
     *
     * @param \Doctrine\ORM\QueryBuilder &$qb     QueryBuilder instance
     * @param int|array                  $groupId Group IDs to be filtered
     */
    public function addGroupFilterToQueryBuilder(&$qb, $groupId)
    {
        if (!in_array('filterGroup', $qb->getRootAliases())) {
            $qb->leftJoin('u.group', 'filterGroup');
        }

        if (empty($groupId)) {
            $qb->andWhere(
                $qb->expr()->isNull('filterGroup.groupId')
            );
        } else if (is_array($groupId)) {
            $qb->andWhere(
                $qb->expr()->in('filterGroup.groupId', ':groupIds')
            )->setParameter('groupId', $groupId);
        } else {
            $qb->andWhere(
                $qb->expr()->eq('filterGroup.groupId', ':groupId')
            )->setParameter('groupId', $groupId);
        }
    }

    /**
     * Add a regex filter to the given QueryBuilder. For example for an letter index search
     *
     * @param \Doctrine\ORM\QueryBuilder &$qb QueryBuilder instance
     * @param string                     $regex regex to filter
     * @param string                     $field field to be filtered with alias prefix (u.username)
     */
    public function addRegexFilterToQueryBuilder(&$qb, $regex, $field)
    {
        $qb->andWhere(
            $qb->expr()->eq(
                'REGEXP('.$field.', \''.$regex.'\')',
                1
            )
        );
    }

    /**
     * Add a regex filter on attributes to the given QueryBuilder.
     *
     * @param \Doctrine\ORM\QueryBuilder &$qb QueryBuilder instance
     * @param string                     $regex regex to filter
     * @param string                     $field field to be filtered (title | 1)
     */
    public function addAttributeRegexFilterToQueryBuilder(&$qb, $regex, $field)
    {
        $objAttr = \FWUser::getFWUserObject()->objUser->objAttribute;

        if ($objAttr->isCoreAttribute($field)) {
            $field = $objAttr->getAttributeIdByProfileAttributeId($field);
        }

        $qb->join('u.userAttributeValue', 'v'.$field);

        $qb->andWhere($qb->expr()->eq('v'.$field.'.attributeId', ':attributeId'.$field));
        $qb->andWhere($qb->expr()->eq('REGEXP(v'.$field.'.value, \''.$regex.'\')', 1));
        $qb->setParameter('attributeId'.$field, $field);
    }

    /**
     * Add an order to the given QueryBuilder
     *
     * @param \Doctrine\ORM\QueryBuilder &$qb QueryBuilder instance
     * @param string                     $field field to be filtered
     * @param string                     $direction asc or desc
     */
    public function addOrderToQueryBuilder(&$qb, $field, $direction)
    {
        $objAttr = \FWUser::getFWUserObject()->objUser->objAttribute;

        if ($objAttr->isCoreAttribute($field)) {
            $field = $objAttr->getAttributeIdByProfileAttributeId($field);
        }

        if (is_int($field)) {
            // Is UserAttributeValue
            if (!in_array('orderAttributeValue', $qb->getAllAliases())) {
                $qb->join('u.userAttributeValue', 'orderAttributeValue');
            }
        } else {
            // Is attribute of an user
            $qb->addOrderBy('u.' . $field, $direction);
        }
    }
}