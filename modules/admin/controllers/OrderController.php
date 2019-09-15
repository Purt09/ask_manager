<?php

namespace admin\controllers;

use Yii;
use app\models\UserInfo;
use app\models\Order;
use app\models\OrderProduct;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Mailer;
use app\models\Product;
use app\models\ProductSearch;


/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Order();
        $modelUI = UserInfo::findOne($id);

        //if ($model->load(Yii::$app->request->post())) {
        if ($id) {

            $model->created_at = date('Y-m-d H:i:s', time());
            $model->user_info_id = $id;
            if (empty($model->delivery_id)) {
                $model->delivery_id = 1;
            }
            if($modelUI->user_id > 0){
                $model->user_id = $modelUI->user_id;
            }
            if($model->save()){
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        /*return $this->render('create', [
            'model' => $model,
        ]);*/
        
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $orderProducts = $model->getOrderProducts()->all();

        $post = Yii::$app->request->post();

        $error = '';
        $messege = '';
        if ($model->load(Yii::$app->request->post())) {
            $date = date_create($model->created_at);
            $model->created_at = date_format($date, 'Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s', time());
            if (empty($model->delivery_id)) {
                $model->delivery_id = 1;
            }
            $price = 0;
            if(!empty($orderProducts)){
                foreach($orderProducts as $orderProduct){
                    $price += $orderProduct->count*$orderProduct->price;
                }
            }
            if(!empty($model->delivery_price)){
                $price += $model->delivery_price;
            }
            if ($model->price != $price){
                $model->price = $price;
            }
            
            $save = $model->save();


            if($save && empty($post['save_order']) && empty($post['save_and_end_email'])){
                return $this->redirect(['view', 'id' => $model->id]);
            } 

        }
//                    var_dump($orderProduct);
        
        if (!empty($post['save_order']) && $post['save_order'] == 1) {
            if ($save) {
                $messege .= "Информация заказа сохранена.<br>";
                
            } else {
                $error .= "Информация заказа не сохранена.<br>";
            }
            

            if (!empty($messege)) {
                echo '<div class="text-success">'.$messege.'</div>';
            }
            if (!empty($error)) {
                echo '<div class="text-danger">'.$error.'</div>';
            }   
            echo '<br><div class="text-center"><a class="btn btn-primary" href="/admin/order/view/'.$model->id.'">'.Yii::t('app', 'Go to view order').'</a></div>';

        }
        if (!empty($post['save_and_end_email']) && $post['save_and_end_email'] == 1) {
            if ($save) {
                // $messege .= "Информация заказа сохранена.<br>";
                // echo '<div class="text-danger">Заказ сохранен</div>';
                
                return $this->redirect(['see-send-email', 'id' => $model->id]);
                
            } else {

                echo "
                <script type=\"text/javascript\">
                    $('#modal_save_and_end_email').modal('show').find('.modal-body').html('<div class=\"text-danger\">Заказ не сохранен</div>');
                </script>
                ";
            }

            // $messege .= $this->actionSendMailOrder($id);
            

            // if (!empty($messege)) {
            //     echo '<div class="text-success">'.$messege.'</div>';
            // }
            // if (!empty($error)) {
            //     echo '<div class="text-danger">'.$error.'</div>';
            // }    
            // echo '<br><div class="text-center"><a class="btn btn-primary" href="/admin/order/view/'.$model->id.'">'.Yii::t('app', 'Go to view order').'</a></div>';

        } 
        if (empty($post['save_order']) && empty($post['save_and_end_email'])) {
            $date = date_create($model->created_at);
            $model->created_at = date_format($date, 'd-m-Y H:i:s');

            return $this->render('update', [
                'model' => $model,
                'orderProducts' => $orderProducts,
            ]);
        }
            
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Не такого заказа.');
        }
    }

    public function actionProductsList($order_id)
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $messege = '';
        $error = '';
            // echo '<pre>';
            // var_dump($order_id);
            // echo '</pre>';
        $post = Yii::$app->request->post();

        $OrderProductIn = OrderProduct::find()->where(['order_id' => $order_id])->all();
        if (!empty($OrderProductIn)) {
            $cach = [];
            foreach ($OrderProductIn as $key => $value) {
                $cach[$value->product_id] = $value;
            }
            $OrderProductIn = $cach;
            unset($cach);
        }


        if( Yii::$app->request->isAjax && Yii::$app->request->isPost 
            && !empty($post['act']) && $post['act'] == 'AddProducts'
            && !empty($post['ProductCheckbox']) 
            && !empty($post['ProductId']) ){

            // echo '<pre>';
            // var_dump(Yii::$app->request->post());
            // echo '</pre>';

            if (!empty($post['ProductCheckbox'])) {
                $cach = [];
                foreach ($post['ProductCheckbox'] as $key => $value) {
                    $cach[$value] = $value;
                }
                $post['ProductCheckbox'] = $cach;
                unset($cach);
            }


            // foreach ($OrderProductIn as $key => $value) {
            //     echo '<pre>';
            //     var_dump($value->product_id);
            //     echo '</pre>';
            // }
            $OrderProductAdd = '';
        // echo '<pre>';
        // var_dump($post);
        // echo '</pre>';

            foreach ($post['ProductId'] as $key => $id) {

                if (empty($post['ProductCheckbox'][$id])) continue;

                $count = $post['ProductCount'][$key];
                $price = $post['ProductPrice'][$key];
                
                $Product = Product::findOne($id);
                if ( !empty($Product) && !empty($count) && $count > 0 && !empty($price) && $price > 0) {
                    // echo '<pre>';
                    // var_dump($Product->id);
                    // echo '</pre>';
                    // echo '<pre>';
                    // var_dump($Product->id);
                    // echo '</pre>';
                    // echo '<pre>';
                    // var_dump($OrderProductIn[$Product->product_id]);
                    // echo '</pre>';

                    if (!empty($OrderProductIn[$Product->id])) {
                        $OrderProduct = $OrderProductIn[$Product->id];
                    } else {
                        $OrderProduct = new OrderProduct();
                    }
                    // echo '<pre>';
                    // var_dump($Product->id);
                    // echo '</pre>';
                    if (!empty($OrderProduct->count)) {
                        $OrderProduct->count += $count;
                    } else {
                        $OrderProduct->count = $count;
                    }
                    
                    $OrderProduct->price = $price;
                    $OrderProduct->order_id = $order_id;
                    $OrderProduct->product_id = $Product->id;
                    if ($OrderProduct->save()) {
                        $OrderProductAdd .= 'Добавлено: <b>"'.$Product->name.'" '.$price.' руб. '.$count.' шт.</b><br>';
                    };
                }

                
            }

            if (!empty($OrderProductAdd)) {
                $messege .= $OrderProductAdd;
                $order = Order::find()->where(['id' => $order_id])->one();
                if(!empty($order)){
                    echo "<div class=\"cach-view-odrer-products-list\" style=\"display:none;\">";
                    echo $this->renderPartial('_view-odrer-products-list', [
                        'model' => $order,
                    ]);
                    echo "</div>";
                    echo "
                        <script type=\"text/javascript\">
                        $('body').find('.view-odrer-products-list').html($('body').find('#modal-products-list .cach-view-odrer-products-list').html());
                        order_calc();
                        </script>
                    ";
                }
              
            }

        }

        if( !empty(Yii::$app->request->post('act')) 
            && Yii::$app->request->post('act') == 'AddProducts' 
            && empty(Yii::$app->request->post('ProductCheckbox'))){
            $error .= 'Не выбраны товары<br>';
        }



        return $this->renderPartial('products-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'messege' => $messege,
            'error' => $error,
        ]);
    }

    public function actionDeleteProduct($id)
    {
        if (($model = OrderProduct::findOne($id)) !== null) {
            $delete = $model->delete();
                if ($delete) {
                $js = "
                    <script type=\"text/javascript\">
                    $('body').find('.table-order-products .tr_product".$id."').remove();
                    order_calc();
                    </script>
                ";
                return $js;
            }

        }
    }

    public function actionSaveOrderItogoPrice()
    {
        $post = Yii::$app->request->post();
        $itogo = 0;
        // echo '<pre>';
        // var_dump($post);
        // echo '</pre>';
        if ( !empty($post['order_id']) && $post['order_id'] > 0 && ($model = Order::findOne($post['order_id'])) !== null) {

            foreach ($model->orderProducts as $key => $value) {
                if (!empty($post['OrderProduct'][$value->id])) {
                    $value->price = 1*$post['OrderProduct'][$value->id]['price'];
                    $value->count = 1*$post['OrderProduct'][$value->id]['count'];
                    $itogo += 1*$post['OrderProduct'][$value->id]['price']*$post['OrderProduct'][$value->id]['count'];
                    $value->save();
                }
            }

            $model->delivery_price = $post['delivery_price'];
            $itogo += $model->delivery_price;

            $model->price = $itogo;

            if($model->save()){
                echo "
                    <script type=\"text/javascript\">
                    $('body').find('.order_itogo').html(".$model->price.");
                    </script>
                ";
            }
        }
    }

    public function actionAddProducts()
    {
        // $searchModel = new ProductSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->renderPartial('add-products', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

        // $model = new OrderProduct();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // } else {
        //     return $this->render('create', [
        //         'model' => $model,
        //     ]);
        // }

    }

    

    // public function actionSendMail($id)
    // {
    //     if (($model = $this->findModel($id)) !== null) {
    //         $render = $this->renderSendMailView($model);

    //         //echo Yii::$app->charset;

    //         $headers  = "Content-type: text/html; charset=".Yii::$app->charset." \r\n";
    //         $headers .= "From: Birthday Reminder <".yii::$app->params['adminEmail'].">\r\n";
    //         $headers .= "Bcc: ".yii::$app->params['adminEmail']."\r\n";
    //         $subject ='Заказ '.$model->id;
    //         //$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($subject, "w","k")).'?=';

    //         $userInfoArray = unserialize($model->user_info_array);

    //         $toEmail = $userInfoArray['surname'].' '.$userInfoArray['name'].' '.$userInfoArray['patronymic'];

    //         if (!empty($model->user->email)) {
    //             $toEmail .= ' &lt;'.$model->user->email.'&gt;';
    //         } else {
    //             $toEmail .= ' &lt;'.$userInfoArray['email'].'&gt;';
    //         }

    //         $send = mail($toEmail, $subject , $render, $headers);


    //         if(!empty($send)){
    //             echo 'Отправлено';
    //         } else {
    //             echo 'Не отправлено';
    //         }

    //     }

    // }

    public function actionSeeSendEmail($id)
    {
        
        if (($model = $this->findModel($id)) !== null) {
            // return $this->renderSendMailOrderView($model);

            $content = $this->renderFile($_SERVER['DOCUMENT_ROOT'] . '/mail/order.php', [
                'order' => $model,
            ]);
            $html = $this->renderFile($_SERVER['DOCUMENT_ROOT'] . '/mail/layouts/html.php', [
                'content' => $content,
            ]);
            return $this->render('see-send-email', [
                'html' => $html,
                'model' => $model,
            ]);
        }
    }

    public function actionSendEmail($id)
    {
        
        if (($model = $this->findModel($id)) === null) {
            $error .= "Заказа #".$id." нету!";
        } else {
            $messege .= $this->actionSendMailOrder($id);
        }

        if (!empty($messege)) {
            echo '<div class="text-success">'.$messege.'</div>';
        }
        if (!empty($error)) {
            echo '<div class="text-danger">'.$error.'</div>';
        }    

        if ($model !== null) {
            echo '<br><div class="text-center"><a class="btn btn-primary" href="/admin/order/view/'.$model->id.'">'.Yii::t('app', 'Go to view order').'</a></div>';

        }
    }


    public function actionSendMailOrder($id)
    {
        $mailer = Mailer::sendOrderMessage($this->findModel($id));
        return $mailer;
    }

    public function actionSeeMailOrderView($id)
    {
        if (($model = $this->findModel($id)) !== null) {
            return $this->renderSendMailOrderView($model);
        }
    }

    protected function renderSendMailOrderView($order)
    {
        $content = $this->renderPartial('send-mail-order-view', [
            'order' => $order,
        ]);
        return $this->renderFile($_SERVER['DOCUMENT_ROOT'] . '/mail/layouts/html.php', [
            'content' => $content
        ]);
    }

    public function actionSeeMailNewOrderView($id)
    {
        if (($model = $this->findModel($id)) !== null) {
            return $this->renderSendNewMailNewOrderView($model);
        }
    }
    protected function renderSendNewMailNewOrderView($order)
    {
        $content = $this->renderPartial('send-mail-new-order-view', [
            'order' => $order,
        ]);
        return $this->renderFile($_SERVER['DOCUMENT_ROOT'] . '/mail/layouts/html.php', [
            'content' => $content
        ]);
    }

    public function actionSeeMailNewOrderToManagerView($id)
    {
        if (($model = $this->findModel($id)) !== null) {
            return $this->renderSendNewMailNewOrderToManagerView($model);
        }
    }
    protected function renderSendNewMailNewOrderToManagerView($order)
    {
        $content = $this->renderPartial('send-mail-new-order-to-manager-view', [
            'order' => $order,
        ]);
        return $this->renderFile($_SERVER['DOCUMENT_ROOT'] . '/mail/layouts/html.php', [
            'content' => $content
        ]);
    }



    // public function actionSendTest()
    // {
    //     function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '')
    //        { 
    //           $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
    //           $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

    //           $headers = "From: $from_user <$from_email>\r\n". 
    //                    "MIME-Version: 1.0" . "\r\n" . 
    //                    "Content-type: text/html; charset=UTF-8" . "\r\n"; 

    //          return mail($to, $subject, $message, $headers); 
    //        }
    //     if(mail_utf8('Crazi-wolf@mail.ru','admin','knvdesigmy@gmail.com','заголовок','текст')){
    //         return 'да';
    //     } else {
    //         return 'нет';
    //     } 

    // }

}
