<?php

class WorkWithDatabase
{
    private string $FILE_NAME = "database.json";
    private array $jsonArray = [];
    private static array $instances = [];
    private string $salt = '$2a$07$R.gJb2U2N.FmZ4hPp1y2CN$';

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    private function readFile(): bool
    {
        if (file_exists($this->FILE_NAME)) {
            $json = file_get_contents($this->FILE_NAME);
            $this->jsonArray = json_decode($json, true);
            return true;
        } else {
            return false;
        }
    }

    public static function getInstance(): WorkWithDatabase
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function addPerson($login, $password, $email, $name): bool
    {
        if ($this->readFile()) {
            if (count($this->jsonArray))
                $index = count($this->jsonArray);
            else
                $index = 0;
            if ($login && $password && $email && $name) {
                $this->jsonArray[$index] = ["login" => $login, "password" => $this->passwordHash($password), "email" => $email, "name" => $name];
                file_put_contents('database.json', json_encode($this->jsonArray, JSON_FORCE_OBJECT));
            }
            return true;
        } else {
            return false;
        }
    }

    private function passwordHash($password): string
    {
        return hash('md5', $this->salt . $password, false);
    }

    public function getUsers(): array
    {
        if ($this->readFile()) {
            return $this->jsonArray;
        } else {
            return [];
        }
    }

    public function getUserInfo($param, $inputParam, $searchInfo)
    {
        if ($this->readFile()) {
            foreach ($this->jsonArray as $user) {
                if ($user[$param] === $inputParam) {
                    return $user[$searchInfo];
                }
            }
        }
        return '';
    }

    public function getUserID($login): int
    {
        if ($this->readFile()) {
            for ($i = 0; $i < count($this->jsonArray); $i++) {
                if ($this->jsonArray[$i]['login'] === $login) {
                    return $i;
                }
            }
        }
        return -1;
    }
}