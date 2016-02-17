<?php

namespace Emulator\Util;

abstract class Enum implements \JsonSerializable {

    /**
     * @var string
     */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value) {
        $this->setValue($value);
    }

    /**
     * @param mixed $value
     */
    public function setValue($value) {
        if (!static::isValid($value)) {
            //throw new InvalidArgumentException(sprintf("Invalid enumeration %s for Enum %s", $value, get_class($this)));
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Check if the set value on this enum is a valid value for the enum
     * @return boolean
     */
    public static function isValid($value): bool {
        if (!in_array($value, static::validValues())) {
            return false;
        }
        return true;
    }

    /**
     * Get the valid values for this enum
     * Defaults to constants you define in your subclass
     * override to provide custom functionality
     * @return array
     */
    public static function validValues(): array {
        $r = new \ReflectionClass(get_called_class());
        return array_values($r->getConstants());
    }

    /**
     * @see JsonSerialize
     */
    public function jsonSerialize() {
        return $this->getValue();
    }

    /**
     * @return string
     */
    public function __toString(): string {
        return (string) $this->getValue();
    }

}
