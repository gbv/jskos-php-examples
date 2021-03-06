<?php

use Symfony\Component\Yaml\Yaml;
use JSKOS\Item;
use JSKOS\Page;

class ServicesTest extends PHPUnit_Framework_TestCase {

    protected $services;

    protected function setUp() {
        $services = Yaml::parse(file_get_contents('src/services.yaml'));
        foreach ($services as $service) {
            $class = $service['CLASS'].'Service';
            if (!file_exists("src/lib/$class.php")) return;
            include_once "src/lib/$class.php";            
            $serviceInstance = new $class();
            $this->assertInstanceOf($class, $serviceInstance, "created $class");
            $service['INSTANCE'] = $serviceInstance;
            $this->services[$class] = $service;
        } 
    }

    public function testExamples() {
        foreach ($this->services as $class => $service) {
            echo "testing $class\n";

            $response = $service['INSTANCE']->query([]);
            $this->assertTrue( 
                is_null($response) or $response instanceof Page, 
                "$class name can be queried"
            );

            if (isset($service['SECRET'])) continue;

            if (isset($service['EXAMPLES'])) {
                foreach($service['EXAMPLES'] as $example) {
                    echo "  ?".http_build_query($example)."\n";
                    $response = $service['INSTANCE']->query($example);
                    // expect non-empty result
                    $this->assertTrue($response instanceof Item or
                      ($response instanceof Page and $response->totalCount > 0));
                }
            } else {
                $response = $service['INSTANCE']->query([]);
            }
        }
    }

}
