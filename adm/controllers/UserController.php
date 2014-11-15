<?php

namespace pavlinter\adm\controllers;

use pavlinter\adm\Adm;
use pavlinter\adm\filters\AccessControl;
use Yii;
use pavlinter\adm\models\User;
use yii\base\DynamicModel;
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

        $passwordModel = DynamicModel::validateData(['password', 'password2'], [
            [['password', 'password2'], 'required'],
            [['password', 'password2'], 'string', 'min' => 6],
            ['password2', 'compare', 'compareAttribute' => 'password'],
        ]);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $passwordModel->load($post)) {
            if ($model->validate() && $passwordModel->validate()) {
                $model->setPassword($passwordModel->password);
                $model->save(false);
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'passwordModel' => $passwordModel,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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

        $passwordModel = DynamicModel::validateData(['password', 'password2'], [
            [['password', 'password2'], 'string', 'min' => 6],
            ['password2', 'compare', 'compareAttribute' => 'password'],
        ]);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $passwordModel->load($post)) {
            if ($model->validate() && $passwordModel->validate()) {
                if (!empty($passwordModel->password)) {
                    $model->setPassword($passwordModel->password);
                }
                $model->save(false);
                if (Adm::getInstance()->user->can('Adm-UpdateOwnUser', $model)) {

                    Yii::$app->getSession()->setFlash('success', Adm::t('','Data successfully changed!'));
                    return $this->refresh();
                } else {
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'passwordModel' => $passwordModel,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
