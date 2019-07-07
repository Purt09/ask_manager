<?php
namespace app\modules\project\components;

use yii\base\Widget;
use app\modules\project\models\Project;
use app\modules\task\models\Task;
use yii\helpers\ArrayHelper;

class ProjectWidget extends Widget
{
    /**
     * @var string шаблон проекта, его вид или часть такого
     */
    public $tpl;
    /**
     * @var array Все данные из бд, с проекта
     */
    public $data = [];
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

    public $project;
    /**
     * @var array Задачи проекта
     */
    public $tasks = [];

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
        $this->id = $this->project['id'];

        // формируем массив проектов, для их дальнейшего преобразования в дерево
        $this->data += [$this->project['id'] => $this->project];
        foreach ($this->project['projects'] as $child){
            $this->data += array($child['id'] => $child);
        }

        $tasks = $model->getTasks();
        foreach ($tasks as $t){
            if(($t['project_id'] == $this->id) && ($t['status'] == 1)){
                $t = ArrayHelper::toArray($t);
                $t = array(
                    $t['id'] => $t,
                );
                $this->tasks = ArrayHelper::merge($this->tasks, $t);
            }
        }
        $this->tree = $this->getTree();



        /* Меняет структура дерева для вывода подкатегорий */
        if (!isset($this->tree[$this->id])) {
            $this->tree = array_shift(array_pop($this->tree));
        }

        /* Добаавляет в виджет также заддачи подкатегорий */
        foreach ($this->tree as  $s){
            if(isset( $s['childs']) && is_array( $s['childs']))
                foreach ( $s['childs'] as $child) {
                    foreach ($tasks as $t)
                        if ($child['id'] == $t['project_id']) {
                            $t = ArrayHelper::toArray($t);
                            $t = array(
                                $t['id'] => $t,
                            );
                            $this->tasks = ArrayHelper::merge($this->tasks, $t);
                        }
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
            $str .= $this->catToTemplate($project, $this->tasks);
        }

        return $str;
    }

    protected function catToTemplate($project,$tasks){
        ob_start();
        include __DIR__ . '/project_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}