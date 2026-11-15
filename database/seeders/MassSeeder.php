<?php

namespace Database\Seeders;

use App\User;
use App\Set;
use App\Challenge;
use App\Registration;
use App\Submission;

use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class MassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    const USERS = 100;
    const SETS = 10;
    const QUESTIONS = 100;
    const CHALLENGES = 10;


    public function run()
    {
        factory(App\User::class, self::USERS)->create();
        factory(App\Set::class, self::SETS)->create();
        factory(App\Question::class, self::QUESTIONS)->create();
        factory(App\Challenge::class, self::CHALLENGES)->create();

        // add each set to each challenge
        $sets = Set::pluck('id')->toArray();
        Challenge::all()->each(function ($challenge) use ($sets) {
            $challenge->sets()->attach($sets);
        });

        // add each user to a single random challenge
        $challenges = Challenge::all();
        User::all()->each(function ($user) use ($challenges) {

            $registration = new Registration();
            $registration->user_id = $user->id;
            $registration->challenge_id = $challenges->random(1)->pluck('id')->first();
            $registration->score = 0;
            $registration->save();
        });

        // each user makes a single submission for each question
        Registration::all()->each(function ($registration) {
            /** @var Registration $registration */
            foreach ($registration->challenge->sets as $set) {
                foreach ($set->questions as $question) {
                    $submission = new Submission();
                    $submission->question_id = $question->id;
                    $submission->registration_id = $registration->id;
                    $submission->flag = Str::random(6);
                    $submission->save();
                }
            }
        });
    }
}
