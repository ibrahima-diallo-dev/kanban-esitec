<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tasks') || ! Schema::hasColumn('tasks', 'status')) {
            return;
        }

        DB::table('tasks')
            ->where('status', 'in_progress')
            ->update(['status' => 'doing']);

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE tasks MODIFY status ENUM('todo', 'doing', 'done') NOT NULL DEFAULT 'todo'");
    }

    public function down(): void
    {
        if (! Schema::hasTable('tasks') || ! Schema::hasColumn('tasks', 'status')) {
            return;
        }

        DB::table('tasks')
            ->where('status', 'doing')
            ->update(['status' => 'in_progress']);

        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE tasks MODIFY status ENUM('todo', 'in_progress', 'done') NOT NULL DEFAULT 'todo'");
    }
};
