<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->bigInteger('totalQty');
            $table->bigInteger('user_id');
            $table->bigInteger('status_id');
            $table->string('user_email',200);
            $table->string('receiver_email',200);
            $table->string('note',200)->nullable();
            $table->timestamps();
        });
        Schema::create('request_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_requests_id');
            $table->string('name',200);
            $table->bigInteger('item_id');
            $table->bigInteger('quanity');
            $table->string('image',300);
            $table->timestamps();
            
            $table->foreign('user_requests_id')
            ->references('id')
            ->on('user_requests')
            ->onDelete('cascade');
        });
        Schema::create('request_tool', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_requests_id');
            $table->unsignedBigInteger('tool_id');
            
            
            $table->foreign('user_requests_id')
            ->references('id')
            ->on('user_requests')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_requests');
    }
}
