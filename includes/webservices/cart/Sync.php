<?php

namespace webservices\cart;

class Sync extends \WebService {

    private static function &get_group($groupname) {
        foreach ($_SESSION['cart']['groups'] as &$group) {
            if ($group['name'] == $groupname)
                return $group;
        }
        $x = null;
        return $x;
    }

    public function execute($querydata) {
        session_start();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array('all' => array(), 'groups' => array());
        }

        if (isset($querydata['action']) && isset($querydata['action']['action']))
            switch ($querydata['action']['action']) {
                case 'addGroup':
                    $newname = $querydata['action']['name'];
                    if (self::get_group($newname) != null)
                        break;
                    $_SESSION['cart']['groups'][] = array('name' => $newname, 'items' => array());
                    break;
                case 'renameGroup':
                    $newname = $querydata['action']['newname'];
                    $oldname = $querydata['action']['oldname'];
                    $group = &self::get_group($oldname);
                    if (self::get_group($newname) != null || $group == null)
                        break;
                    $group['name'] = $newname;
                    break;
                case 'addItemToAll':
                    $item = $querydata['action']['item'];
                    if (self::array_in_array($item, $_SESSION['cart']['all']))
                        break;
                    $_SESSION['cart']['all'][] = $item;
                    break;
                case 'addItemToGroup':
                    $item = $querydata['action']['item'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    if (!self::array_in_array($item, $_SESSION['cart']['all']))
                        break;
                    if (self::array_in_array($item, $group))
                        break;
                    $group['items'][] = $item;
                    break;
                case 'removeItemFromGroup':
                    $item = $querydata['action']['item'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    if (!self::array_in_array($item, $group['items']))
                        break;
                    $group['items'] = self::array_diff_rec($group['items'], array($item));
                    break;
                case 'removeItemFromAll':
                    $item = $querydata['action']['item'];
                    if (!self::array_in_array($item, $_SESSION['cart']['all']))
                        break;
                    $_SESSION['cart']['all'] = self::array_diff_rec($_SESSION['cart']['all'], array($item));

                    foreach ($_SESSION['cart']['groups'] as &$group) {
                        if (!self::array_in_array($item, $group['items']))
                            continue;
                        $group['items'] = self::array_diff_rec($group['items'], array($item));
                    }
                    break;
                case 'resetCart':
                    $_SESSION['cart'] = array('all' => array(), 'groups' => array());
                    break;
            }

        return array('syncTime' => isset($querydata['syncRequestTime']) ? $querydata['syncRequestTime'] : -1, 'cart' => $_SESSION['cart']);
    }

    /*
     * in_array either checks string representation or exact match (which wants exact key order). 
     * this function allows for different key order in $needle and $straw
     */

    private static function array_in_array($needle, $haystack) {
        foreach ($haystack as $straw) {
            // see array equality http://php.net/manual/en/language.operators.array.php
            if ($straw == $needle)
                return true;
        }
        return false;
    }

    private static function array_diff_rec($first, $second) {
        $ret = array();
        foreach ($first as $f) {
            if (!self::array_in_array($f, $second))
                $ret[] = $f;
        }
        return $ret;
    }

}

?>
