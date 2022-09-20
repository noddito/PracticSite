<?php

declare(strict_types=1);

use yii\db\Migration;

class m220325_091241_add_column_secret_key_is_valid_until_to_table_user extends Migration
{
    private const TABLE_NAME = '{{%user}}';
    private const COLUMN = '{{%is_valid_until}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->addColumn(self::TABLE_NAME, self::COLUMN, $this->integer());
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropColumn(self::TABLE_NAME, self::COLUMN);
    }
}
