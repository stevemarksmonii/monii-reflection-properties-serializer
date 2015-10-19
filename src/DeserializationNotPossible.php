<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

use RuntimeException;

class DeserializationNotPossible extends RuntimeException
{
    public function __construct($className)
    {
        parent::__construct(sprintf(
            'Cannot deserialize object of type %s.',
            $className
        ));
    }
}
