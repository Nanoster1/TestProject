<?php
namespace app\widgets;

use yii\base\Widget;
use app\models\Category;

/**
 * Виджет для вывода дерева разделов каталога товаров
 */
class TreeWidget extends Widget
{
    /**
     * Выборка категорий каталога из базы данных
     */
    protected array $data;

    /**
     * Массив категорий каталога в виде дерева
     */
    protected $tree;

    public function run()
    {
        $html = '';
        // данных нет в кеше, получаем их заново
        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->makeTree();
        if (!empty($this->tree)) {
            $html = $this->render('menu', ['tree' => $this->tree]);
        }
        return $html;
    }

    /**
     * Функция принимает на вход линейный массив элеменов, связанных
     * отношениями parent-child, и возвращает массив в виде дерева
     */
    protected function makeTree()
    {
        if (empty($this->data)) {
            return;
        }
        foreach ($this->data as $id => &$category) {
            if ($category['parentId'] === null) {
                $this->tree[$id] = &$category;
            } else {
                $this->data[$category['parentId']]['childs'][$id] = &$category;
            }
        }
    }
}