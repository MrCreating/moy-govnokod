<?php

namespace l\objects;

/**
 * Password manager for tables
 */

use l\objects\DataBase;

class PasswordManager extends DataBase
{
    private string $defaultField = 'user_id';

    /**
     * @param string $dbName
     * @param array $params
     * @throws \Exception
     */
    public function __construct(string $dbName = 'users', array $params = [])
    {
        parent::__construct($dbName, $params);
    }

    /**
     * @param string $field
     * @return $this
     */
    public function setDefaultField (string $field): PasswordManager
    {
        $this->defaultField = $field;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultField (): string
    {
        return $this->defaultField;
    }

    /**
     * @param $userId
     * @param $password
     * @param $update
     * @return false|string|null
     */
    public function createPasswordHash ($userId, $password, $update = false)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        if ($update) {
            $this->updateItemBy('credential', $hash, [
                $this->defaultField => $userId
            ]);
        }

        return $hash;
    }

    /**
     * @param $userId
     * @param $password
     * @return bool
     */
    public function isPasswordCorrect ($userId, $password): bool
    {
        $user = $this->findBy('user_id', $userId);

        return password_verify($user['credential'], $password);
    }
}
