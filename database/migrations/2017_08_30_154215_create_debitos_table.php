<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('debitos', function (Blueprint $table) {
//            $table->increments('id');          
//            $table->decimal('valor', 10, 2)->nullable();
//            $table->text('detalhes', 100)->nullable();
//            $table->dateTime('data_vencimento')->nullable();
//            $table->integer('forma_pagamento_id')->nullable()->unsigned();
//            $table->foreign('forma_pagamento_id')
//                    ->references('id')
//                    ->on('forma_pagamentos')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');
//            $table->integer('pagamento_id')->nullable()->unsigned();
//            $table->foreign('pagamento_id')
//                    ->references('id')
//                    ->on('pagamento')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');
//
//            $table->timestamps();
       // });
//        Schema::create('forma_pagamentos', function(Blueprint $table){
//            $table->increments('id');
//            $table->text('detalhes', 100)->nullable();
//            $table->integer('bank_id')->nullable()->unsigned();
//            $table->foreign('bank_id')
//                    ->references('id')
//                    ->on('banks')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');         
//            $table->timestamps();
//            
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('debitos');
    }
}
