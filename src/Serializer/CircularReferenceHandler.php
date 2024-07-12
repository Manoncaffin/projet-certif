<?php

namespace App\Serializer;

class CircularReferenceHandler
{
    public function handle($object)
    {
        return $object->getId();
    }
}

?>