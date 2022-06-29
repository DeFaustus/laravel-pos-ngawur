<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("kategori_id")->constrained("kategoris")->onUpdate("cascade")->onDelete("cascade");
            $table->foreignId('supplier_id')->constrained("suppliers")->onUpdate("cascade")->onDelete("cascade");
            $table->string("nama");
            $table->integer("harga_beli");
            $table->integer("harga_jual");
            $table->unsignedInteger("stok", false);
            $table->string("gambar")->nullable(true);
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
        Schema::dropIfExists('barangs');
    }
};
