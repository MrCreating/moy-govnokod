<?php

namespace l\objects;

use Exception;

/**
 * Base object class.
 * default setters contain
 */

class BaseObject
{
    /**
     * @var bool
     */
    private bool $__sealedObject = false;

    /**
     * @param array $params
     * @throws Exception
     */
    public function __construct(array $params = [], bool $strictLoad = true)
    {
        foreach ($params as $key => $value) {
            if (!isset($this->{$key}) && $strictLoad) {
                throw new Exception("Key $key is not set in object");
            }

            $this->{$key} = $value;
        }
    }

    /**
     * @return BaseObject
     */
    public function seal(): BaseObject
    {
        $this->__sealedObject = !$this->__sealedObject;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSealed (): bool
    {
        return $this->__sealedObject;
    }
}

?>
