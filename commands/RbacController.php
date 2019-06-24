<?php
namespace app\commands;

use app\modules\admin\rbac\Rbac as AdminRbac;
use yii\console\Controller;
use Yii;

class RbacController extends Controller
{
    /**
     * Generates roles
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
       $auth->removeAll();

        $adminPanel = $auth->createPermission(AdminRbac::PERMISSION_ADMIN_PANEL);
        $adminPanel->description = 'Admin panel';
        $auth->add($adminPanel);

        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPanel);

        $this->stdout('Done!' . PHP_EOL);
    }
}