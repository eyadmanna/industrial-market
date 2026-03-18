<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // العنوان الرئيسي
            $table->string('subtitle');           // العنوان الفرعي
            $table->string('image');               // مسار الصورة
            $table->integer('order')->default(0);  // الترتيب
            $table->boolean('is_active')->default(true); // الحالة
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sliders');
    }
};
