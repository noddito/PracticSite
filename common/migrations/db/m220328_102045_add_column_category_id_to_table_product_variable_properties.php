<?php

declare(strict_types=1);

use yii\db\Migration;

class m220328_102045_add_column_category_id_to_table_product_variable_properties extends Migration
{
    private const TABLE_NAME = '{{%product_variable_properties}}';
    private const COLUMN = '{{%category_id}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->addColumn(self::TABLE_NAME, self::COLUMN, $this->bigInteger());
        $this->addForeignKey(
            'fk_category_id',
            self::TABLE_NAME,
            self::COLUMN,
            '{{%categories}}',
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
        $this->dropForeignKey('fk_category_id', self::TABLE_NAME);
        $this->dropColumn(self::TABLE_NAME, self::COLUMN);
    }
}
