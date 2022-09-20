<?php

declare(strict_types=1);

use yii\db\Migration;

class m220228_103007_create_table_product_properties extends Migration
{
    private const TABLE_NAME = '{{%product_properties}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'product_id' => $this->bigInteger()->unsigned(),
            'properties_id' => $this->bigInteger()->unsigned(),
            'value' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk_product_id',
            self::TABLE_NAME,
            'product_id',
            '{{%products}}',
            'id',
            'cascade',
            'cascade'
        );

        $this->addForeignKey(
            'fk_properties_id',
            self::TABLE_NAME,
            'properties_id',
            '{{%property}}',
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
        $this->dropForeignKey('fk_product_id', self::TABLE_NAME);
        $this->dropForeignKey('fk_properties_id', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
