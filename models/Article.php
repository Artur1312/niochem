<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $date
 * @property string $image
 * @property integer $viewed
 * @property integer $user_id
 * @property integer $status
 * @property integer $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title','description','content'], 'string'],
            [['date'], 'date', 'format'=>'php:Y-m-d'],
            [['date'], 'default', 'value' =>date('Y-m-d')],
            [['title'],'string','max'=> 255]
//            [['description'], 'string'],
//            [['date'], 'safe'],
//            [['viewed', 'user_id', 'status', 'category_id'], 'integer'],
//            [['title', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }
    /**
     * @method for saving an image
     */


    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function deleteImage()
    {
        $uploadImageModel = new UploadImage();
        $uploadImageModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function getImage()
    {
//         if($this->image)
//         {
//            return '/uploads/' . $this->image;
//         }
//         return '/no-image.png';

        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }
//
    public function getCategory()
   {
       return $this->hasOne(Category::className(), ['id' => 'category_id']);
   }

   public function saveCategory($category_id)
   {
       $category = Category::findOne($category_id);
       if($category != null)
       {
           $this->link('category', $category);
           return true;
       }

   }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveTags($tags)
    {
        if(is_array($tags))
        {

            foreach($tags as $tag_id)
            {
                $this->clearCurrentTags();
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    /**
     * @return string
     */
    public function clearCurrentTags()
    {
        return ArticleTag::deleteAll(['article_id'=>$this->id]);
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    public static function getAll($pageSize = 5)
    {
        // build a DB query to get all articles
        $query = Article::find();

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        // limit the query using the pagination and retrieve the articles
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data['articles'] = $articles;
        $data['pagination'] = $pagination;

        return $data;
    }

    public static function getPopularPosts()
    {
        return Article::find()->orderBy('viewed desc')->limit(3)->all();
    }

    public static function getRecentPosts()
    {
        return Article::find()->orderBy('date asc')->limit(4)->all();
    }
//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getArticleTags()
//    {
//        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
//    }
//
//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getComments()
//    {
//        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
//    }
}
