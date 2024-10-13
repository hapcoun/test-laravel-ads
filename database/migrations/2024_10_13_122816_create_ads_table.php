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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->string('title');
            $table->text('text');
            $table->enum('status', ['active', 'pending', 'archived']);
            $table->string('url');
            $table->unsignedInteger('views')->default(0);
            $table->decimal('cpm', 8, 2)->default(0);
            $table->decimal('budget', 8, 2)->default(0);
            $table->enum('button_text', ['Watch', 'Apply', 'Download', 'More Info']);
            $table->timestamps();

            $table->foreign('campaign_id')
                ->references('id')
                ->on('campaigns')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
