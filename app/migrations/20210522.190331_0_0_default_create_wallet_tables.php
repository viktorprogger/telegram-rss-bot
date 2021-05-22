<?php

namespace App\Migration;

use Spiral\Migrations\Migration;

class OrmDefaultE7e3f4a7b4ba58126ce221ddcbe69ec7 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('wl_user')
            ->addColumn('id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->setPrimaryKeys(["id"])
            ->create();
        
        $this->table('wl_wallet')
            ->addColumn('id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('active', 'boolean', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('title', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('owner_id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addIndex(["owner_id"], [
                'name'   => 'wl_wallet_index_owner_id_60a955837391f',
                'unique' => false
            ])
            ->addForeignKey(["owner_id"], 'wl_user', ["id"], [
                'name'   => 'wl_wallet_foreign_owner_id_60a9558373944',
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->setPrimaryKeys(["id"])
            ->create();
        
        $this->table('wl_wallet_user')
            ->addColumn('id', 'primary', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('walletEntity_id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('userEntity_id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addIndex(["walletEntity_id", "userEntity_id"], [
                'name'   => 'wl_wallet_user_index_walletentity_id_userentity_id_60a9558373b9b',
                'unique' => true
            ])
            ->addIndex(["walletEntity_id"], [
                'name'   => 'wl_wallet_user_index_walletentity_id_60a9558373bcd',
                'unique' => false
            ])
            ->addIndex(["userEntity_id"], [
                'name'   => 'wl_wallet_user_index_userentity_id_60a9558373c42',
                'unique' => false
            ])
            ->addForeignKey(["walletEntity_id"], 'wl_wallet', ["id"], [
                'name'   => 'wl_wallet_user_foreign_walletentity_id_60a9558373bb9',
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->addForeignKey(["userEntity_id"], 'wl_user', ["id"], [
                'name'   => 'wl_wallet_user_foreign_userentity_id_60a9558373c2c',
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->setPrimaryKeys(["id"])
            ->create();
        
        $this->table('wl_category')
            ->addColumn('id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('active', 'boolean', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('title', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('amount', 'string', [
                'nullable' => true,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('wallet_id', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addIndex(["wallet_id"], [
                'name'   => 'wl_category_index_wallet_id_60a9558373d0a',
                'unique' => false
            ])
            ->addForeignKey(["wallet_id"], 'wl_wallet', ["id"], [
                'name'   => 'wl_category_foreign_wallet_id_60a9558373d26',
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ])
            ->setPrimaryKeys(["id"])
            ->create();
    }

    public function down(): void
    {
        $this->table('wl_category')->drop();
        
        $this->table('wl_wallet_user')->drop();
        
        $this->table('wl_wallet')->drop();
        
        $this->table('wl_user')->drop();
    }
}
