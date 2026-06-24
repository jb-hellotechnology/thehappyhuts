<?php
  $price = getPrice($_POST['nights'],$_POST['unit'],$_POST['arrival'],$_POST['pay']);
  echo $price;
?>