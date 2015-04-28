<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.3
 */

namespace pavlinter\adm;

use Yii;

/**
 * ModelManager is used in order to create models.
 *
 * @method \pavlinter\adm\models\User staticUser
 * @method \pavlinter\adm\models\User createUser
 * @method \pavlinter\adm\models\User createUserQuery
 *
 * @method \pavlinter\adm\models\UserSearch createUserSearch
 *
 * @method \pavlinter\adm\models\LoginForm staticLoginForm
 * @method \pavlinter\adm\models\LoginForm createLoginForm
 *
 * @method \pavlinter\adm\models\AuthItem staticAuthItem
 * @method \pavlinter\adm\models\AuthItem createAuthItem
 * @method \pavlinter\adm\models\AuthItem createAuthItemQuery
 *
 * @method \pavlinter\adm\models\AuthItemSearch createAuthItemSearch
 * @method \pavlinter\adm\models\AuthItemSearch createAuthItemSearchQuery
 *
 * @method \pavlinter\adm\models\AuthRule staticAuthRule
 * @method \pavlinter\adm\models\AuthRule createAuthRule
 * @method \pavlinter\adm\models\AuthRule createAuthRuleQuery
 *
 * @method \pavlinter\adm\models\AuthRuleSearch createAuthRuleSearch
 * @method \pavlinter\adm\models\AuthRuleSearch createAuthRuleSearchQuery
 *
 * @method \pavlinter\adm\models\AuthAssignment staticAuthAssignment
 * @method \pavlinter\adm\models\AuthAssignment createAuthAssignment
 * @method \pavlinter\adm\models\AuthAssignment createAuthAssignmentQuery
 *
 * @method \pavlinter\adm\models\AuthAssignmentSearch createAuthAssignmentSearch
 * @method \pavlinter\adm\models\AuthAssignmentSearch createAuthAssignmentSearchQuery
 *
 * @method \pavlinter\adm\models\AuthItemChild staticAuthItemChild
 * @method \pavlinter\adm\models\AuthItemChild createAuthItemChild
 * @method \pavlinter\adm\models\AuthItemChild createAuthItemChildQuery
 *
 * @method \pavlinter\adm\models\AuthItemChildSearch createAuthItemChildSearch
 * @method \pavlinter\adm\models\AuthItemChildSearch createAuthItemChildSearchQuery
 *
 * @method \pavlinter\adm\models\Language staticLanguage
 * @method \pavlinter\adm\models\Language createLanguage
 * @method \pavlinter\adm\models\Language createLanguageQuery
 *
 * @method \pavlinter\adm\models\LanguageSearch createLanguageSearch
 *
 * @method \pavlinter\adm\models\SourceMessage staticSourceMessage
 * @method \pavlinter\adm\models\SourceMessage createSourceMessage
 * @method \pavlinter\adm\models\SourceMessage createSourceMessageQuery
 *
 * @method \pavlinter\adm\models\SourceMessageSearch createSourceMessageSearch
 *
 * @method \pavlinter\adm\models\Message staticMessage
 * @method \pavlinter\adm\models\Message createMessage
 * @method \pavlinter\adm\models\Message createMessageQuery
 */
class ModelManager extends Manager
{
    /**
     * @var string|\pavlinter\adm\models\LoginForm
     */
    public $loginFormClass = 'pavlinter\adm\models\LoginForm';
    /**
     * @var string|\pavlinter\adm\models\User
     */
    public $userClass = 'pavlinter\adm\models\User';
    /**
     * @var string|\pavlinter\adm\models\UserSearch
     */
    public $userSearchClass = 'pavlinter\adm\models\UserSearch';
    /**
     * @var string|\pavlinter\adm\models\AuthItem
     */
    public $authItemClass = 'pavlinter\adm\models\AuthItem';
    /**
     * @var string|\pavlinter\adm\models\AuthItemSearch
     */
    public $authItemSearchClass = 'pavlinter\adm\models\AuthItemSearch';
    /**
     * @var string|\pavlinter\adm\models\AuthRule
     */
    public $authRuleClass = 'pavlinter\adm\models\AuthRule';
    /**
     * @var string|\pavlinter\adm\models\AuthRuleSearch
     */
    public $authRuleSearchClass = 'pavlinter\adm\models\AuthRuleSearch';
    /**
     * @var string|\pavlinter\adm\models\AuthItemChild
     */
    public $authItemChildClass = 'pavlinter\adm\models\AuthItemChild';
    /**
     * @var string|\pavlinter\adm\models\AuthItemChildSearch
     */
    public $authItemChildSearchClass = 'pavlinter\adm\models\AuthItemChildSearch';
    /**
     * @var string|\pavlinter\adm\models\AuthAssignment
     */
    public $authAssignmentClass = 'pavlinter\adm\models\AuthAssignment';
    /**
     * @var string|\pavlinter\adm\models\AuthAssignmentSearch
     */
    public $authAssignmentSearchClass = 'pavlinter\adm\models\AuthAssignmentSearch';
    /**
     * @var string|\pavlinter\adm\models\Language
     */
    public $languageClass = 'pavlinter\adm\models\Language';
    /**
     * @var string|\pavlinter\adm\models\LanguageSearch
     */
    public $languageSearchClass = 'pavlinter\adm\models\LanguageSearch';
    /**
     * @var string|\pavlinter\adm\models\SourceMessage
     */
    public $sourceMessageClass = 'pavlinter\adm\models\SourceMessage';
    /**
     * @var string|\pavlinter\adm\models\SourceMessageSearch
     */
    public $sourceMessageSearchClass = 'pavlinter\adm\models\SourceMessageSearch';
    /**
     * @var string|\pavlinter\adm\models\Message
     */
    public $messageClass = 'pavlinter\adm\models\Message';

}