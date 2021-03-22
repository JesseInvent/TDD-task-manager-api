<?php

namespace Tests\Feature;

use App\Models\CompletedTask;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\Assertions;
use Tests\Helpers\TestsData;
use Tests\TestCase;
use Tests\UserActions;
use Symfony\Component\HttpFoundation\Response;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    use UserActions;

    use Assertions;

    /** @test */
    public function user_can_create_a_task_a_valid_token ()
    {

        // Arrange
        $data = new TestsData();
        $taskModel = new Task();
        $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
        $token = $authResponse->getData()->access_token;

        // Act
        $response = $this->attemptToCreateTask($token);

        // Asserts
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->AssertThat_Model_WasCreated($taskModel);
        $this->assertEquals(Task::first()->body, $data->task()['body']);

    }


    /** @test */
    public function user_can_not_create_task_without_token ()
    {
        // Arrange
        $taskModel = new Task();
       
        // Act
        $response = $this->attemptToCreateTask('');

        // Asserts
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->status());
        $this->Assert_That_No_Model_Was_Created($taskModel);
   
    }


    /** @test */
    public function user_can_not_create_task_with_invalid_token ()
    {
        // Arrange
        $taskModel = new Task();
       
        // Act
        $response = $this->attemptToCreateTask('invalidToken');

        // Asserts
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->status());
        $this->Assert_That_No_Model_Was_Created($taskModel);
   
    }


    /** @test */
    public function user_can_update_task_with_valid_token ()
    {
        // Arrange
        $taskModel = new Task();
        $newTask = ['body' => 'Updated Task'];
        $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
        $token = $authResponse->getData()->access_token;

        // Act
        $this->attemptToCreateTask($token);
        $response = $this->attemptToUpdateTask($token, $newTask);
       
        // Asserts
        $this->assertEquals(Response::HTTP_ACCEPTED, $response->status());
        $this->AssertThat_Model_WasCreated($taskModel);
        $this->assertEquals(Task::first()->body, $newTask['body']);
   
    }

    //   /** @test */
    //   public function user_can_not_update_task_with_invalid_token ()
    //   {
    //       // Arrange
    //       $taskModel = new Task();
    //       $newTask = ['body' => 'Updated Task'];
    //       $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
    //       $token = $authResponse->getData()->access_token;
         
    //       // Act
    //       $this->attemptToCreateTask($token);
    //       $response = $this->attemptToCreateTask('invalidToken');
  
    //       // Asserts
    //       $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->status());
    //       $this->Assert_That_No_Model_Was_Created($taskModel);
     
    //   }


    /** @test */
    public function user_can_delete_task_with_valid_token ()
    {
        // Arrange
        $taskModel = new Task();
        $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
        $token = $authResponse->getData()->access_token;
        
        // Act
        $this->attemptToCreateTask($token);
        $response = $this->attemptToDeleteTask($token);

        // Asserts
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
        $this->Assert_That_No_Model_Was_Created($taskModel);
    
    }

    /** @test */
    public function user_can_mark_task_as_completed_with_valid_token ()
    {
        // Arrange
        $completedTaskModel = new CompletedTask();
        $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
        $token = $authResponse->getData()->access_token;
       
        // Act
        $this->attemptToCreateTask($token);
        $response = $this->attemptTo_Mark_Task_AsComplete($token);

        // Asserts
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->AssertThat_Model_WasCreated($completedTaskModel);
        $this->assertEquals(Task::first()->id, CompletedTask::first()->task_id);
        $this->assertEquals(auth()->user()->id, CompletedTask::first()->user_id);
        
    }

    /** @test */
    public function user_can_mark_completed_task_as_incomplete ()
    {
       // Arrange
       $completedTaskModel = new CompletedTask();
       $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
       $token = $authResponse->getData()->access_token;
      
       // Act
       $this->attemptToCreateTask($token);
       $response = $this->attemptTo_Mark_Task_As_UnComplete($token);

       // Asserts
       $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
       $this->Assert_That_No_Model_Was_Created($completedTaskModel);
       
    }

    /** @test */
    public function user_cannot_mark_an_already_completed_task_as_complete ()
    {
        // Arrange
        $completedTaskModel = new CompletedTask();
        $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
        $token = $authResponse->getData()->access_token;
        
        // Act
        $this->attemptToCreateTask($token);
        $this->attemptTo_Mark_Task_AsComplete($token);
        $response = $this->attemptTo_Mark_Task_AsComplete($token);

        // Asserts
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->status());
        $this->AssertThat_Model_WasCreated($completedTaskModel);
    }

    /** @test */
    public function user_can_get_all_completed_tasks()
    {
        // Arrange
        $completedTaskModel = new CompletedTask();
        $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
        $token = $authResponse->getData()->access_token;
        
        // Act
        $this->attemptToCreateTask($token);
        $this->attemptTo_Mark_Task_AsComplete($token);
        $response = $this->attemptTo_Get_completed_Tasks($token);

        // Asserts
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertNotNull($response->getData()); 
        $this->assertNotNull($response->getData()[0]->body); 

    }

      /** @test */
      public function user_can_get_all_created_tasks()
      {
          $this->withoutExceptionHandling();
          // Arrange
          $authResponse = $this->Mock_User_SigningUp_And_LoggingIn_Action_With_Token_Returned();
          $token = $authResponse->getData()->access_token;
          
          // Act
          $this->attemptToCreateTask($token);
          $this->attemptToCreateTask($token);
          $this->attemptTo_Mark_Task_AsComplete($token);

          $response = $this->attemptTo_Get_Tasks($token);

        //   dd($response->getData());
  
          // Asserts
          $this->assertEquals(Response::HTTP_OK, $response->status());
          $this->assertNotNull($response->getData()); 
          $this->assertNotNull($response->getData()[0]->body); 

      }
}
