<?php
namespace app\widgets;

use yii\base\Widget;
use app\models\Category;

class TreeWidget extends Widget
{
    protected array $data;

    protected $tree;

    public function run()
    {
        $html = '';
        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->makeTree();
        if (!empty($this->tree)) {
            $html = $this->render('menu', ['tree' => $this->tree]);
        }
        return $html;
    }

    protected function makeTree()
    {
        if (empty($this->data)) {
            return;
        }
        foreach ($this->data as $id => &$category) {
            if ($category['parentId'] === null) {
                $this->tree[$id] = &$category;
            }
            else {
                $this->data[$category['parentId']]['childs'][$id] = &$category;
            }
        }
    }
}