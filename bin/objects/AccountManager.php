<?php

namespace l\objects;

class AccountManager extends DataBase
{
    /**
     * @return bool
     */
    public static function isLogged(): bool
    {
        $userId = self::getUserId();
        if ($userId === 0) {
            return false;
        }

        $user = self::getUser();
        if (is_null($user)) {
            return false;
        }

        return true;
    }

    public static function getUser (?int $userId = NULL): ?array
    {
        $findUserId = $userId === NULL ? self::getUserId() : $userId;
        if (is_null($findUserId) || $findUserId === 0) {
            return null;
        }

        $db = new self('users');

        $data = $db->findBy('user_id', $findUserId);

        return $data[0] ?? null;
    }

    public static function isBanned (): bool
    {
        $user = self::getUser();

        if (is_null($user) || !isset($user['is_banned'])) {
            return false;
        }

        if (intval($user['is_banned']) === 1) {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public static function getUserId (): int
    {
        if (!isset($_SESSION['user_id'])) {
            return 0;
        }

        return (int) $_SESSION['user_id'];
    }

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public static function auth (string $login, string $password): bool
    {
        $pm = new PasswordManager();

        $user = $pm->findBy('login', $login);

        if (isset($user[0]) && $pm->isPasswordCorrect($user[0]['user_id'], $password)) {
            $_SESSION['user_id'] = $user[0]['user_id'];
            return true;
        }

        return false;
    }

    /**
     * @param int $role
     * @return bool
     */
    public static function permitted (int $role): bool
    {
        if (!self::isLogged()) {
            return false;
        }

        $user = self::getUser();

        if (!$user) {
            return false;
        }

        if ($user['role'] <= 0 && self::isBanned()) {
            return false;
        }

        if (intval($user['role']) >= $role) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public static function logout (): bool
    {
        $_SESSION = [];
        return true;
    }
}
