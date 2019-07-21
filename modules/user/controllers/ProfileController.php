<?php

namespace app\modules\user\controllers;

use app\modules\user\forms\PasswordChangeForm;
use app\modules\user\models\UserFriend;
use app\modules\user\models\UserRequestFriend;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use app\modules\user\forms\SearchForm;
use yii\helpers\ArrayHelper;

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
        $request = new UserRequestFriend();
        $friend = new UserFriend();
        $user = $this->findModel($id);

        $requests = $request->getRequests(true);

        $friends = $friend->getUserFriends($id);
        $users = $user->getFriends($friends, $id);

        if(!empty($user->phone)) $user->phone = substr($user->phone, 0, -5) . '** **';

        return $this->render('index', [
            'model' => $user,
            'requests' => $requests,
            'users' => $users,
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->user->identity->id;
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_PROFILE;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index', 'id' => $id]);
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

    public function actionRequest()
    {
        $request = new UserRequestFriend();
        $user = new User();

        $requests = $request->getRequests();
        $ids = ArrayHelper::getColumn($requests, 'sender');
        $users = $user->getUsersByIds($ids);

        return $this->render('request', [
            'users' => $users,
        ]);
    }

    public function actionFriend()
    {
        $friend = new UserFriend();
        $user = new User();
        $id = Yii::$app->user->identity->id;

        $friends = $friend->getUserFriends($id);
        $users = $user->getFriends($friends, $id);


        return $this->render('friend', [
            'model' => $this->findModel($id),
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