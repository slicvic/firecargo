<?php

class AuthControllerTest extends TestCase {

    public function testPostLoginSuccess()
    {
        Session::start();

        $parameters = [];
        $parameters['_token'] = csrf_token();
        $parameters['email'] = 'vmlantigua@gmail.com';
        $parameters['password'] = 'pass1234';

        $response = $this->call('POST', '/login', $parameters);

        $this->assertRedirectedTo('dashboard');
    }

    public function testPostLoginFail()
    {
        Session::start();

        $parameters = [];
        $parameters['_token'] = csrf_token();
        $parameters['email'] = 'sadasdasdas@gmail.com';
        $parameters['password'] = 'pass1234';

        $response = $this->call('POST', '/login', $parameters);

        $this->assertSessionHas(['flash_notification']);
    }
}
