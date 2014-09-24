<?php
/**
 * fbInfo
 *
 * Returns the spicific field for a facebook fanpage (via the graph api)
 *
 * @author vanchelo <brezhnev.ivan@yahoo.com>
 * @version 1.0.2 - 2012-05-10
 *
 * OPTIONS
 * id - the facebook id of your fanpage
 * expiretime - lifetime of the cache in seconds (default: "10800", 3 hours)
 * field - Specific page field
 *
 * EXAMPLE
 * [!fbInfo? &id=`19110642979` &expiretime=`10800` &field=`likes`!]
 *
 * fbInfo is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * fbInfo is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 */

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

require_once 'fbcache.class.php';
$fbCache = FbCache::instance();

if (!$page = $fbCache->get($namespace, $id, $expiretime)) {
	require_once 'functions.inc.php';
	$graphdata = fileGetContents("http://graph.facebook.com/{$id}");
	$page = json_decode($graphdata, true);

	if (!$page || !is_array($page)) {
		return 'Data currently not available.';
	}

	$fbCache->put($page, $namespace, $id);
}

return isset($page[$field]) ? $page[$field] : '';
