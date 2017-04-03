<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordCloudController extends Controller
{
 
  public function createWordCloudString($wordList, $searchTerm, $scholarOrKeyword){
    $wordCloudString = "";
    $startingATag = "<a style='color:";
    $fontSizeString = "; font-size:";
    $linkString = "px;' href='http://localhost:8000/list/" . $scholarOrKeyword . "/";
    $colors = array("red", "blue", "green", "purple", "yellow", "black", "orange", "gray", "brown", "magenta", "skyblue", "forestgreen", "aliceblue", "salmon");
    $idTagString = "' id='word";

    $shuffled_array = array();
    $shuffled_keys = array_keys($wordList);
    shuffle($shuffled_keys);
    foreach ($shuffled_keys as $shuffled_key){
      $shuffled_array[$shuffled_key] = $wordList[$shuffled_key];
    }

    $i=0;
    foreach ($shuffled_array as $key => $value){
      $i++;
      $color = $colors[array_rand($colors, 1)];
      //echo $color;
      $fontSize = $value * 6;
      if ($fontSize > 40) $fontSize = 40;
      if ($fontSize < 12) $fontSize = 10;
      $toAdd = $startingATag . $color . $fontSizeString . $fontSize . $linkString . $searchTerm. "/" . $key . $idTagString . $i . "'> " . $key . " </a>";
      $wordCloudString = $wordCloudString . $toAdd;
    }

    return $wordCloudString;
  }
}
