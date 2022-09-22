<?php

class Validation
{
    public const CORRECT_MESSAGE = 'Data is correct';
    private const INVALID_SYMBOLS = array("%","+","-","=","/","*","&","^","%","$","#","@","!",":",";",">","'","<",".",",","`","~","\"","|","\\"," ");

    private static array $instances = [];
    private WorkWithDatabase $database;
    private array $responseData = [];

    protected function __construct()
    {
        $this->database = WorkWithDatabase::getInstance();
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Validation
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();

        }

        return self::$instances[$cls];
    }

    private function isUnique ($array, $field, $value): bool
    {
        foreach ($array as $item)
        {
            if ($item[$field] === $value)
                return false;
        }
        return true;
    }

    public function CheckParameters ($login, $password, $passwordConfirm, $email, $name, $isAuth): array
    {

        $resultMessage = $this->CheckLogin($login, $isAuth);
        if (strcmp($resultMessage,self::CORRECT_MESSAGE) !== 0) {
            $this->AddMessageToResponse('login',$resultMessage);
        }

        $resultMessage = $this->CheckPassword($password);
        if (strcmp($resultMessage,self::CORRECT_MESSAGE) !== 0) {
            $this->AddMessageToResponse('password',$resultMessage);
        }

        if ($passwordConfirm) {
            $resultMessage = $this->CheckConfirmedPassword($password, $passwordConfirm);
            if (strcmp($resultMessage, self::CORRECT_MESSAGE) !== 0) {
                $this->AddMessageToResponse('passwordConfirm', $resultMessage);
            }
        }

        if ($email) {
            $resultMessage = $this->CheckEmail($email);
            if (strcmp($resultMessage, self::CORRECT_MESSAGE) !== 0) {
                $this->AddMessageToResponse('email', $resultMessage);
            }
        }

        if ($name) {
            $resultMessage = $this->CheckName($name);
            if (strcmp($resultMessage, self::CORRECT_MESSAGE) !== 0) {
                $this->AddMessageToResponse('name', $resultMessage);
            }
        }

        return $this->responseData;
    }

    private function AddMessageToResponse ($field,$message)
    {
        if (count($this->responseData))
            $index = count($this->responseData);
        else
            $index = 0;

        $this->responseData[$index] = ['id' => $field, 'message' => 'Wrong '.$field.': '.$message];
    }

    private function CheckLogin($login,$isAuth): string
    {
        $length = strlen($login);

        if ($length < 6)
            return 'Minimum number of symbols is 6';

        $clearLogin = str_replace(self::INVALID_SYMBOLS,"",$login);

        if (strcmp($login,$clearLogin) != 0)
            return 'Contains invalid symbols';

        if (!$isAuth) {
            $users = $this->database->getUsers();
            if (!$this->isUnique($users,"login",$login))
                return 'This login is already taken';
        }


        return self::CORRECT_MESSAGE;
    }

    private function CheckPassword($password): string
    {
        $length = strlen($password);

        if ($length < 6)
            return 'Minimum number of symbols is 6';

        $clearPassword = str_replace(self::INVALID_SYMBOLS,"",$password);

        if (strcmp($password,$clearPassword) != 0)
            return 'Contains invalid symbols';

        if (!preg_match('^\S*(?=\S{6,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*\d)\S*$^',$password))
            return 'Invalid password';

        return self::CORRECT_MESSAGE;
    }

    private function CheckConfirmedPassword($password, $confirmPassword): string
    {
        if (strcmp($password,$confirmPassword) !== 0)
            return 'Invalid password confirmation';

        return self::CORRECT_MESSAGE;
    }

    private function CheckName($name): string
    {
        $length = strlen($name);

        if ($length < 2)
            return 'Minimum number of symbols is 2';

        $clearName = str_replace(self::INVALID_SYMBOLS,"",$name);

        if (strcmp($name,$clearName) != 0)
            return 'Contains invalid symbols';

        if (!preg_match('/^[a-zA-Zа-яА-Я]+$/ui',$name))
            return 'Invalid name, only letters';

        return self::CORRECT_MESSAGE;
    }

    private function CheckEmail($email): string
    {
        $users = $this->database->getUsers();
        if (!$this->isUnique($users,"email",$email))
            return 'This email is already taken';

        return self::CORRECT_MESSAGE;
    }

}