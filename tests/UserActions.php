<?php

namespace Tests;

use Tests\Helpers\TestsData;

trait UserActions {

    public function attemptUserSignup ()
    {
        $data = new TestsData();
        return $this->post('/api/auth/signup', $data->user());
    }

    public function attemptInvalidUserSignup ()
    {
        $data = new TestsData();
        return $this->post('/api/auth/signup', array_merge($data->user(), ['name' => '']));
    }

    public function attemptUserLogin ()
    {
        $data = new TestsData();
        return $this->post('/api/auth/login', [
            'email' => $data->user()['email'],
            'password' => 'password',
        ]);
    }

    public function attemptWrongUserLogin ()
    {
        $data = new TestsData();
        return $this->post('/api/auth/login', [
            'email' => $data->user()['email'],
            'password' => 'wrong',
        ]);
    }

    public function attemptUserLogout()
    {
        return $this->post('/api/auth/logout');
    }

    public function attemptToCreateTask($token)
    {
        $data = new TestsData();
        return $this->withHeaderS([
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer '.$token
                        ])
                    ->post('/api/task?token='.$token, $data->task()
                );
    }
}