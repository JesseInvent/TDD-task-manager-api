<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\UserActions;
use Tests\Helpers\TestsData;
use Tests\Helpers\Assertions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

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
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->AssertThat_Response_IsJSON($response);
        $this->Assert_That_Token_Was_Returned($response->getData());
        $this->AssertThat_User_IsLoggedIn();
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
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->status());
       $this->Assert_That_User_IsNot_LoggedIn();
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
       $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->status());
       $this->Assert_That_User_IsNot_LoggedIn();
       $this->assertEquals($response->getData()->error, 'Unauthorized');
    }
}
