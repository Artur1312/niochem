<?php

namespace app\models;

use Yii;

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
