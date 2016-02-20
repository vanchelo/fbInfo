<?php
/**
 * fbInfo
 *
 * Returns the spicific field for a facebook fanpage (via the graph api)
 *
 * @author  vanchelo <brezhnev.ivan@yahoo.com>
 * @version 1.0.0 - 2014-09-24
 *
 * OPTIONS
 * id - the facebook id of your page
 * expiretime - lifetime of the cache in seconds (default: "10800", 180 min, 3 hours)
 * field - Specific page field
 *
 * EXAMPLE
 * [!fbInfo? &id=`nailtone` &field=`likes`!]
 * [!fbInfo? &id=`nailtone` &expiretime=`10800` &field=`likes`!]
 *
 * fbInfo is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * fbInfo is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 */

require_once 'helpers.inc.php';
require_once 'fbcache.class.php';

// Page ID
$id = isset($id) ? (string) $id : null;
// Page field
$field = isset($field) ? (string) $field : null;
$expiretime = isset($expiretime) ? (int) $expiretime : 10800;
$namespace = 'fbinfo';

if (!$id) {
    return 'You need to specify the fanpage id (&id=`` parameter)!';
}

if (!$field) {
    return 'You need to specify the field (&field=`` parameter)!';
}

$cache = FbCache::instance();

if (!$page = $cache->get($namespace, $id, $expiretime)) {
    $response = fileGetContents("http://graph.facebook.com/{$id}");
    $page = json_decode($response, true);

    if (!$page || !is_array($page)) {
        return 'Data currently not available.';
    }

    $cache->put($page, $namespace, $id);
}

return array_get($page, $field, '');
