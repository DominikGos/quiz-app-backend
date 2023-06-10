<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        DB::table('quizzes')->truncate();
        DB::table('questions')->truncate();
        DB::table('categories')->truncate();
        DB::table('quiz_category')->truncate();
        DB::table('answers')->truncate();
        Schema::enableForeignKeyConstraints();

        $user = User::factory()->create(['name' => 'user', 'email' => 'user@email.com']);

        $quiz = Quiz::factory(['is_published' => true])->for($user)->create();

        $unpublishedQuiz = Quiz::factory(['is_published' => false])->for($user)->create();

        $question = Question::factory()->for($quiz)->create();

        Category::factory(2)->hasAttached($quiz)->create();

        Answer::factory(4)->for($question)->create();
    }
}
