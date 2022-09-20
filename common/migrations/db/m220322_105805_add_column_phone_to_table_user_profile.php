<?php

declare(strict_types=1);

use yii\db\Migration;

class m220322_105805_add_column_phone_to_table_user_profile extends Migration
{
    private const TABLE_NAME = '{{%user_profile}}';
    private const COLUMN = '{{%phone}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->addColumn(self::TABLE_NAME, self::COLUMN, $this->bigInteger());
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropColumn(self::TABLE_NAME, self::COLUMN);
    }
}
