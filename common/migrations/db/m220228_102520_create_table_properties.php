<?php

declare(strict_types=1);

use yii\db\Migration;

class m220228_102520_create_table_properties extends Migration
{
    private const TABLE_NAME = '{{%property}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
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
