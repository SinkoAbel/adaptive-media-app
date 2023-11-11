<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_create_new_todo_item(): int
    {
        $name = 'Test todo item';
        $description = 'Test description';
        $completed = 1;

        $response = $this->post('/api/items', [
            'name' => $name,
            'description' => $description,
            'completed' => $completed,
        ]);

        $response->assertStatus(201)
                 ->assertJsonIsObject();

        assertEquals($response['name'], $name);
        assertEquals($response['description'], $description);
        assertEquals($response['completed'], $completed);

        return $response['id'];
    }

    /**
     * @test
     */
    public function test_get_paginated_view(): void
    {
        $response = $this->get('/api/items');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function test_get_todo_item_by_id(): void
    {
        $createdTodoItemId = $this->test_create_new_todo_item();
        $name = 'Test todo item';
        $description = 'Test description';
        $completed = 1;

        $response = $this->get('/api/items/' . strval($createdTodoItemId))
            ->assertStatus(200);

        assertEquals($response['name'], $name);
        assertEquals($response['description'], $description);
        assertEquals($response['completed'], $completed);
    }

    /**
     * @test
     */
    public function test_modify_test_todo_item(): void
    {
        $createdTodoItemId = $this->test_create_new_todo_item();
        $name = 'Modified test todo item';
        $description = 'Modified test todo item';
        $completed = 0;

        $response = $this->put('/api/items/' . $createdTodoItemId, [
            'name' => $name,
            'description' => $description,
            'completed' => $completed,
        ]);

        $response->assertStatus(201);
        assertEquals($response['name'], $name);
        assertEquals($response['description'], $description);
        assertEquals($response['completed'], $completed);
    }

    /**
     * @test
     */
    public function test_delete_test_todo_item(): void
    {
        $createdTodoItemId = $this->test_create_new_todo_item();

        $response = $this->delete('/api/items/' . $createdTodoItemId);

        $response->assertStatus(204);
    }

    /**
     * @test
     */
    public function test_get_400_error_on_post_request(): void
    {
        $missingKey = $this->post('/api/items', [
            'name' => 'Name todo value',
            'description' => 'Desc. todo value',
        ]);

        $missingKey->assertStatus(400);
    }

    /**
     * @test
     */
    public function test_get_400_on_get_by_id(): void
    {
        $notValidId = 'invalid';
        $response = $this->get('/api/items/' . $notValidId);

        $response->assertStatus(400);
    }

    /**
     * @test
     */
    public function test_get_404_on_get_by_id(): void
    {
        $nonExistingId = -15;
        $response = $this->get('/api/items/' . $nonExistingId);

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function test_get_400_on_update_item_invalid_path_variable(): void
    {
        $notValidId = 'invalid';
        $response = $this->put('/api/items/' . $notValidId);

        $response->assertStatus(400);
    }

    /**
     * @test
     */
    public function test_get_400_on_update_item_invalid_request_body(): void
    {
        $id = $this->test_create_new_todo_item();

        $missingKey = $this->put('/api/items/' . $id, [
            'name' => 'Name todo value',
            'description' => 'Desc. todo value',
        ]);

        $missingKey->assertStatus(400);
    }

    /**
     * @test
     */
    public function test_get_404_on_update_item_was_not_found(): void
    {
        $notExistingId = 5000;

        $response = $this->put('/api/items/' . $notExistingId, [
            'name' => 'Name todo value',
            'description' => 'Desc. todo value',
            'completed' => 1,
        ]);

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function test_get_400_on_delete_invalid_path_variable(): void
    {
        $invalidPathVar = 'invalid';

        $response = $this->delete('/api/items/' . $invalidPathVar);

        $response->assertStatus(400);
    }

    /**
     * @test
     */
    public function test_get_404_on_delete_item_not_found(): void
    {
        $nonExistingId = 9999;

        $response = $this->delete('/api/items' . $nonExistingId);

        $response->assertStatus(404);
    }
}
