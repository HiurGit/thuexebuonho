<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collaborators', function (Blueprint $table) {
            $table->string('status', 20)->default('active')->after('phone')->index();
            $table->string('code', 50)->nullable()->unique()->after('status');
            $table->decimal('commission_rate', 5, 2)->default(10)->after('code');
            $table->string('email')->nullable()->after('address');
            $table->string('bank_name')->nullable()->after('avatar');
            $table->string('bank_account')->nullable()->after('bank_name');
            $table->string('bank_owner')->nullable()->after('bank_account');
            $table->text('note')->nullable()->after('sort_order');
            $table->string('registered_via', 30)->nullable()->after('note');
            $table->timestamp('approved_at')->nullable()->after('registered_via');
        });

        // Các cộng tác viên đang có được giữ trạng thái hoạt động và được cấp mã giới thiệu.
        DB::table('collaborators')->whereNull('status')->update(['status' => 'active']);

        DB::table('collaborators')->whereNull('code')->orderBy('id')->each(function ($collaborator) {
            DB::table('collaborators')
                ->where('id', $collaborator->id)
                ->update(['code' => 'CTV'.str_pad((string) $collaborator->id, 4, '0', STR_PAD_LEFT)]);
        });
    }

    public function down(): void
    {
        Schema::table('collaborators', function (Blueprint $table) {
            $table->dropUnique(['code']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'status', 'code', 'commission_rate', 'email',
                'bank_name', 'bank_account', 'bank_owner', 'note',
                'registered_via', 'approved_at',
            ]);
        });
    }
};
