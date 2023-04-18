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
    public function test_get_books_endpoint(): void
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

    public function test_get_single_book_endpoint(): void
    {
        $book = Book::factory(1)->createOne();

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($book) {
            info($json);
            $json->hasAll(['id', 'title', 'isbn'])->etc();
            // $json->hasAll(['id', 'title', 'isbn','created_at','updated_at']);

            $json->whereType('id', 'integer');
            $json->whereType('title', 'string');
            $json->whereType('isbn', 'string');


            $json->whereAll([
                'id'     => $book->id,
                'title'  => $book->title,
                'isbn'   => $book->isbn,
            ]);

        });
    }

    public function test_post_books_endpoint(): void
    {
        $book = Book::factory(1)->makeOne()->toArray();

        $response = $this->postJson('/api/books',$book);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($book) {
            
            $json->hasAll(['id', 'title', 'isbn','created_at','updated_at']);
     
            $json->whereAll([
                'title'  => $book['title'],
                'isbn'   => $book['isbn'],
            ]);

        });

    }

    
    public function test_put_books_endpoint(): void
    {

        Book::factory(1)->createOne();

        $book = [
            'title' => 'Atualizando Livro',
            'isbn'  => '2355wjudldofuft'
        ];


        $response = $this->putJson('/api/books/1',$book);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($book) {
            
            $json->hasAll(['id', 'title', 'isbn','created_at','updated_at']);
     
            $json->whereAll([
                'title'  => $book['title'],
                'isbn'   => $book['isbn'],
            ]);

        });


    }

    public function test_patch_books_endpoint(): void
    {

        Book::factory(1)->createOne();

        $book = [
            'title' => 'Atualizando Livro Patch',
        ];


        $response = $this->putJson('/api/books/1',$book);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($book) {
            
            $json->hasAll(['id', 'title', 'isbn','created_at','updated_at']);
     
            $json->where('title', $book['title'])->etc();

        });


    }
}
