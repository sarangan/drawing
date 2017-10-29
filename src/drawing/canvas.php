<?php

/**
 * canvas
 */
class Canvas {

  public $width;
  public $height;
  public $pixels;

  function __construct($w, $h){
    $this->width = $w;
    $this->height = $h;
    $this->pixels = array();

    $this->createNewBoard();
  }

  //create an empty board
  public function createNewBoard(){

    for($i = 0; $i < $this->height; $i++){
      for($j = 0; $j < $this->width; $j++){
        $this->pixels[$i][$j] = " ";
      }
    }

  }

  public function draw(){

    for($i = 0; $i < $this->height + 2; $i++){ // +2 top and bottom lines
      if($i == 0 || $i == $this->height + 1){
        for($j = 0; $j < $this->width + 2; $j++){
           echo " - ";
        }
        echo "\n";
      }
      else{
       for($j = 0; $j < $this->width + 2; $j++){
          if($j == 0 || $j == $this->width + 1){
            echo " | ";
          }
          else{
            echo " ".$this->pixels[$i-1][$j-1]." ";
          }
       }
       echo "\n";
     }
    }

  }

  public function validateLine($x1, $y1, $x2, $y2){
    if($x1 == $x2 || $y1 == $y2){
      return true;
    }
    else{
      return false;
    }
  }

  public function validateLineBounds($x1, $y1, $x2, $y2){
    if($x1 <= $this->width && $x2 <= $this->width && $y1 <= $this->height && $y2 <= $this->height){
      return true;
    }
    else{
      return false;
    }

  }

  public function drawLine($x1, $y1, $x2, $y2){

    for($i = 0; $i < $this->width; $i++){
      for($j = 0; $j < $this->height; $j++){
        if($i>= $x1-1 && $i <= $x2-1 && $j>= $y1-1 && $j <= $y2-1){
          $this->pixels[$j][$i] = "x";
        }
      }
    }

    $this->draw();

  }


  public function validateRect($x1, $y1, $x2, $y2){
    if($x1 < $x2 && $y1 < $y2){
      return true;
    }
    else{
      return false;
    }
  }

  public function drawRect($x1, $y1, $x2, $y2){
    for($i = $y1-1; $i <= $y2-1; $i++){
      if($i == $y1-1 || $i == $y2-1){
        for($j = $x1-1; $j <= $x2-1; $j++){
          $this->pixels[$i][$j] = "x";
        }
      }
      else{
       for($j = $x1-1; $j <= $x2-1; $j++){
          if($j == $x1-1 || $j == $x2-1){
            $this->pixels[$i][$j] = "x";
          }
       }
     }
   }

   $this->draw();

 }

 public function validatePoints($x, $y){
   if($x >= 1 && $x <= $this->width && $y >= 1 && $y <= $this->height){
     return true;
   }
   else{
     return false;
   }
 }

 public function fillArea($x, $y,  $replacement_color) {

     if($x < 1 || $y < 1 || $x > $this->width || $y > $this->height){
       return;
     }

     if($this->pixels[$y-1][$x-1] != " "){
       return;
     }

     $this->pixels[$y-1][$x-1] = $replacement_color;

     $this->fillArea($x-1, $y,  $replacement_color);
     $this->fillArea($x+1, $y,  $replacement_color);
     $this->fillArea($x, $y-1,  $replacement_color);
     $this->fillArea($x, $y+1,  $replacement_color);
  }



}


?>
