<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Club;
use frontend\models\ClubSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ClubController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ClubSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->view->title = 'Clubs';
        $this->view->params['breadcrumbs'] = [
            'Clubs',
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $this->view->title = $model->name;
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Clubs', 'url' => ['index']],
            $model->name,
        ];

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Club();

        $this->view->title = 'Create Club';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Clubs', 'url' => ['index']],
            'Create Club',
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->view->title = 'Update Club';
        $this->view->params['breadcrumbs'] = [
            ['label' => 'Clubs', 'url' => ['index']],
            'Update Club',
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Club::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}