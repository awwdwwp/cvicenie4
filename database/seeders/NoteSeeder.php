<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('notes')->insert([
            [
                'user_id' => 2,
                'title' => 'Laravel Seeder',
                'body' => 'Ako vytvoriť seeder v Laraveli?',
                'status' => 'published',
                'is_pinned' => true,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 3,
                'title' => 'Shopping List',
                'body' => 'Mlieko, chlieb, vajcia',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 2,
                'title' => 'Project Idea',
                'body' => 'Nápad na nový startup...',
                'status' => 'archived',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 4,
                'title' => 'Workout Plan',
                'body' => 'Push day, pull day, legs',
                'status' => 'published',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 5,
                'title' => 'Meeting Notes',
                'body' => 'Discuss project milestones',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 6,
                'title' => 'Travel Ideas',
                'body' => 'Visit Prague and Vienna',
                'status' => 'published',
                'is_pinned' => true,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 7,
                'title' => 'Book List',
                'body' => '1984, Dune, The Hobbit',
                'status' => 'draft',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'user_id' => 8,
                'title' => 'Daily Goals',
                'body' => 'Finish homework and exercise',
                'status' => 'published',
                'is_pinned' => false,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
        ]);
    }
}
