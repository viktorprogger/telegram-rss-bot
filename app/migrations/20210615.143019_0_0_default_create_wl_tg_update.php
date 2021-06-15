<?php

namespace App\Migration;

use Spiral\Migrations\Migration;

class OrmDefaultC46583ff3b0ac02bcff88debf4cedb48 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('wl_tg_update')
            ->addColumn('id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('created_at', 'timestamp', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('contents', 'longText', [
                'nullable' => false,
                'default'  => null
            ])
            ->setPrimaryKeys(["id"])
            ->create();
    }

    public function down(): void
    {
        $this->table('wl_tg_update')->drop();
    }
}
