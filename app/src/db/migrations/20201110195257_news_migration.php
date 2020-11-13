<?php
declare (strict_types = 1);

use Phinx\Migration\AbstractMigration;

final class NewsMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $user_table = $this->table('users');
        $news_table = $this->table('news');
        $categories_table = $this->table('categories');
        $news_categories = $this->table('news_categories');

        // creating users migration.
        $user_table->addColumn('user_name', 'string')
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('password', 'string')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => 'true'])
            ->create();

        $news_table->addColumn('title', 'string')
            ->addColumn('content', 'text')
            ->addColumn('author_id', 'integer')
            ->addColumn('views', 'integer', ['default' => '0'])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('is_deleted', 'boolean', ['null' => 'false', 'default' => '0'])
            ->addForeignKey('author_id', 'users', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();

        $categories_table->addColumn('category_name', 'string')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('is_deleted', 'boolean', ['default' => '0'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => 'true'])
            ->create();

        $news_categories->addColumn('news_id', 'integer', ['null' => false])
            ->addColumn('categorie_id', 'integer', ['null' => false])
            ->addForeignKey('news_id', 'news', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('categorie_id', 'categories', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
