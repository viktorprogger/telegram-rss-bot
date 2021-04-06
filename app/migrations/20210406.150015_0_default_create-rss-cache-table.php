<?php

namespace App\Migration;

use Spiral\Migrations\Migration;

class OrmDefaultDd2022cd07d88bf3e42848f9292bdc88 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $table = $this->table('rss_cache')->getSchema();
        $table->primary('id');
        $table->string('hash')->nullable(false);
        $table->string('source_id')->nullable(false);
        $table->string('target_id')->nullable(false);
        $table->save();
    }

    public function down(): void
    {
        $this->table('rss_cache')->drop();
    }
}
