<?php

namespace Tests\Feature\API;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BooksControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_books_get_endpoint(): void
    {
        $books = Book::factory(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function (AssertableJson $json) use ($books) {
            // info($json);
            $json->hasAll(['0.id', '0.title', '0.isbn']);

            $json->whereType('0.id', 'integer');
            $json->whereType('0.title', 'string');
            $json->whereType('0.isbn', 'string');

            $book = $books->first();

            $json->whereAll([
                '0.id'     => $book->id,
                '0.title'  => $book->title,
                '0.isbn'   => $book->isbn,
            ]);

        });
    }
}
