<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.8
 */

namespace pavlinter\adm\controllers;

use pavlinter\adm\Adm;
use pavlinter\adm\filters\AccessControl;
use Yii;
use pavlinter\adm\models\User;
use yii\base\DynamicModel;
use yii\rbac\Item;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['AdmRoot'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['Adm-User'],
                        'actions' => ['update'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Adm::getInstance()->manager->createUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Adm::getInstance()->manager->createUser();
        $model->setScenario('adm-insert');

        $dynamicModel = DynamicModel::validateData(['password', 'password2', 'assignment'], [
            [['password', 'password2'], 'required'],
            [['password', 'password2'], 'string', 'min' => 6],
            ['password2', 'compare', 'compareAttribute' => 'password'],
            ['assignment', 'exist', 'targetClass' => Adm::getInstance()->manager->authItemClass , 'targetAttribute' => 'name', 'filter' => ['type' => Item::TYPE_ROLE]],
        ]);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $dynamicModel->load($post)) {
            if ($model->validate() && $dynamicModel->validate()) {
                $model->setPassword($dynamicModel->password);
                if ($model->save(false)) {
                    if (!empty($dynamicModel->assignment)) {
                        $modelAssignment = Adm::getInstance()->manager->createAuthAssignment();
                        $modelAssignment->item_name = $dynamicModel->assignment;
                        $modelAssignment->user_id = (string)$model->id;
                        if ($modelAssignment->save()) {
                            Yii::$app->getSession()->setFlash('success', Adm::t('','Data successfully inserted!'));
                            return Adm::redirect(['update', 'id' => $model->id]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('success', Adm::t('','Data successfully inserted!'));
                        return Adm::redirect(['update', 'id' => $model->id]);
                    }
                }
            }
        }

        $authItems = Adm::getInstance()->manager->createAuthItemQuery('find')->select(['name'])->where(['type' => Item::TYPE_ROLE])->all();

        return $this->render('create', [
            'model' => $model,
            'dynamicModel' => $dynamicModel,
            'authItems' => $authItems,
        ]);
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param null $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id = null)
    {
        if ($id === null) {
            $id = Adm::getInstance()->user->getId();
        }
        /* @var $model \pavlinter\adm\models\User */
        $model = $this->findModel($id);

        if (Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {
            $model->setScenario('adm-updateOwn');
        } elseif (Adm::getInstance()->user->can('AdmRoot')) {
            $model->setScenario('adm-update');
        } else {
            throw new ForbiddenHttpException('Access denied');
        }

        $dynamicModel = DynamicModel::validateData(['password', 'password2'], [
            [['password', 'password2'], 'string', 'min' => 6],
            ['password2', 'compare', 'compareAttribute' => 'password'],
        ]);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $dynamicModel->load($post)) {
            if ($model->validate() && $dynamicModel->validate()) {
                if (!empty($dynamicModel->password)) {
                    $model->setPassword($dynamicModel->password);
                }
                $model->save(false);
                if (Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {
                    Yii::$app->getSession()->setFlash('success', Adm::t('','Data successfully changed!'));
                    return $this->refresh();
                } else {
                    Yii::$app->getSession()->setFlash('success', Adm::t('','Data successfully changed!'));
                    return Adm::redirect(['update', 'id' => $model->id]);
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'dynamicModel' => $dynamicModel,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Adm::getInstance()->user->getId() != $id) {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('success', Adm::t('','Data successfully removed!'));
        }
        return Adm::redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Adm::getInstance()->manager->createUserQuery('findOne', $id);

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
