<?php
namespace AnnotationsExampleTests;

class AnnotationReaderTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        \Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
            'AnnotationsExample\Annotations',
            realpath(__DIR__ . '/../../src')
        );
    }

    public function testAnnotationReader()
    {
        $service = new \AnnotationsExample\Services\Annotation();
        $annotation = $service->readRoleAnnotation('\AnnotationsExampleTests\TestAnnotation', 'testRoleAdmin');

        $this->assertInstanceOf('\AnnotationsExample\Annotations\Role', $annotation);
        $this->assertEquals('Admin', $annotation->role);
    }
}