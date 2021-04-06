<?php

namespace App\Migration;

use Spiral\Migrations\Migration;

class OrmDefaultDd2022cd07d88bf3e42848f9292bdc88 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('rss_items_cache')
            ->addColumn('id', 'string')
            ->addColumn('source_id', 'string')
            ->addColumn('target_id', 'string')
            ->addColumn('hash', 'string')
            ->setPrimaryKeys(['id'])
            ->create();
    }

    public function down(): void
    {
        $this->table('rss_items_cache')->drop();
    }
}
