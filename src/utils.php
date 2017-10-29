<?php
require_once('drawing/canvas.php');

class Utils {

  //check if its command line
  function isConsole() {
      return (php_sapi_name() === 'cli' OR defined('STDIN'));
  }

  //get commands from user
  function getCommand($message, $regex, &$command){

    echo($message);
    $user_input = fopen ('php://stdin','r');
    $command = trim(fgets($user_input), "\r\n");

    if($command === 'Q'){
      return false;
    }

    if (!preg_match($regex, $command)) {
      echo("Invalid Entry\n");
      return $this->getCommand($message, $regex, $command);
    } else {
        return true;
    }

  }

  //start command line
  function initCmd(&$command){
    $command = '';
    return $this->getCommand("Press any key to start painting!, write Q to quit: ", "/^[A-Za-z]{1}$/", $command);
  }

  //create new canvas
  function openCanvas(&$command){
    return $this->getCommand("enter command: ", "/^[C]{1} [0-9]{1,2} [0-9]{1,2}$/", $command);
  }

  function listenCommands(&$canvas, &$command){

    echo "enter command: ";
    $user_input = fopen ('php://stdin','r');
    $command = trim(fgets($user_input), "\r\n");

     if(preg_match("/^[C]{1} [0-9]{1,2} [0-9]{1,2}$/", $command)){ //create canvas
       $params = explode(" ", $command);
       $canvas = new Canvas(intval($params[1]), intval($params[2]));
       $canvas->draw();
       $this->listenCommands($canvas, $command);
     }
     else if(preg_match("/^[L]{1} [0-9]{1,2} [0-9]{1,2} [0-9]{1,2} [0-9]{1,2}$/", $command)){ //LINE
         $cords = explode(" ", $command);
         $x1 = intval($cords[1]);
         $y1 = intval($cords[2]);
         $x2 = intval($cords[3]);
         $y2 = intval($cords[4]);

         if($canvas->validateLine($x1, $y1, $x2, $y2)){
           if($canvas->validateLineBounds($x1, $y1, $x2, $y2)){
             $canvas->drawLine($x1, $y1, $x2, $y2);
           }
           else{
             echo "Line is out of canvas!\n";
           }
         }
         else{
           echo "Diagonal lines are not supported!\n";
         }

         $this->listenCommands($canvas, $command);
     }
     else if(preg_match("/^[R]{1} [0-9]{1,2} [0-9]{1,2} [0-9]{1,2} [0-9]{1,2}$/", $command)) { // RECT
         $cords = explode(" ", $command);
         $x1 = intval($cords[1]);
         $y1 = intval($cords[2]);
         $x2 = intval($cords[3]);
         $y2 = intval($cords[4]);

         if($canvas->validateRect($x1, $y1, $x2, $y2)){
           if($canvas->validateLineBounds($x1, $y1, $x2, $y2)){
             $canvas->drawRect($x1, $y1, $x2, $y2);
           }
           else{
             echo "Rectangle is out of canvas!\n";
           }
         }
         else{
           echo "invalid rectangle\n";
         }

         $this->listenCommands($canvas, $command);

     }
     else if(preg_match("/^[B]{1} [0-9]{1,2} [0-9]{1,2} [a-z]{1}$/", $command))
     {
         $cords = explode(" ", $command);
         $x = intval($cords[1]);
         $y = intval($cords[2]);
         $color = $cords[3];

         if($canvas->validatePoints($x, $y)){
           $canvas->fillArea(intval($cords[1]), intval($cords[2]),  $cords[3]);
           $canvas->draw();
         }
         else{
           echo "Point is out of canvas\n";
         }
         $this->listenCommands($canvas, $command);
     }
     else if(preg_match("/^[Q]{1}$/", $command)){
       echo "canvas closed\n";
     }
     else{
         echo "Invalid command\n";
         $this->listenCommands($canvas, $command);
     }

  }



}
?>
