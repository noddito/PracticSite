<?php

declare(strict_types=1);

use yii\db\Migration;

class m220322_053428_create_table_statuses extends Migration
{
    private const TABLE_NAME = '{{%statuses}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'status' => $this->string(),
        ]);
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
