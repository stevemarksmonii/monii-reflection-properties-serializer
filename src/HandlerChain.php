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
        try {
            foreach ($this->serializers as $serializer) {
                if ($serializer->canSerialize($object)) {
                    return $serializer->serialize($object);
                }
            }
            throw new Exception('Serialization not possible');
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
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
        try {
            foreach ($this->serializers as $serializer) {
                if ($serializer->canDeserialize($className)) {
                    return $serializer->deserialize($className, $data);
                }
            }
            throw new Exception('Serialization not possible');
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
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
