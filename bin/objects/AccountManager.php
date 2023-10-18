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

    public static function getUser (): ?array
    {
        if (self::getUserId() === 0) {
            return null;
        }

        $db = new self('users');

        $data = $db->findBy('user_id', self::getUserId());

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
}
