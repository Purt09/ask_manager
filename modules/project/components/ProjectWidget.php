<?php
namespace app\modules\project\components;

use yii\base\Widget;
use app\modules\project\models\Project;
use app\modules\task\models\Task;

class ProjectWidget extends Widget
{
    /**
     * @var string шаблон проекта, его вид или часть такого
     */
    public $tpl;
    /**
     * @var array Все данные из бд, с проекта
     */
    public $data;
    /**
     * @var array Данные с массива но в виде дерева
     */
    public $tree;
    /**
     * @var string
     */
    public $projectHtml;
    /**
     * @var integer id проекта для которого строим виджет
     */
    public $id;

    /**
     * @var array Задачи проекта
     */
    public $tasks;

    /**
     *
     */
    public function init()
    {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'project';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
        $model = new Task();
        $this->data = Project::find()->where(['id' => $this->id])->orWhere(['parent_id' => $this->id])->indexBy('id')->asArray()->all();
        $this->tasks = array_merge($model->getTasksByProject($this->id), $model->getTasksByProject($this->id,2));
        $this->tree = $this->getTree();



        /* Меняет структура дерева для вывода подкатегорий */
        if (!isset($this->tree[$this->id])) {
            $this->tree = array_shift(array_pop($this->tree));
        }

        /* Добаавляет в виджет также заддачи подкатегорий */
        foreach ($this->tree as  $s){
            if(isset( $s['childs']) && is_array( $s['childs'])) foreach ( $s['childs'] as $child) {
                $this->tasks = array_merge($this->tasks, $model->getTasksByProject($child['id'],1));
            }
        }

        $this->projectHtml = $this->getProjectHtml($this->tree);
        return $this->projectHtml;
    }

    /**
     * Строит дерево из данных
     *
     * @return array
     */
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

        $this->tpl = 'bottom.php';
        $str .= $this->catToTemplate($project);

        return $str;
    }

    protected function catToTemplate($project){
        ob_start();
        include __DIR__ . '/project_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}