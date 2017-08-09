<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\models\Article;

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>


    <?php if(!empty($articles)): ?>
    <table class="table">
        <thead>
        <tr>
            <td>#</td>
            <td >Title</td>
            <td>Description</td>
            <td>Text</td>
            <td>Date</td>
            <td>Author</td>
            <td>Main Image</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach($articles as $article):?>
            <?php if($article->isRemoved()):?>
            <tr>
                <td><?= $article->id?></td>
                <td><?= $article->title?></td>
                <td><?= $article->description ?></td>
                    <?php if(strlen($article->content) > 300):?>
                <td><?= substr($article->content,0,300)?>...</td>
                    <?php else:?>
                        <td><?= $article->content ?></td>
                    <?php endif; ?>
                <td><?= $article->date ?></td>
                <td><?= $article->author->username ?></td>

                <td><img width="100px" src="<?= $article->getImage(); ?>"></td>
                <td>
                    <?php if($article->isAllowed() == Article::STATUS_DISALLOW):?>
                        <a class="btn btn-success" href="<?= Url::toRoute(['article/allow','id'=>$article->id]);?>">Allow</a>
                    <?php else:?>
                        <a class="btn btn-warning" href="<?= Url::toRoute(['article/disallow','id'=>$article->id]);?>">Disallow</a>
                    <?php endif;?>
                </td>
                <td>
                    <a href="<?= Url::toRoute(['article/view','id'=>$article->id]);?>" title="View" aria-label="View"><span class="glyphicon glyphicon-eye-open"></span></a>
                    <a href="<?= Url::toRoute(['article/update','id'=>$article->id]);?>" title="Update" aria-label="Update"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="<?= Url::toRoute(['article/delete','id'=>$article->id]);?>" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif;?>
<?php Pjax::end(); ?>

    </div>
