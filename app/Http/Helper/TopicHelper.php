<?php

declare(strict_types = 1);

namespace App\Http\Helper;

Class TopicHelper
{
    public function setExcerpt(string $content, int $length): string
    {
        return substr($content, 0, $length) . '...';
    }

    public function slugify(string $string): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
    }
    
}