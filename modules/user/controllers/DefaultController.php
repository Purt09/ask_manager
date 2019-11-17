<?php
namespace app\modules\user\controllers;
use app\modules\user\forms\EmailConfirmForm;
use app\modules\user\forms\LoginForm;
use app\modules\user\forms\PasswordResetRequestForm;
use app\modules\user\forms\PasswordResetForm;
use app\modules\user\forms\SignupForm;
use app\modules\user\models\User;
use app\modules\user\models\UserFriend;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;
use app\modules\user\models\UserRequestFriend;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->redirect(['profile/index'], 301);
    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->getSession()->setFlash('success', 'Подтвердите ваш электронный адрес.');
                return $this->goHome();
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionConfirmEmail($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка подтверждения Email.');
        }
        return $this->goHome();
    }
    public function actionPasswordResetRequest()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Спасибо! На ваш Email было отправлено письмо со ссылкой на восстановление пароля.');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Извините. У нас возникли проблемы с отправкой.');
            }
        }
        return $this->render('PasswordResetRequest', [
            'model' => $model,
        ]);
    }
    public function actionResetPassword($token)
    {
        try {
            $model = new PasswordResetForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Пароль успешно изменён.');
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionAddRequest($id, $redirect = 'index')
    {
        $request = new UserRequestFriend();
        $friend = new UserFriend();

        if($friend->checkFriend($id)) {
            Yii::$app->getSession()->setFlash('warning', 'Пользователь уже у вас в друзьях');
            return $this->redirect([$redirect]);
        }

        if($request->createRequest($id)) Yii::$app->getSession()->setFlash('success', 'Запрос в друзья, был отправлен пользователю');
            else    Yii::$app->getSession()->setFlash('warning', 'Вы уже отпрравляли запрос в друзья данному пользователю');

        return $this->redirect([$redirect]);
    }

    public function actionAddFriend($id, $redirect = 'index'){
        $friend = new UserFriend();

        if($friend->createFriend($id))  Yii::$app->getSession()->setFlash('success', 'Пользователь добавлен в друзья');
            else  Yii::$app->getSession()->setFlash('error', 'Произошла внутреняя ошибка при добавление в друзья');

        return $this->redirect([$redirect]);
    }

    public function actionDeleteFriend($id, $redirect = 'index'){
        $friend = new UserFriend();

        if($friend->deleteFriend($id))  Yii::$app->getSession()->setFlash('success', 'Пользователь удален из друзей');
        else  Yii::$app->getSession()->setFlash('error', 'Произошла внутреняя ошибка при удаление друга');


        return $this->redirect([$redirect, 'id' => Yii::$app->user->identity->id]);
    }

}