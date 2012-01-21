<?php

require_once('/usr/share/pear/PHPUnit/Framework.php');
require_once('smarty/src/Smarty.class.php');

class SmartyFunctionAttrTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    $this->obj = new stdClass();
    $this->obj->active = true;
    $this->obj->url = "http://trulia.com/";
    $this->obj->status = 'open';
    
    $this->tpl = $tpl = new Smarty();
    
    $this->tpl->assign('obj', $this->obj);
  }
  
  public function test_that_non_boolean_attributes_are_parsed_as_is()
  {
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj class="status" href="url"}');
    $this->assertEquals('class="open" href="http://trulia.com/"', $attr_str);
  }
  
  public function test_boolean_property_dashized_for_class_attr()
  {
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj class="active" href="url"}');
    $this->assertEquals('class="is-active" href="http://trulia.com/"', $attr_str);
  }
  
  public function test_invalid_prop_returns_the_string_literal_as_the_attr_val()
  {
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj class="bullshit" href="whatup"}');
    $this->assertEquals('class="bullshit" href="whatup"', $attr_str);
  }
  
  public function test_alt_value_for_boolean_class_prop_is_used_when_provided()
  {
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj class="active:this-shit-is-live" href="url"}');
    $this->assertEquals('class="this-shit-is-live" href="http://trulia.com/"', $attr_str);
  }
  
  public function test_sort_option()
  {
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj href="url" class="active:this-shit-is-live"}');
    $this->assertEquals('href="http://trulia.com/" class="this-shit-is-live"', $attr_str);
    
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj href="url" class="active:this-shit-is-live" sort=true}');
    $this->assertEquals('class="this-shit-is-live" href="http://trulia.com/"', $attr_str);
  }
  
  public function test_newline_option()
  {
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj class="status" href="url" newline=true}');
    $this->assertEquals('class="open"' . "\n" . 'href="http://trulia.com/"', $attr_str);
  }
  
  public function test_enclose_option()
  {
    $attr_str = $this->tpl->fetch('string:' . '{attr target=$obj class="status" href="url" enclose="\'"}');
    $this->assertEquals('class=\'open\' href=\'http://trulia.com/\'', $attr_str);
  }
}

?>