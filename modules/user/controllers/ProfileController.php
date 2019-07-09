<?php

namespace app\modules\user\controllers;

use app\modules\user\forms\PasswordChangeForm;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use app\modules\user\forms\SearchForm;

class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        return $this->render('index', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->identity->id);
        $model->scenario = User::SCENARIO_PROFILE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangePassword()
    {
        $user = $this->findModel(Yii::$app->user->identity->id);
        $model = new PasswordChangeForm($user);
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('passwordChange', [
                'model' => $model,
            ]);
        }
    }

    public function actionSearch()
    {
        $model = new SearchForm();


        if($query = Yii::$app->request->post('SearchForm')) {
            $users = $model->searchUser($query);
        } else {
            $users = [];
        }

        return $this->render('search', [
            'model' => $model,
            'users' => $users,
        ]);

    }

    /**
     * @return User the loaded model
     */
    private function findModel($id)
    {
        return User::findOne($id);
    }
}