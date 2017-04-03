<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordCloudController extends Controller
{
 
  public function createWordCloudString($wordList, $artistId){
    $wordCloudString = "";
    $startingATag = "<a style='color:";
    $fontSizeString = "; font-size:";
    $linkString = "px;' href='http://localhost:8000/api/songlist/";
    $colors = array("red", "blue", "green", "purple", "yellow", "black", "orange", "gray", "brown", "magenta", "skyblue", "forestgreen", "aliceblue", "salmon");

    $shuffled_array = array();
    $shuffled_keys = array_keys($wordList);
    shuffle($shuffled_keys);
    foreach ($shuffled_keys as $shuffled_key){
      $shuffled_array[$shuffled_key] = $wordList[$shuffled_key];
    }

    foreach ($shuffled_array as $key => $value){
      $color = $colors[array_rand($colors, 1)];
      //echo $color;
      $fontSize = $value * 6;
      if ($fontSize > 40) $fontSize = 40;
      if ($fontSize < 12) $fontSize = 10;
      $toAdd = $startingATag . $color . $fontSizeString . $fontSize . $linkString . $key . "/" . $artistId . "'> " . $key . " </a>";
      $wordCloudString = $wordCloudString . $toAdd;
    }

    return $wordCloudString;
  }


   //
}
