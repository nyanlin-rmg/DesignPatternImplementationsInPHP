<?php

abstract class Middleware
{
    private $next;

    public function linkNext(Middleware $next)
    {
        $this->next = $next;
        return $next;
    }

    public function check($email, $password)
    {
        return $this->next ? $this->next->check($email, $password) : true;
    }
}

class Server
{
    private $users = [];
    private $middleware;

    public function setMiddleware(Middleware $middleware)
    {
        $this->middleware = $middleware;
    }

    public function login($email, $password)
    {
        if ($this->middleware->check($email, $password)) {
            echo "Server: Authentication Success\n";
            return true;
        }

        return false;
    }

    public function register($email, $password)
    {
        $this->users[$email] = $password;
    }

    public function hasEmail($email)
    {
        return isset($this->users[$email]);
    }

    public function isValidPassword($email, $password)
    {
        return $this->users[$email] === $password;
    }
}

class UserCheckMiddleware extends Middleware
{
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function check($email, $password)
    {
        if(!$this->server->hasEmail($email)) {
            echo "UserCheckMiddleware: User Not Found On The Server\n";
            return false;
        }

        if(!$this->server->isValidPassword($email, $password)) {
            echo "UserCheckMiddleware: Invalid Password\n";
            return false;
        }

        return parent::check($email, $password);
    }
}

class RoleCheckMiddleware extends Middleware
{
    public function check($email, $password)
    {
        if ($email === 'admin@example.com') {
            echo "RoleCheckMiddleware: User Has Admin Role\n";
            return true;
        }

        echo "RoleCheckMiddleware: User Has Not Admin Role!\n";

        return parent::check($email, $password);
    }
}

class ThrottleCheckMiddleware extends Middleware
{
    private $requestPerMinute;
    private $request;
    private $currentTime;

    public function __construct($requestPerMinute)
    {
        $this->requestPerMinute = $requestPerMinute;
        $this->currentTime = time();
    }

    public function check($email, $password)
    {
        if (time() > $this->currentTime + 60) {
            $this->request = 0;
            $this->currentTime = time();
        }

        $this->request++;

        if ($this->request > $this->requestPerMinute) {
            echo "ThrottlingMiddleware: Request limit exceeded!\n";
            die();
        }

        return parent::check($email, $password);
    }
}

function client_code() {
    $server = new Server();
    $server->register("john@example.com", "123456789");
    $server->register("admin@example.com", "123456789");

    $middleware = new ThrottleCheckMiddleware(2);
    $middleware->linkNext(new UserCheckMiddleware($server))
        ->linkNext(new RoleCheckMiddleware());

    var_dump($middleware);

    $server->setMiddleware($middleware);

    do {
        echo "\nEnter your email:\n";
        $email = readline();
        echo "Enter your password:\n";
        $password = readline();
        $success = $server->login($email, $password);
    } while (!$success);
}

client_code();
