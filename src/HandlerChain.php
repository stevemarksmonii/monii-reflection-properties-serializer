<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer;

use Exception;

class HandlerChain implements Handler
{
    /**
     * @var Serializer[]
     */
    private $serializers;

    public function __construct(
        $serializers = array()
    ) {
        $this->serializers = $serializers;
    }

    /**
     * (@inheritdoc)
     */
    public function canSerialize($object)
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->canSerialize($object)) {
                return true;
            }
        }
        return false;
    }

    /**
     * (@inheritdoc)
     */
    public function serialize($object)
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->canSerialize($object)) {
                return $serializer->serialize($object);
            }
        }
        throw new SerializationNotPossible($object->getName());
    }

    /**
     * (@inheritdoc)
     */
    public function canDeserialize($className)
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->canDeserialize($className)) {
                return true;
            }
        }
        return false;
    }

    /**
     * (@inheritdoc)
     */
    public function deserialize($className, array $data)
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->canDeserialize($className)) {
                return $serializer->deserialize($className, $data);
            }
        }
        throw new DeserializationNotPossible($className);
    }

    public function pushSerializer($serializer)
    {
        $this->serializers[] = $serializer;
    }

    public function unshiftSerializer($serializer)
    {
        array_unshift($serializers, $serializer);
    }
}
