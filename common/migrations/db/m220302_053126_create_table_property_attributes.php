<?php

declare(strict_types=1);

use yii\db\Migration;

class m220302_053126_create_table_property_attributes extends Migration
{
    private const TABLE_NAME = '{{%property_attributes}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'name' => $this->string(240)->notNull(),
            'property_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_property_id',
            self::TABLE_NAME,
            'property_id',
            '{{%variable_properties}}',
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
        $this->dropForeignKey('fk_property_id', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}

