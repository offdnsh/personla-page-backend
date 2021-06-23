<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('phone', 11)->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->text('bio')->nullable();
            $table->integer('work_experience_at')->nullable();
            $table->enum('category', [
                'Первая  квалификационная  категория',
                'Высшая  квалификационная  категория',
            ])->nullable();
            $table->enum('academic_degree', [
                'Кандидат наук',
                'Доктор наук'
            ])->nullable();
            $table->enum('academic_title', [
                'Доцент',
                'Профессор'
            ])->nullable();
            $table->string('place_of_work')->nullable();
            $table->string('position')->nullable();
            $table->string('inst_url')->nullable();
            $table->string('vk_url')->nullable();
            $table->string('ok_url')->nullable();
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
        Schema::dropIfExists('user_profiles');
    }
}
