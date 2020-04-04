<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_guides', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('title');
            $table->bigInteger('channel_id')->index();
            $table->bigInteger('show_id')->nullable(true);
            $table->date('date');
            $table->timestamp('starts');
            $table->timestamp('ends');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['date', 'channel_id', 'starts']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_guides');
    }
}
