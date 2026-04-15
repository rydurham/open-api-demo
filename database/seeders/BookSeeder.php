<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    private const DEMO_BOOK_COUNT = 20;

    /**
     * Curated titles keyed by ISBN (natural key for idempotent upserts).
     *
     * @var array<string, array{title: string, author: string, publication_year: int, description: string}>
     */
    private function curatedBooks(): array
    {
        return [
            '9780201835953' => [
                'title' => 'The Mythical Man-Month',
                'author' => 'Frederick P. Brooks Jr.',
                'publication_year' => 1995,
                'description' => 'Essays on software engineering and project management.',
            ],
            '9781449373320' => [
                'title' => 'Designing Data-Intensive Applications',
                'author' => 'Martin Kleppmann',
                'publication_year' => 2017,
                'description' => 'Principles and trade-offs behind reliable, scalable, and maintainable data systems.',
            ],
        ];
    }

    /**
     * @return list<string>
     */
    private function curatedIsbns(): array
    {
        return array_keys($this->curatedBooks());
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->curatedBooks() as $isbn => $attributes) {
            Book::query()->updateOrCreate(
                ['isbn' => $isbn],
                $attributes,
            );
        }

        $curatedIsbns = $this->curatedIsbns();

        $demoBookCount = Book::query()
            ->where(function ($query) use ($curatedIsbns) {
                $query
                    ->whereNull('isbn')
                    ->orWhereNotIn('isbn', $curatedIsbns);
            })
            ->count();

        $missing = max(0, self::DEMO_BOOK_COUNT - $demoBookCount);

        if ($missing > 0) {
            Book::factory()->count($missing)->create();
        }
    }
}
