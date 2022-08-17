<?php

use Mesvoisins\Plugin;

 /**
  * Plugin Name: MesVoisins
  * Author: Farrah et Simon
  * Version: 0.0.1
  * Description: Plugin pour le site Mesvoisins

  */

  //* Autoload
  require __DIR__ . "/vendor-mesvoisins/autoload.php";

  // * Entry point
  define("MESVOISINS_ENTRY_FILE",__FILE__);

  // * Plugin class
  $mesvoisins = new Plugin();


?>