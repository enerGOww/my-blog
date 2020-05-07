<?php

namespace app\widgets\comment;

use yii\base\Widget;

class CommentWidget extends Widget
{
    public $comments;

    public $commentForm;

    public $idToRecord;

    public function run()
    {
        return $this->render('comment', [
            'comments' => $this->comments,
            'commentForm' => $this->commentForm,
            'idToRecord' => $this->idToRecord
        ]);
    }
}
