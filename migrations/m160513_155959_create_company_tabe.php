<?php

use yii\db\Migration;

/**
 * Handles the creation for table `company_tabe`.
 */
class m160513_155959_create_company_tabe extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('company', [
            'id' => $this->primaryKey(),
            'name' =>'string NOT NULL',
            'salary' => 'double NOT NULL',
            'id_parent' =>'int',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('company');
    }
}
