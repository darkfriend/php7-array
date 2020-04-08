<?php

namespace darkfriend\helpers;

/**
 * Class ArrayHelper
 * @package darkfriend\devhelpers
 * @author darkfriend <hi@darkfriend.ru>
 * @version 1.0.1
 */
class ArrayHelper
{
    /**
     * Check value exists in an array.
     * Highload method searches haystack for needle.
     * @param string $needle
     * @param array $haystack
     * @return bool
     */
    public static function in_array($needle, $haystack)
    {
        $newHaystack = [];
        foreach (\array_values($haystack) as $v) {
            $newHaystack[$v] = true;
        }
        return isset($newHaystack[$needle]);
    }

    /**
     * Check multiple array
     * @param array $arr
     * @return bool
     */
    public static function isMulti($arr)
    {
        if (!\is_array($arr)) return false;
        $arr = \current($arr);
        return isset($arr) && \is_array($arr);
    }

    /**
     * Sort values array to order array
     * @param array $source - source array
     * @param array $orderArray - order array
     * @param callable|null $callback - callable algorithm
     * @return array
     */
    public static function sortValuesToArray($source, $orderArray, $callback = null)
    {
        if (!$callback) {
            $callback = function ($a, $b, $orderArray) {
                $keyCurrent = \array_search($a, $orderArray);
                $keyNext = \array_search($b, $orderArray);
                if (!isset($keyNext) && !isset($keyCurrent)) return -1;
                if ($keyCurrent == $keyNext) return 0;
                return ($keyCurrent > $keyNext) ? 1 : -1;
            };
        }
        \usort($source, function ($a, $b) use ($orderArray, $callback) {
            return $callback($a, $b, $orderArray);
        });
        return $source;
    }

    /**
     * Sort keys source array to order array
     * @param array $source - source array
     * @param array $orderArray - order array
     * @param callable|null $callback - callable algorithm
     * @return array
     */
    public static function sortKeysToArray($source, $orderArray, $callback = null)
    {
        if (!$callback) {
            $callback = function ($a, $b, $orderArray) {
                $keyCurrent = \array_search($a, $orderArray);
                $keyNext = \array_search($b, $orderArray);
                if (!isset($keyNext) && !isset($keyCurrent)) return -1;
                return \strcasecmp($keyCurrent, $keyNext);
            };
        }
        \uksort($source, function ($a, $b) use ($orderArray, $callback) {
            return $callback($a, $b, $orderArray);
        });
        return $source;
    }

    /**
     * Check includes keys in $sourceArray
     * @param array $arKeys
     * @param array $sourceArray
     * @return bool
     * @since 1.0.1
     */
    static public function keysExists(array $arKeys, array $sourceArray): bool
    {
        return !array_diff_key(array_flip($arKeys), $sourceArray);
    }

    /**
     * Remove key from array
     * @param array $source source array
     * @param array $keys keys for remove
     * @param bool $negative flag for remove all except for $keys
     * @return array
     * @since 1.0.1
     */
    public static function removeByKey(array $source, array $keys, bool $negative = false): array
    {
        if(!$source || !$keys) return $source;

        return \array_filter($source,function($key) use ($keys, $negative) {
            if(\in_array($key,$keys)) {
                if($negative) {
                    return true;
                }
                return false;
            }
            if($negative) {
                return false;
            }
            return true;
        },\ARRAY_FILTER_USE_KEY);
    }

    /**
     * Remove item from array by value
     * Удаление элементов массива по зачениям
     * @param array $source source array
     * @param array $values values for remove
     * @param bool $negative flag for remove all except for $values
     * @return array
     * @since 1.0.1
     */
    public static function removeByValue(array $source, array $values, bool $negative = false): array
    {
        if(!$source || !$values) return $source;

        return \array_filter($source,function($value) use ($values, $negative) {
            if(\in_array($value, $values)) {
                if($negative) {
                    return true;
                }
                return false;
            }
            if($negative) {
                return false;
            }
            return true;
        },0);
    }
}