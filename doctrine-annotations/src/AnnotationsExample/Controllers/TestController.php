<?php

namespace AnnotationsExample\Controllers;
use AnnotationsExample\Annotations\Role;

class TestController
{
    /**
     * @Role(role="user")
     */
    public function testAnnotation()
    {

    }

    /**
     * @Role(role="admin")
     */
    public function testAnnotation2()
    {

    }
}