<?php

namespace app\modules\project\components;

use yii\base\Widget;
use app\components\TimeSupport;

/**
 * Виджет выводит проект и немного информации мз него
 *
 * Class ProjectWidget
 * @package app\modules\project\components
 */
class ProjectWidget extends Widget
{
    /**
     * @var string шаблон проекта, его вид
     */
    public $tpl = null;
    /**
     * @var array Все данные из бд, с проекта
     */
    public $data = [];
    /**
     * @var array Данные с массива но в виде дерева
     */
    public $tree;
    /**
     * @var string для вывода html
     */
    public $projectHtml;
    /**
     * @var array Project Все проекты учавсующие в создание виджета для их вывода
     */
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

    /**
     * @return string
     */
    public function run()
    {

        foreach ($this->projects as $p) {
            if (!empty($p['time_at']))
                $p['time_at'] = TimeSupport::createtime($p['time_at']);
        }

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

    /**
     * Формирует сами модули
     *
     * @param $tree
     * @return string
     */
    protected function getProjectHtml($tree)
    {
        $str = '';
        foreach ($tree as $project) {
            $str .= $this->catToTemplate($project, $this->tasks, $this->csscol);
        }

        return $str;
    }

    /**
     * Передает все параметры в шаблон
     *
     * @param $project
     * @param $tasks
     * @param $csscol
     * @return false|string весь шаблон для вывода
     */
    protected function catToTemplate($project, $tasks, $csscol)
    {
        ob_start();
        include __DIR__ . '/views/' . $this->tpl;
        return ob_get_clean();
    }
}