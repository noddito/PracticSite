<?php

declare(strict_types=1);

use yii\db\Migration;

class m220217_085757_add_column_parent_id_to_categories extends Migration
{
    private const TABLE_NAME = '{{%categories}}';
    private const COLUMN = '{{%parent_id}}';

    /**
     * @return void
     */
    public function SafeUp(): void
    {
        $this->addColumn(self::TABLE_NAME, self::COLUMN, $this->bigInteger());
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->dropColumn(self::TABLE_NAME, self::COLUMN);
    }
}
