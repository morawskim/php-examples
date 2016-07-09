<?php

namespace AnnotationsExample\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Role extends Annotation
{
    public $role;
}