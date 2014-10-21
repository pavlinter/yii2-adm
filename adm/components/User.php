<?php
/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-adm
 */


namespace pavlinter\adm\components;

use Yii;
use yii\base\InvalidValueException;
use yii\web\IdentityInterface;

class User extends \yii\web\User
{
    /**
     * @var string the class name of the [[identity]] object.
     */
    public $identityClass = 'pavlinter\adm\models\User';
    /**
     * @var boolean whether to enable cookie-based login. Defaults to false.
     * Note that this property will be ignored if [[enableSession]] is false.
     */
    public $enableAutoLogin = true;
    /**
     * @var string|array the URL for login when [[loginRequired()]] is called.
     * If an array is given, [[UrlManager::createUrl()]] will be called to create the corresponding URL.
     * The first element of the array should be the route to the login action, and the rest of
     * the name-value pairs are GET parameters used to construct the login URL. For example,
     *
     * ~~~
     * ['site/login', 'ref' => 1]
     * ~~~
     *
     * If this property is null, a 403 HTTP exception will be raised when [[loginRequired()]] is called.
     */
    public $loginUrl = ['/adm/default/login'];
    /**
     * @var array the configuration of the identity cookie. This property is used only when [[enableAutoLogin]] is true.
     * @see Cookie
     */
    public $identityCookie = ['name' => '_adm_identity', 'httpOnly' => true];
    /**
     * @var string the session variable name used to store the value of [[id]].
     */
    public $idParam = '__adm_id';
    /**
     * @var string the session variable name used to store the value of expiration timestamp of the authenticated state.
     * This is used when [[authTimeout]] is set.
     */
    public $authTimeoutParam = '__adm_expire';
    /**
     * @var string the session variable name used to store the value of absolute expiration timestamp of the authenticated state.
     * This is used when [[absoluteAuthTimeout]] is set.
     */
    public $absoluteAuthTimeoutParam = '__adm_absolute_expire';
    /**
     * @var string the session variable name used to store the value of [[returnUrl]].
     */
    public $returnUrlParam = '__adm_returnUrl';

    private $_access = [];
    /**
     * Initializes the application component.
     */
    public function init()
    {
        parent::init();
    }

    private $_identity = false;

    /**
     * Returns the identity object associated with the currently logged-in user.
     * When [[enableSession]] is true, this method may attempt to read the user's authentication data
     * stored in session and reconstruct the corresponding identity object, if it has not done so before.
     * @return IdentityInterface|null the identity object associated with the currently logged-in user.
     * `null` is returned if the user is not logged in (not authenticated).
     * @see login()
     * @see logout()
     */
    public function getIdentity()
    {
        if ($this->_identity === false) {
            if ($this->enableSession) {
                $this->renewAuthStatus();
            } else {
                return null;
            }
        }

        return $this->_identity;
    }

    /**
     * Sets the user identity object.
     *
     * Note that this method does not deal with session or cookie. You should usually use [[switchIdentity()]]
     * to change the identity of the current user.
     *
     * @param IdentityInterface|null $identity the identity object associated with the currently logged user.
     * If null, it means the current user will be a guest without any associated identity.
     * @throws InvalidValueException if `$identity` object does not implement [[IdentityInterface]].
     */
    public function setIdentity($identity)
    {
        if ($identity instanceof IdentityInterface) {
            $this->_identity = $identity;
            $this->_access = [];
        } elseif ($identity === null) {
            $this->_identity = null;
        } else {
            throw new InvalidValueException('The identity object must implement IdentityInterface.');
        }
    }
    /**
     * Checks if the user can perform the operation as specified by the given permission.
     *
     * Note that you must configure "authManager" application component in order to use this method.
     * Otherwise an exception will be thrown.
     *
     * @param string $permissionName the name of the permission (e.g. "edit post") that needs access check.
     * @param array $params name-value pairs that would be passed to the rules associated
     * with the roles and permissions assigned to the user. A param with name 'user' is added to
     * this array, which holds the value of [[id]].
     * @param boolean $allowCaching whether to allow caching the result of access check.
     * When this parameter is true (default), if the access check of an operation was performed
     * before, its result will be directly returned when calling this method to check the same
     * operation. If this parameter is false, this method will always call
     * [[\yii\rbac\ManagerInterface::checkAccess()]] to obtain the up-to-date access result. Note that this
     * caching is effective only within the same request and only works when `$params = []`.
     * @return boolean whether the user can perform the operation as specified by the given permission.
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        $auth = Yii::$app->getModule('adm')->authManager;
        if ($allowCaching && empty($params) && isset($this->_access[$permissionName])) {
            return $this->_access[$permissionName];
        }
        $access = $auth->checkAccess($this->getId(), $permissionName, $params);
        if ($allowCaching && empty($params)) {
            $this->_access[$permissionName] = $access;
        }

        return $access;
    }
}
