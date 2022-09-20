<?php

declare(strict_types=1);

use yii\db\Migration;

class m220302_053150_create_table_product_variable_properties extends Migration
{
    private const TABLE_NAME = '{{%product_variable_properties}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'product_id' => $this->bigInteger()->unsigned(),
            'variable_property_id' => $this->bigInteger()->unsigned(),
            'attribute_id' => $this->bigInteger()->unsigned(),
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
            'fk_variable_property_id',
            self::TABLE_NAME,
            'variable_property_id',
            '{{%variable_properties}}',
            'id',
            'cascade',
            'cascade'
        );

        $this->addForeignKey(
            'fk_attribute_id',
            self::TABLE_NAME,
            'attribute_id',
            '{{%property_attributes}}',
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
        $this->dropForeignKey('fk_variable_property_id', self::TABLE_NAME);
        $this->dropForeignKey('fk_attribute_id', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
