<?php

namespace rssBot\Migration;

use Spiral\Migrations\Migration;

class OrmDefault672b19cd420ec23d3c9a440616bb867b extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $table = $this->table('rss_cache')->getSchema();
        $table->primary('id');
        $table->string('hash')->nullable(false);
        $table->string('destination')->nullable(false);
    }

    public function down(): void
    {
        $this->table('rss_cache')->drop();
    }
}
