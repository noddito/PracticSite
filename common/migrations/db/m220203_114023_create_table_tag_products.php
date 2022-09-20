<?php

declare(strict_types=1);

use yii\db\Migration;

class m220203_114023_create_table_tag_products extends Migration
{
    private const TABLE_NAME = '{{%tag_products}}';

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'product_id' => $this->bigInteger()->unsigned(),
            'tag_id' => $this->bigInteger()->unsigned(),
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
            'fk_product_tag',
            self::TABLE_NAME,
            'tag_id',
            '{{%tags}}',
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
        $this->dropForeignKey('fk_product_tag', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}

