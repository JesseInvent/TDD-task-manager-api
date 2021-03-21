<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\UserActions;
use Tests\Helpers\TestsData;
use Tests\Helpers\Assertions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    use UserActions;

    use Assertions;
    

   /** @test */
   public function a_user_can_login_with_correct_credentials_after_signup ()
   {
        // Arrange
        $data = new TestsData();

        // Act
         $this->attemptUserSignup($data->user());
         $this->attemptUserLogout();
         $response = $this->attemptUserLogin();

         // Assert
        $this->AssertThatResponseIsJSON($response);
        $this->AssertThatTokenWasReturned($response->getData());
        $this->AssertThatUserIsLoggedIn();
   }


   /** @test */
   public function a_user_can_log_out()
   {
        // Arrange
        $data = new TestsData();

        // Act
        $this->attemptUserSignup();
        $response = $this->attemptUserLogout();

        // Asserts
       $this->AssertThatUserIsNotLoggedIn();
   }


   /** @test */
   public function a_user_cannot_login_with_incorrect_credentials_after_signup ()
   {
       // Arrange
       $data = new TestsData();

       // Act
       $this->attemptUserSignup();
       $this->attemptUserLogout();
       $response = $this->attemptWrongUserLogin();

       // Assert
       $this->AssertThatUserIsNotLoggedIn();
       $this->assertEquals($response->getData()->error, 'Unauthorized');
    }
}
