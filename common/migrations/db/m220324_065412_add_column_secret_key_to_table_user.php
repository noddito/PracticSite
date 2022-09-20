<?php

declare(strict_types=1);

use yii\db\Migration;

class m220324_065412_add_column_secret_key_to_table_user extends Migration
{
    private const TABLE_NAME = '{{%user}}';
    private const COLUMN = '{{%secret_key}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->addColumn(self::TABLE_NAME, self::COLUMN, $this->string());
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropColumn(self::TABLE_NAME, self::COLUMN);
    }
}
