<?php

namespace Tests\Helpers;


trait Assertions
{

    public function AssertThat_Response_IsJSON($response)
    {
        return $this->assertIsObject($response);
    }


    public function AssertThat_Model_WasCreated($model)
    {
        return $this->assertCount(1, $model::all());
    }
    
    public function Assert_That_Token_Was_Returned($responseData)
    {
        return $this->assertNotNull($responseData->access_token);
    }

    public function Assert_That_No_Model_Was_Created($model)
    {
        return $this->assertCount(0, $model::all());
    }


    public function AssertThat_User_IsLoggedIn()
    {
        return $this->assertNotNull(auth()->user());
    }

    public function Assert_That_User_IsNot_LoggedIn()
    {
        return $this->assertNull(auth()->user());
    }

}
