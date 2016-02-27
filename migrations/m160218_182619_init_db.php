<?php

use yii\db\Migration;

class m160218_182619_init_db extends Migration {
    public function safeUp() {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'name' => $this->string(100)->notNull(),
            'trans_name' => $this->string(100)->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->createIndex('idx_categories_trans_name', 'categories', 'trans_name', true);
        $this->addForeignKey('fk_categories_parent', 'categories', 'parent_id', 'categories', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'is_active' => $this->smallInteger()->notNull()->defaultValue(1),
            'title' => $this->string(100)->notNull(),
            'trans_title' => $this->string(100)->notNull(),
            'preview' => $this->text()->notNull(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime()
        ]);
        $this->addForeignKey('fk_news_categories', 'news', 'category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_news_trans_title', 'news', 'trans_title', true);

        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'visitor' => $this->string(30)->notNull(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->dateTime()
        ]);
        $this->addForeignKey('fk_posts_news', 'posts', 'news_id', 'news', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown() {
        $this->dropTable('posts');
        $this->dropTable('news');
        $this->dropTable('categories');
    }
}
