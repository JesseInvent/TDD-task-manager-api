<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\Helpers\Assertions;
use Tests\Helpers\TestsData;
use Tests\UserActions;

class SignupTest extends TestCase
{
    use RefreshDatabase;

    use UserActions;

    use Assertions;

    public function AssertThatPasswordIsHashed ($password)
    {
        return $this->assertNotEquals($password, User::first()->password);
    } 

    public function AssertThatEmailMatches($email)
    {
        return $this->assertEquals($email, User::first()->email);
    }


    /** @test */
    public function a_user_can_sign_up_with_credentials()
    {

        // Arrange
        $userModel = new User();
        $data = new TestsData();
        // $userActions = new UserActions();

        // Act
        $response = $this->attemptUserSignup();

        // Asserts

        $this->assertEquals(Response::HTTP_OK, $response->status());

        $this->AssertThat_Response_IsJSON($response);

        $this->AssertThat_Model_WasCreated($userModel);

        $this->AssertThatPasswordIsHashed($data->user()['password']);

        $this->AssertThatEmailMatches($data->user()['email']);

        $this->Assert_That_Token_Was_Returned($response->getData());
        
        $this->AssertThat_User_IsLoggedIn();

    }


    /** @test */
    public function a_user_can_not_sign_up_without_credentials()
    {
        // $this->withoutExceptionHandling();
        // Arrange
        $userModel = new User();
        $data = new TestsData();

        // Act
        $response = $this->attemptInvalidUserSignup();
        // dd($response);
        // Asserts
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->status());
        $this->Assert_That_No_Model_Was_Created($userModel);

    }   

}
