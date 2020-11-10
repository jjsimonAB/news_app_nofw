<?php
declare(strict_types=1);

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
            ->addColumn('author', 'string')
            ->addColumn('views', 'integer')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => 'true'])
            ->create();
        
        $categories_table->addColumn('category_name', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'timestamp', ['null' => 'true'])
            ->create();
    }
}
