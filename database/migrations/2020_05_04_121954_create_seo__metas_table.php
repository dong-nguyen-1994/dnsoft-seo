<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo__metas', function (Blueprint $table) {
            $table->id();
            $table->morphs('metable');
            $table->{database_jsonable()}('title')->nullable();
            $table->{database_jsonable()}('description')->nullable();
            $table->{database_jsonable()}('keywords')->nullable();
            $table->{database_jsonable()}('og_title')->nullable();
            $table->{database_jsonable()}('og_description')->nullable();
            $table->{database_jsonable()}('twitter_title')->nullable();
            $table->{database_jsonable()}('twitter_description')->nullable();

            $table->string('robots')->nullable();
            $table->string('canonical')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo__metas');
    }
}
