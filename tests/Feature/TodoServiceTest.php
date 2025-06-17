<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo\ListTodo;
use App\Interfaces\TodoInterface;

class TodoServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $data = [
            'name'        => 'Test Todo',
            'description' => 'This is a test todo.',
            'user_id'     => 1,
        ];
    
        $todo = app(TodoInterface::class)->createTodo($data);
    
        $this->assertInstanceOf(ListTodo::class, $todo);
        $this->assertDatabaseHas('list_todos', ['name' => 'Test Todo']);
    }
}
