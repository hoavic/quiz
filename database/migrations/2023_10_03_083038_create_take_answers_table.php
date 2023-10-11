<?php

use App\Models\Answer;
use App\Models\Question;
use App\Models\Take;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('take_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Take::class);
            $table->foreignIdFor(Question::class);
            $table->foreignIdFor(Answer::class);
            $table->tinyInteger('active')->default(0);
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('take_answers');
    }
};
