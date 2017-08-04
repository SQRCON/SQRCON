<?php
  
class steam
{
  private static $steamapi = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/";
  
  public static function getuser($id)
  {
    $content = json_decode(network::getRemoteContent(steam::$steamapi.'?key='.STEAM_APIKEY.'&steamids='.$id), true);
    if (isset($content['response']['players'][0])) {
      return $content['response']['players'][0];
    }
  }
}
  
?>