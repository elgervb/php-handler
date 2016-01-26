<?php
namespace handler\view;

/**
 *
 * @author eaboxt
 *        
 */
class ViewHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testHandleString() {
        $expected = "test-string";
        
        $handler = new ViewHandler();
        $actual = $handler->handle($expected);
        
        $this->assertEquals($expected, $actual);
    }
}
