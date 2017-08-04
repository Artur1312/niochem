<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m170714_142529_create_comment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comment', [
            'id' => 'pk',
            'text' =>$this->string(),
            'user_id'=>$this->integer(),
            'article_id'=>$this->integer(),
            'status'=>$this->integer()
        ]);


        //create index for column 'user_id'

    $this->createIndex(
    'idx-post-user_id',
        'comment',
        'user_id'
    );

        //add foreign key for table 'user'
        $this->addForeignKey(
          'fk-post-user_id',
            'comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        //create index for column 'article_id'

        $this->createIndex(
            'idx-article_id',
            'comment',
            'user_id'
        );

        //add foreign key for table 'article'
        $this->addForeignKey(
            'fk-article_id',
            'comment',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );


 }
 /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('comment');
    }
}
