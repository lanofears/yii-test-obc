<?php

namespace app\components\text;

class TextHelper {
    private static $translate_matrix = [
        "й" => "i", "ц" => "c", "у" => "u", "к" => "k", "е" => "e", "н" => "n",
        "г" => "g", "ш" => "sh", "щ" => "shch", "з" => "z", "х" => "h", "ъ" => "",
        "ф" => "f", "ы" => "y", "в" => "v", "а" => "a", "п" => "p", "р" => "r",
        "о" => "o", "л" => "l", "д" => "d", "ж" => "zh", "э" => "e", "ё" => "e",
        "я" => "ya", "ч" => "ch", "с" => "s", "м" => "m", "и" => "i", "т" => "t",
        "ь" => "", "б" => "b", "ю" => "yu",
    ];

    public static function transliterate($text, $delimiter = '_') {
        $pattern = array_map(function($pattern) { return '/'.$pattern.'/iu'; }, array_keys(self::$translate_matrix));

        $text = preg_replace($pattern, array_values(self::$translate_matrix), $text);
        $text = preg_replace("/[^a-z0-9\/_|+ -]/iu", '', $text);
        $text = preg_replace("/[\/_|+ -]+/iu", $delimiter, $text);
        $text = strtolower($text);

        return $text;
    }

    public static function cut_text($text, $length) {
        return (mb_strlen($text) > $length) ? mb_substr($text, 0, $length - 3).'...' : $text;
    }

    public static function format_article($text) {
        return '<p>'.preg_replace('/[\n|\r]+/u', '</p><p>', $text).'</p>';
    }
}