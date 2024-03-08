<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', [
                'ঘর ভাড়া',
                'বিদ্যুৎ বিল',
                'ইন্টারনেট বিল',
                'গ্যাস বিল',
                'বাজার খরচ',
                'কেনাকাটা',
                'কাউকে দিন',
            ]);
            $table->text('description')->nullable();
            $table->decimal('amount');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expences');
    }
};
