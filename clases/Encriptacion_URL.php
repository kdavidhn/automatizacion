<?php

 class EncripURL {

  private static $Key = "abcdefghijklmnopqrstuvwxyz123456789";

  public static function encrypt ($string) {
     return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(EncripURL::$Key),
     $string, MCRYPT_MODE_CBC, md5(md5(Enigma::$Key))));
  }

  public static function decrypt ($string) {
     return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(EncripURL::$Key), 
     base64_decode($string), MCRYPT_MODE_CBC, md5(md5(Enigma::$Key))), "\0");
  }

}
?>
