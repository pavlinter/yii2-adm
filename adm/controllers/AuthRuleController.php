<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.0
 */

namespace pavlinter\adm\controllers;

use pavlinter\adm\Adm;
use pavlinter\adm\filters\AccessControl;
use Yii;
use yii\base\DynamicModel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthRuleController implements the CRUD actions for AuthRule model.
 */
class AuthRuleController extends Controller
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
     * Lists all AuthRule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Adm::getInstance()->manager->createAuthRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AuthRule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Adm::getInstance()->manager->createAuthRule();

        $dynamicModel = new DynamicModel(['ruleNamespace']);
        $dynamicModel->addRule(['ruleNamespace'],function($attribute, $params) use($dynamicModel){
            $this->validateClass($dynamicModel, $attribute, ['extends' => \yii\rbac\Rule::className()]);
        });
        $post = Yii::$app->request->post();


        if ($model->load($post) && $dynamicModel->load($post)) {
            if ($model->validate() && $dynamicModel->validate()) {
                if (!empty($dynamicModel->ruleNamespace)) {
                    $ruleModel = new $dynamicModel->ruleNamespace;
                    $time = time();
                    $ruleModel->createdAt = $time;
                    $ruleModel->updatedAt = $time;
                    $model->data = serialize($ruleModel);
                }
                $model->save(false);
                if (($redirect = Yii::$app->request->post('redirect'))) {
                    return $this->redirect($redirect);
                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'dynamicModel' => $dynamicModel,
        ]);

    }

    /**
     * Updates an existing AuthRule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dynamicModel = new DynamicModel(['ruleNamespace']);
        $dynamicModel->addRule(['ruleNamespace'],function($attribute, $params) use($dynamicModel){
            $this->validateClass($dynamicModel, $attribute, ['extends' => \yii\rbac\Rule::className()]);
        });
        $post = Yii::$app->request->post();


        if ($model->load($post) && $dynamicModel->load($post)) {
            if ($model->validate() && $dynamicModel->validate()) {
                if (!empty($dynamicModel->ruleNamespace)) {
                    $ruleModel = new $dynamicModel->ruleNamespace;
                    $time = time();
                    $ruleModel->createdAt = $time;
                    $ruleModel->updatedAt = $time;
                    $model->data = serialize($ruleModel);
                }
                $model->save(false);
                if (($redirect = Yii::$app->request->post('redirect'))) {
                    return $this->redirect($redirect);
                }
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'dynamicModel' => $dynamicModel,
        ]);
    }

    /**
     * Deletes an existing AuthRule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (($redirect = Yii::$app->request->post('redirect'))) {
            return $this->redirect($redirect);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthRule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Adm::getInstance()->manager->createAuthRuleQuery('findOne', $id);

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * An inline validator that checks if the attribute value refers to an existing class name.
     * If the `extends` option is specified, it will also check if the class is a child class
     * of the class represented by the `extends` option.
     * @param string $attribute the attribute being validated
     * @param array $params the validation options
     */
    public function validateClass($th, $attribute, $params)
    {

        $class = $th->$attribute;

        try {
            if (class_exists($class)) {
                if (isset($params['extends'])) {
                    if (ltrim($class, '\\') !== ltrim($params['extends'], '\\') && !is_subclass_of($class, $params['extends'])) {
                        $th->addError($attribute, "'$class' must extend from {$params['extends']} or its child class.");
                    }
                }

            } else {

                $th->addError($attribute, "Class '$class' does not exist or has syntax error.");
            }
        } catch (\Exception $e) {
            $th->addError($attribute, "Class '$class' does not exist or has syntax error.");
        }
    }


}
