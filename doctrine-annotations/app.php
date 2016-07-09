<?php

require_once __DIR__ . '/vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'AnnotationsExample\Annotations',
    realpath('./src')
);

$className = '\AnnotationsExample\Controllers\TestController';
$reflectionClass = new ReflectionClass($className);

$service = new \AnnotationsExample\Services\Annotation();

foreach ($reflectionClass->getMethods() as $method) {
    /** @var \AnnotationsExample\Annotations\Role $annotation */
    $annotation = $service->readRoleAnnotation($className, $method->getName());
    printf("Method %s have assigned role: '%s' \n", $method->getName(), $annotation->role);
}
