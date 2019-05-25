<?php
namespace app\modules\project\components;

use yii\base\Widget;
use app\modules\project\models\Project;
use app\modules\task\models\Task;

class ProjectWidget extends Widget
{
    public $tpl;
    public $data;
    public $tree;
    public $projectHtml;
    public $id;
    public $tasks;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if ($this->tpl === null) {
            $this->tpl = 'project';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
        $model = new Project();
        $this->data = Project::find()->where(['id' => $this->id])->orWhere(['parent_id' => $this->id])->indexBy('id')->asArray()->all();
        $this->tasks = $model->getTasksByProject($this->id);
        $this->tree = $this->getTree();
        $this->projectHtml = $this->getProjectHtml($this->tree);
        return $this->projectHtml;
    }

    protected  function getTree(){
        $tree = [];
        foreach ($this->data as $id => &$node){
            if(!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    protected function getProjectHtml($tree){
        $str = '';
        foreach ($tree as $project) {
            $str .= $this->catToTemplate($project);
        }

        $this->tpl = 'task.php';
        $str .= $this->catToTemplate($this->tasks);

        return $str;
    }

    protected function catToTemplate($project){
        ob_start();
        include __DIR__ . '/project_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}