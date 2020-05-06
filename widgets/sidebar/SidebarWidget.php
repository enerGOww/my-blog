<?php

namespace app\widgets\sidebar;

use yii\base\Widget;

class SidebarWidget extends Widget
{
    public $popularPosts = [];

    public $recentPosts = [];

    public $categories = [];

    public function run()
    {
        return $this->render(
            'sidebar',
            [
                'popularPosts' => $this->popularPosts,
                'recentPosts' => $this->recentPosts,
                'categories' => $this->categories
            ]
        );
    }
}
