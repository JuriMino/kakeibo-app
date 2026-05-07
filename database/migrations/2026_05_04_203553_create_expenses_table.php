<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // ユーザー削除で支出も削除
            $table->string('title');                                        // 項目名
            $table->unsignedInteger('amount');                              // 金額（円・正の整数）
            $table->string('category')->default('その他');                   // カテゴリー
            $table->date('spent_on');                                       // 支出日
            $table->text('memo')->nullable();                               // メモ（任意）
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
