<?php

// Single Responsibility Principle Violation
class User {

    public $name;
    public $email;

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function validate()
    {
        if(empty($this->name)) {
            exit('User name is required.');
        }
        if(empty($this->email)) {
            exit('User email is required.');
        }
    }

    public function responseJson()
    {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode([
            'name' => $this->name,
            'email' => $this->email
        ]);
    }

    public function responseHTML()
    {
        echo sprintf('<p><strong>User name:</strong> %s', $this->name) . PHP_EOL;
        echo sprintf('<p><strong>User email:</strong> %s', $this->email) . PHP_EOL;
    }

}

$user = new User('Mobarok Hossain', 'mobarok@example.com');
$user->validate();
$user->responseJson();

// Refactored
class UserRequest {

    public static function validate(User $user)
    {
        if(empty($user->getName())) {
            exit('User name is required.');
        }
        if(empty($user->getEmail())) {
            exit('User email is required.');
        }
    }

}

interface ResponsableInterface {

    public static function response(User $user);

}

class User {

    private $name;
    private $email;

    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}

class JsonResponseUser implements ResponsableInterface {

    public static function response(User $user)
    {
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ]);
    }

}

class HTMLResponseUser implements ResponsableInterface {

    public static function response(User $user)
    {
        echo sprintf('<p><strong>User name:</strong> %s', $user->getName()) . PHP_EOL;
        echo sprintf('<p><strong>User email:</strong> %s', $user->getEmail()) . PHP_EOL;
    }

}

$user = new User('Mobarok Hossain', 'mobarok@example.com');

UserRequest::validate($user);

JsonResponseUser::response($user);
