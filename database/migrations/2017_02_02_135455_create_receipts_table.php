<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateReceiptsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        
//     Schema::table('receipts', function (Blueprint $table) {
//         
//         // $table->dropColumn('nota_fiscal_cr');
//        $table->string('nota_fiscal_cr', 100)->nullable();
//        //$table->renameColumn('nome', 'nome_recebimento');
//         
//
//     });
//
//            $table->increments('id');
//            $table->string('nome', 100)->nullable();
//            $table->string('nota_fiscal_cr', 150)->unique();
//            $table->decimal('valor', 10, 2)->nullable();
//            $table->string('status', 10);
//            $table->text('descricao', 500)->nullable();
//            $table->dateTime('data_vencimento')->nullable();
//            $table->timestamps();
//            $table->integer('companie_id')->nullable()->unsigned();
//            $table->foreign('companie_id')
//                    ->references('id')
//                    ->on('companies')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');
//
//            $table->integer('customer_id')->nullable()->unsigned();
//            $table->foreign('customer_id')
//                    ->references('id')
//                    ->on('customers')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');
//
//            $table->integer('category_receipt_id')->nullable()->unsigned();
//            $table->foreign('category_receipt_id')
//                    ->references('id')
//                    ->on('category_receipts')
//                    ->onUpdate('cascade')
//                    ->onDelete('cascade');
    //    });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

//         Schema::table('receipts', function (Blueprint $table) {
//            $table->dropForeign('categorys_receipt_id');   
//        });
        //Schema::dropIfExists('receipts');
    }

}
