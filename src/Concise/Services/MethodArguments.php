<?php

namespace Concise\Services;

use ReflectionException;
use ReflectionMethod;

class MethodArguments
{
    public function getMethodArgumentValues(array $didReceive, $method)
    {
        try {
            $reflect = new ReflectionMethod($method);
            $params = $reflect->getParameters();
            for ($i = count($didReceive); $i < count($params); ++$i) {
                $didReceive[] = $params[$i]->getDefaultValue();
            }
        } catch (ReflectionException $e) {
            // Not sure how this should be handled, so let's ignore it for now.
        }
        return $didReceive;
    }
}
