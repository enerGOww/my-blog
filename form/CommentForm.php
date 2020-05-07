<?php

namespace app\form;

use yii\base\Model;

class CommentForm extends Model
{
    /** @var string */
    public $comment;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'length' => [3,250]]
        ];
    }
}
