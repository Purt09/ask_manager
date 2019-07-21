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


    public $projects = [];
    /**
     * @var array Задачи проектов
     */
    public $tasks = [];

    /**
     * @var int Размер модуля
     */
    public $csscol = 4;

    /**
     * @var bool Параметр оьвечающий за вывод родителькой категории. С parent_id = null
     *
     * Если true - то выводит
     * false - не выводит
     */
    public $parent = true;

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

        foreach ($this->projects as $project) {
            if ((!$this->parent) && ($project['parent_id'] === null))
                continue;

            // формируем массив проектов, для их дальнейшего преобразования в дерево
            $this->data += [$project['id'] => $project];
            foreach ($project['projects'] as $child) {
                $this->data += array($child['id'] => $child);
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