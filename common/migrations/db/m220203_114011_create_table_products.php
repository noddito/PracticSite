<?php

declare(strict_types=1);

use yii\db\Migration;

class m220203_114011_create_table_products extends Migration
{
    private const TABLE_NAME = '{{%products}}';
    private const PRECISION = 10;
    private const SCALE = 2;

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(self::PRECISION,self::SCALE)->unsigned(),
            'price_usd' => $this->decimal(self::PRECISION,self::SCALE)->unsigned(),
            'category_id' => $this->bigInteger()->unsigned(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'image' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk_category_id',
            self::TABLE_NAME,
            'category_id',
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
        $this->dropTable(self::TABLE_NAME);
    }
}
