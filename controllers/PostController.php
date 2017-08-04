<?php
/**
 * Created by PhpStorm.
 * User: Diwork
 * Date: 03.08.2017
 * Time: 18:22
 */

namespace app\controllers;


use app\models\Article;
use app\models\ArticleTag;
use app\models\Category;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionView($id)
    {
        $article = Article::findOne($id);
        $tags = ArticleTag::find()->all();
        $popular = Article::getPopularPosts();
        $recent = Article::getRecentPosts();
        $categories = Category::getAll();
        $article->updateCounters(['viewed' => 1]);

        return $this->render('single',
            [
                'article' => $article,
                'tags' => $tags,
                'popular' => $popular,
                'recent' => $recent,
                'categories' => $categories


            ]);
    }


}