<?php
namespace Tests\Helpers;

class TestsData {

    public function user () :array
    {
        return [
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    public function task () :array
    {
        return [
            'body' => 'Task One'
        ];
    }

}