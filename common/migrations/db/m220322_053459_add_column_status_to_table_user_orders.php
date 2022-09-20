<?php

declare(strict_types=1);

use yii\db\Migration;

class m220322_053459_add_column_status_to_table_user_orders extends Migration
{
    private const TABLE_NAME = '{{%user_orders}}';
    private const COLUMN = '{{%status_id}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->addColumn(self::TABLE_NAME, 'status_id', $this->bigInteger());
        $this->addForeignKey(
            'fk_status_id',
            self::TABLE_NAME,
            self::COLUMN,
            '{{%statuses}}',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropColumn(self::TABLE_NAME, self::COLUMN);
    }
}
