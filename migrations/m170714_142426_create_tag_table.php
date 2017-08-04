<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m170714_142426_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tag', [
            'id' => 'pk',
            'title'=> $this->string()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tag');
    }
}
