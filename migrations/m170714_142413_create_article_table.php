<?php

use yii\db\Migration;
use app\models\Article;
/**
 * Handles the creation of table `article`.
 */
class m170714_142413_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => 'pk',
            'title' => $this->string()->unique(),
            'description'=> $this->text(),
            'content'=>$this->text(),
            'date'=>$this->date(),
            'image'=>$this->string(),
            'viewed'=>$this->integer()->defaultValue(0),
            'user_id'=>$this->integer(),
            'status'=>$this->char(4)->defaultValue(Article::STATUS_DISALLOW),
            'category_id'=>$this->integer(),
            'isRemoved'=>"TINYINT (1) default 1",
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
