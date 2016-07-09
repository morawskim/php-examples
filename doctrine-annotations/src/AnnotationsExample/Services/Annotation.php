<?php

namespace AnnotationsExample\Services;

use AnnotationsExample\Annotations\Role;
use Doctrine\Common\Annotations\AnnotationReader;

class Annotation
{
    /**
     * @param $className
     * @param $methodName
     * @return null|Role
     * @throws \Exception
     */
    public function readRoleAnnotation($className, $methodName)
    {
        $reflectionObj = new \ReflectionObject(new $className);
        $method = $reflectionObj->getMethod($methodName);

        $reader = new AnnotationReader();
        $annotation = $reader->getMethodAnnotation($method, '\AnnotationsExample\Annotations\Role');
        if(!$annotation) {
            throw new \Exception(sprintf('Entity class %s does not have required annotation Role', $className));
        }

        return $annotation;
    }
}