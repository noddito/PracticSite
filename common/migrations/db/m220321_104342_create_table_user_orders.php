<?php

declare(strict_types=1);

use yii\db\Migration;

class m220321_104342_create_table_user_orders extends Migration
{
    private const TABLE_NAME = '{{%user_orders}}';
    private const PRECISION = 14;
    private const SCALE = 2;

    /**
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE_NAME, [
            'order_id' => $this->bigPrimaryKey()->unsigned(),
            'user_id' => $this->bigInteger()->unsigned(),
            'description' => $this->text(),
            'total_price' => $this->decimal(self::PRECISION,self::SCALE)->unsigned(),
        ]);

        $this->addForeignKey(
            'fk_user_id',
            self::TABLE_NAME,
            'user_id',
            '{{%user}}',
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
        $this->dropForeignKey('fk_user_id', self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
