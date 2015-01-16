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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SourceMessageController implements the CRUD actions for SourceMessage model.
 */
class SourceMessageController extends Controller
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
                        'roles' => ['Adm-Transl'],
                        'actions' => ['index', 'create', 'fulledit', 'delete' , 'dot-translation'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['Adm-Transl:Html'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'dot-translation' => [
                'class' => 'pavlinter\translation\TranslationAction',
                'adminLink' => ['/'.Adm::getInstance()->id.'/source-message/fulledit'],
                'htmlEncode' => !Adm::getInstance()->user->can('Adm-Transl:Html'),
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionFulledit()
    {
        $request = Yii::$app->getRequest();
        $category = $request->post('category');
        $message  = rawurldecode($request->post('message'));

        $model = Adm::getInstance()->manager->createSourceMessageQuery('find')
            ->select('id')
            ->where(['category' => $category, 'message' => $message])
            ->one();

        if (!$model) {
            $model = Adm::getInstance()->manager->createSourceMessage();
            $model->category = $category;
            $model->message  = $message;
            if (!$model->save()) {
                if (($redirect = Yii::$app->request->post('redirect'))) {
                    return $this->redirect($redirect);
                }
                return $this->redirect(['create']);
            }

        }
        if (($redirect = Yii::$app->request->post('redirect'))) {
            return $this->redirect($redirect);
        }
        return $this->redirect(['update', 'id' => $model->id]);
    }
    /**
     * Lists all SourceMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = Adm::getInstance()->manager->createSourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Creates a new SourceMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($category = '', $message = '')
    {
        $model = Adm::getInstance()->manager->createSourceMessage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return Adm::redirect(['update', 'id' => $model->id]);
        } else {

            if ($category != '') {
                $model->category = $category;
            }
            if ($message != '') {
                $model->message = $message;
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SourceMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadLangs(Yii::$app->request->post())) {
            if ($model->saveTranslations()) {
                return Adm::redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing SourceMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return Adm::redirect(['index']);
    }

    /**
     * Finds the SourceMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return \pavlinter\adm\models\SourceMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Adm::getInstance()->manager->createSourceMessageQuery('findOne', $id);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
