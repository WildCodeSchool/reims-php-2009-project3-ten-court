<?php

namespace App\Service;

class Slugify
{
    /**
     * @param string $slug
     * @return string
     */
    public function generate(string $slug): string
    {

          $slug = preg_replace('~[^\pL\d]+~u', '-', $slug);
          $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug ?? '');
          $slug = preg_replace('~[^-\w]+~', '', $slug);
          $slug = trim($slug, '-');
          $slug = preg_replace('~-+~', '-', $slug);
          $slug = strtolower($slug ?? '');

        if (empty($slug)) {
            return 'n-a';
        }

        return $slug;
    }
}
