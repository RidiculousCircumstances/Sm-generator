<?php

namespace Rc\SmGenerator\Validation;

use Error;
use Rc\SmGenerator\Exceptions\SitemapException;
use Rc\SmGenerator\Validation\Attributes\InRangeRule;
use ReflectionClass;
use ReflectionException;


/**
 * Calls the logic of the validation attributes. Gets their instances, gets validation rule instances and
 * delegates validation to them.
 */
class Executor {

    public static function validate ($class): null|array
    {
        try {
            try {
                $reflection = new ReflectionClass($class);
            } catch (ReflectionException $e) {
                echo $e->getMessage() . PHP_EOL;
                return null;
            }

        $props = $reflection->getProperties();
        foreach ($props as $property) {
            $attributes = $property->getAttributes();
            foreach($attributes as $attribute) {
                $propertyName = $property->name;
                $validator = $attribute->newInstance()->getValidator();
                $validator($class->$propertyName, $propertyName);
            }
        }

        return (array) $class;
        } catch (Error | SitemapException $e) {
            if (!$e instanceof SitemapException) {
                echo $e . PHP_EOL;
            } else {
                echo $e->getInfo() . PHP_EOL;
            }
            return null;
        }
    }

}




