<?php

namespace Tests\Unit;

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{

    use RefreshDatabase;
    
    private function data () :array
    {
        return [
            'body' => 'A task body',
            'user_id' => 1
        ];
    }

    // test a task can be created
    /** @test */
    public function a_task_can_be_created ()
    {
        $request = Request::create('api/task', 'POST', $this->data());
        $controller = new TaskController();
        $controller->store($request);

        $this->assertCount(1, Task::first()); 
        $this->assertEquals(Task::first()->body, $this->data()['body']);

    }

    // test a task cannot be created without body

    // test a task can be retrieve from DB

    // test a task can be updated 

    // test a task can be deleted
}
