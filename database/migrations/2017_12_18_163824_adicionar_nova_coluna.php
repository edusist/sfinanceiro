<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionarNovaColuna extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
//        Schema::table('pagamentos', function (Blueprint $table) {
//
//            $table->integer('subcat_pag_id')->nullable()->unsigned();
//            $table->foreign('subcat_pag_id')
//                    ->references('id')
//                    ->on('sub_cat_pagamentos')
//                    ->onUpdate('set null')
//                    ->onDelete('set null');
//        });
//        Schema::table('receipts', function (Blueprint $table) {
//
//            $table->integer('subcat_rec_id')->nullable()->unsigned();
//            $table->foreign('subcat_rec_id')
//                    ->references('id')
//                    ->on('sub_cat_recebimentos')
//                    ->onUpdate('set null')
//                    ->onDelete('set null');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
