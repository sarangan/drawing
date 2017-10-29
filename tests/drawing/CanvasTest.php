<?php
require 'vendor/autoload.php';
require_once './src/drawing/canvas.php';

class CanvasTest extends PHPUnit_Framework_TestCase{

  private $canvas;

  public function setUp(){
    $this->canvas = new Canvas(20, 4);
  }

  public function testLine(){
    $this->assertTrue($this->canvas->validateLine(1, 2, 6, 2));
  }

  public function testLine1(){
    $this->assertTrue($this->canvas->validateLine(6, 3, 6, 3));
  }

  public function testLine2(){
    $this->assertTrue($this->canvas->validateLine(-3, 3, 5, 3));
  }

  public function testLineBounds(){
    $this->assertTrue($this->canvas->validateLineBounds(1, 1, 19, 1));
  }

  public function testRect1(){
    $this->assertTrue($this->canvas->validateRect(16, 1, 20, 3));
  }

  public function testRec2(){
    $this->assertFalse($this->canvas->validateRect(6, 6, 3, 3));
  }

  public function testRec3(){
    $this->assertFalse($this->canvas->validateRect(1, 3, -1, 5));
  }

  public function testRectDraw(){
    $this->canvas->createNewBoard();
    $this->canvas->drawRect(1, 1, 5, 5);
    $this->assertContains('x', $this->canvas->pixels[0][4]);
  }

  public function testFill(){
    $this->canvas->createNewBoard();
    $this->canvas->fillArea(10, 3, "o");
    $this->assertContains('o', $this->canvas->pixels[3][3]);
  }

}
 ?>
