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
use app\models\CommentForm;
use Yii;
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
        $comments = $article->getArticleComments();

        $commentForm = new CommentForm;

        return $this->render('single',
            [
                'article' => $article,
                'tags' => $tags,
                'popular' => $popular,
                'recent' => $recent,
                'categories' => $categories,
                'comments' => $comments,
                'commentForm' => $commentForm
            ]);
    }
    public function actionComment($id)
    {
        $model = new CommentForm();

        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());

            if($model->saveComment($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment will be published soon!');
                return $this->redirect(['post/view', 'id'=>$id]);
//                return var_dump($model);
            }
        }
    }

}