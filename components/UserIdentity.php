<?php
namespace app\components;
use app\modules\user\models\User;

class UserIdentity extends User
{
    public static function findAuthRoleIdentity($id)
    {
        return static::findOne($id);
    }
    public static function findAuthIdsByRoleName($roleName)
    {
        return static::find()->where(['role' => $roleName])->select(['id'])->column();
    }
    public function getAuthRoleNames()
    {
        return [$this->role];
    }
    public function addAuthRoleName($roleName)
    {
        $this->updateAttributes(['role' => $this->role = $roleName]);
    }
    public function removeAuthRoleName($roleName)
    {
        $this->updateAttributes(['role' => $this->role = null]);
    }
    public function clearAuthRoleNames()
    {
        $this->updateAttributes(['role' => $this->role = null]);
    }
}