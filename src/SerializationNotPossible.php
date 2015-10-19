<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

use RuntimeException;

class SerializationNotPossible extends RuntimeException
{
    public function __construct($className)
    {
        parent::__construct(sprintf(
            'Cannot serialize object of type %s.',
            $className
        ));
    }
}
