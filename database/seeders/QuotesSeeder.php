<?php

namespace Database\Seeders;

use App\Models\Quotes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotesSeeder extends Seeder
{
    public function run(): void
    {
        Quotes::insert([
            [
                'quote' => 'I saw that all beings are fated to happiness: action is not life, but a way of wasting some force, an enervation.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'So, my happiness doesn\'t come from money or fame. My happiness comes from seeing life without struggle.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'Yes, the companionship is amazing. You know, you can get that physical attraction that happens is great, but then there\'s an awful lot of time and the rest of the day that you have to fill.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'I have two younger sisters and I\'m such an advocate of owning who you are as a person. Don\'t be ashamed or intimidated. Never feel like you are not amazing.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'I thank you God for this most amazing day, for the leaping greenly spirits of trees, and for the blue dream of sky and for everything which is natural, which is infinite, which is yes.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'It may, however, be said that the level of experience to which concepts are inapplicable cannot yield any knowledge of a universal character, for concepts alone are capable of being socialized.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'Fear of error which everything recalls to me at every moment of the flight of my ideas, this mania for control, makes men prefer reason\'s imagination to the imagination of the senses.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'Do you remember when you were 10 or 11 years old and you really thought your folks were the best? They were completely omniscient and you took their word for everything.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'Why don\'t you start believing that no matter what you have or haven\'t done, that your best days are still out in front of you.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'I am consumed with the fear of failing. Reaching deep down and finding confidence has made all my dreams come true.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'You can\'t escape the taste of the food you had as a child. In times of stress, what do you dream about?',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'Listen to your inner-voice: Surround yourself with loving, nurturing people. Fall in love with your art and find yourself.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'quote' => 'Since obscenity is the truth of our passion today, it is the only stuff of art - or almost the only stuff.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
