<?php
namespace AnnotationsExampleTests;
use AnnotationsExample\Annotations\Role;

class TestAnnotation
{
    /**
     * @Role(role="Admin")
     */
    public function testRoleAdmin()
    {

    }
}