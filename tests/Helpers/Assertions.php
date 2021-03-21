<?php

namespace Tests\Helpers;


trait Assertions
{

    public function AssertThatResponseIsJSON($response)
    {
        return $this->assertIsObject($response);
    }


    public function AssertThatModelWasCreated($model)
    {
        return $this->assertCount(1, $model::all());
    }
    
    public function AssertThatTokenWasReturned($responseData)
    {
        return $this->assertNotNull($responseData->access_token);
    }

    public function AssertThatNoModelWasCreated($model)
    {
        return $this->assertCount(0, $model::all());
    }


    public function AssertThatUserIsLoggedIn()
    {
        return $this->assertNotNull(auth()->user());
    }

    public function AssertThatUserIsNotLoggedIn()
    {
        return $this->assertNull(auth()->user());
    }

}
