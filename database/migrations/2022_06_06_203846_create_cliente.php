<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements("id", true);
            $table->string("first_name", 30);
            $table->string("last_name", 100)->nullable();


            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('document_type', function (Blueprint $table) {
            $table->increments("id", true);
            $table->string("type", 20);
            $table->string("abbrev", 10)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('document', function (Blueprint $table) {
            $table->bigIncrements("id", true);
            $table->unsignedInteger("type_id")->nullable();
            $table->unsignedBigInteger("customer_id")->nullable();
            $table->string("number", 50);

            $table->foreign("type_id")->references("id")->on("document_type");
            $table->foreign("customer_id")->references("id")->on("customer");

            $table->softDeletes();
            $table->timestamps();
        });



        Schema::create('contact_type', function (Blueprint $table) {
            // Email, telefone ...
            $table->increments("id", true);
            $table->string("type", 50);
            $table->string("abbrev", 50)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('contact', function (Blueprint $table) {
            $table->bigIncrements("id", true);
            $table->unsignedInteger("type_id")->nullable();
            $table->unsignedBigInteger("customer_id")->nullable();

            $table->string("contact", 100);

            $table->foreign("type_id")->references("id")->on("contact_type");
            $table->foreign("customer_id")->references("id")->on("customer");

            $table->softDeletes();
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
        Schema::dropIfExists('cliente');
    }
}
