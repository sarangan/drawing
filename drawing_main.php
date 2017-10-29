<?php
require_once('./src/utils.php');
require_once('./src/drawing/canvas.php');

$utils = new Utils();

if(!$utils->isConsole()){
  echo "no command line available";
}
else{

  $command = '';

  if($utils->initCmd($command)){

    if($utils->openCanvas($command)){

      $params = explode(" ", $command);
      $canvas = new Canvas(intval($params[1]), intval($params[2]));
      $canvas->draw();

      $utils->listenCommands($canvas, $line);


    }
    else{
      echo "Could not open Canvas\n";
    }
  }
  else{
    echo "Acc-Paint closed\n";
  }

}



?>
