<?php

/* @var $this View */
/* @var $article Article */
/* @var $populars Article[] */
/* @var $recents Article[] */
/* @var $categories Category[] */

use app\entity\Article;
use app\entity\Category;
use app\widgets\sidebar\SidebarWidget;
use yii\helpers\Url;
use yii\web\View;

$this->title = $article->title;
?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <img src="<?= $article->getImage() ?>" alt="">
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute('site/category', ['id' => $article->category_id]) ?>"> <?= $article->category->title ?></a></h6>

                            <h1 class="entry-title"><?= $article->title ?></h1>

                        </header>
                        <div class="entry-content">
                            <?= $article->content ?>
                        </div>
                        <div class="decoration">
                            <?php foreach ($article->tags as $tag): ?>
                                <a href="<?= Url::toRoute('site/tag', ['id' => $tag->id]) ?>" class="btn btn-default"><?= $tag->title ?></a>
                            <?php endforeach; ?>
                        </div>

                        <div class="social-share">
							<span
                                class="social-share-title pull-left text-capitalize">By Rubel On <?= $article->getDate() ?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>

                <div class="bottom-comment"><!--bottom comment-->
                    <h4>3 comments</h4>

                    <div class="comment-img">
                        <img class="img-circle" src="assets/images/comment-img.jpg" alt="">
                    </div>

                    <div class="comment-text">
                        <a href="#" class="replay btn pull-right"> Replay</a>
                        <h5>Rubel Miah</h5>

                        <p class="comment-date">
                            December, 02, 2015 at 5:57 PM
                        </p>


                        <p class="para">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                            diam nonumy
                            eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                            voluptua. At vero eos et cusam et justo duo dolores et ea rebum.</p>
                    </div>
                </div>
                <!-- end bottom comment-->


                <div class="leave-comment"><!--leave comment-->
                    <h4>Leave a reply</h4>

                    <form class="form-horizontal contact-form" role="form" method="post" action="#">
                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="form-control" rows="6" name="message" placeholder="Write Massage"></textarea>
                            </div>
                        </div>
                        <a href="#" class="btn send-btn">Post Comment</a>
                    </form>
                </div><!--end leave comment-->
            </div>
            <?= SidebarWidget::widget([
                'popularPosts' => $populars,
                'recentPosts' => $recents,
                'categories' => $categories
            ]);
            ?>
        </div>
    </div>
</div>
