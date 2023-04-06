<?php

use app\models\Category;
use app\models\Order;
use app\models\OrderItem;
use app\models\Product;
use app\models\User;
use yii\db\Migration;

/**
 * Class m230404_140506_init
 */
class m230404_140506_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(Category::tableName(), [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'parentId' => $this->integer()->unsigned()->null()->defaultValue(null),
            'name' => $this->string()->notNull(),
            'content' => $this->string()->null()->defaultValue(null),
            'description' => $this->string()->null()->defaultValue(null),
            'image' => $this->string()->null()->defaultValue(null)
        ]);

        $this->createTable(Product::tableName(), [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'categoryId' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'content' => $this->string()->null(),
            'price' => $this->decimal(10, 2)->notNull()->defaultValue(0.00),
            'description' => $this->string()->null()->defaultValue(null),
            'image' => $this->string()->null()->defaultValue(null),
            'isHit' => $this->boolean()->notNull()->defaultValue(false),
            'isNew' => $this->boolean()->notNull()->defaultValue(false),
            'isSale' => $this->boolean()->notNull()->defaultValue(false)
        ]);

        $this->createTable(Order::tableName(), [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'userId' => $this->integer()->null()->defaultValue(null),
            'name' => $this->string()->notNull()->defaultValue(''),
            'email' => $this->string()->notNull()->defaultValue(''),
            'phone' => $this->string()->notNull()->defaultValue(''),
            'address' => $this->string()->notNull()->defaultValue(''),
            'comment' => $this->string()->notNull()->defaultValue(''),
            'amount' => $this->float()->notNull()->defaultValue(0.00),
            'status' => $this->string()->notNull()->defaultValue(''),
            'created' => $this->dateTime()->notNull()->defaultExpression('current_timestamp'),
            'updated' => $this->dateTime()->notNull()->defaultExpression('current_timestamp')
        ]);

        $this->createTable(OrderItem::tableName(), [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'orderId' => $this->integer()->unsigned()->notNull(),
            'productId' => $this->integer()->unsigned()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'price' => $this->float()->notNull()->defaultValue(0.00),
            'quantity' => $this->integer()->unsigned()->notNull()->defaultValue(1),
            'cost' => $this->float()->notNull()->defaultValue(0.00)
        ]);

        $this->addForeignKey(
            'fk_product_category_id',
            Product::tableName(),
            'categoryId',
            Category::tableName(),
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_category_parent_id',
            Category::tableName(),
            'parentId',
            Category::tableName(),
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_order_item_order_id',
            OrderItem::tableName(),
            'orderId',
            Order::tableName(),
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_order_item_product_id',
            OrderItem::tableName(),
            'productId',
            Product::tableName(),
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230404_140506_init cannot be reverted.\n";

        return false;
    }

/*
// Use up()/down() to run migration code without a transaction.
public function up()
{
}
public function down()
{
echo "m230404_140506_init cannot be reverted.\n";
return false;
}
*/
}