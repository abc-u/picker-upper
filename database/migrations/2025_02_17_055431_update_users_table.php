<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('id')->unique(); // ユーザー名を追加
            $table->text('user_icon')->nullable()->after('password'); // ユーザーアイコンを追加
            $table->boolean('is_admin')->default(false)->after('user_icon'); // 管理者フラグを追加
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'user_icon', 'is_admin']);
        });
    }
};
