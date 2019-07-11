<?php

namespace app\modules\project\components;

use yii\base\Widget;
use app\modules\project\models\Project;
use app\modules\task\models\Task;
use yii\helpers\ArrayHelper;

class ProjectWidget extends Widget
{
    /**
     * @var string шаблон проекта, его вид
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

    public $id;

    /**
     * @var integer id проекта для которого строим виджет
     */
    public $ids = [];

    public $projects = [];
    /**
     * @var array Задачи проекта
     */
    public $tasks = [];

    public $csscol = 4;

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
        foreach ($this->projects as $project) {
            static $i = 0;
            $this->ids += array($i => $project['id']);
            $i++;

            // формируем массив проектов, для их дальнейшего преобразования в дерево
            $this->data += [$project['id'] => $project];
            foreach ($project['projects'] as $child) {
                $this->data += array($child['id'] => $child);
                $this->ids += array($i => $child['id']);
            }
            $i++;
        }

        $tasks = $model->getTasks();
        foreach ($tasks as $t) {
            foreach ($this->ids as $i)
                if (($t['project_id'] == $i) && ($t['status'] != 0)) {
                    $t = ArrayHelper::toArray($t);
                    $t = array(
                        $t['id'] => $t,
                    );
                    $this->tasks = ArrayHelper::merge($this->tasks, $t);
                }
        }
        $this->tree = $this->getTree();


        $this->projectHtml = $this->getProjectHtml($this->tree);
        return $this->projectHtml;
    }


    /**
     * Строит дерево из данных
     *
     * @return array
     */
    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id => &$node) {
            if ((!$node['parent_id']) || ($node['parent_id'] == $this->id))
                $tree[$id] = &$node;
        }
        return $tree;
    }

    protected function getProjectHtml($tree)
    {
        $str = '';
        foreach ($tree as $project) {
            $str .= $this->catToTemplate($project, $this->tasks, $this->csscol);
        }

        return $str;
    }

    protected function catToTemplate($project, $tasks, $csscol)
    {
        ob_start();
        include __DIR__ . '/project_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}