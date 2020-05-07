<?php

namespace app\service;

use app\entity\Comment;
use app\form\CommentForm;
use app\repository\CommentRepository;
use Yii;

class SaveCommentService
{
    /** @var CommentRepository */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function saveCommentByFormAndArticleId(CommentForm $commentForm, int $articleId): bool
    {
        $comment = new Comment();
        $comment->text = $commentForm->comment;
        $comment->user_id = Yii::$app->user->id;
        $comment->article_id = $articleId;
        $comment->date = date('Y-m-d');
        return $this->commentRepository->save($comment);
    }
}
