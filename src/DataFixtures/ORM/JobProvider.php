<?php
namespace App\DataFixtures\ORM;

use Faker\Provider\Base as BaseProvider;

final class JobProvider extends BaseProvider
{
    // same function as Entity slugify
    public function slugify($text)
    {
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
      setlocale(LC_CTYPE, 'fr_FR');
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      $text = preg_replace('~[^-\w]+~', '', $text);
      $text = trim($text, '-');
      $text = preg_replace('~-+~', '-', $text);
      $text = strtolower($text);
      return $text;
    }

    public function genPassword($fakePwd)
    {
        return password_hash($fakePwd, PASSWORD_DEFAULT);
    }
}
