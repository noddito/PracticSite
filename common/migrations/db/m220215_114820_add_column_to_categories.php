<?php

declare(strict_types=1);

use yii\db\Migration;

class m220215_114820_add_column_to_categories extends Migration
{
    private const TABLE_NAME = '{{%categories}}';
    private const COLUMN = '{{%description}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->addColumn(self::TABLE_NAME, self::COLUMN, $this->text());
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropColumn(self::TABLE_NAME, self::COLUMN);
    }
}
