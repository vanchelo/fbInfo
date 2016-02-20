<?php
/**
 * vkInfo
 *
 * Returns the spicific field for a vkontakte group (via VK API)
 *
 * @author  vanchelo <brezhnev.ivan@yahoo.com>
 * @version 1.0.0 - 2014-09-24
 *
 * OPTIONS
 * id - the vkontakte id of your group
 * expiretime - lifetime of the cache in seconds (default: "10800", 180 min, 3 hours)
 * field - Specific page field
 *
 * EXAMPLE
 * [!vkInfo? &id=`laravel_rus` &field=`members_count`!]
 * [!vkInfo? &id=`laravel_rus` &field=`counters.photos`!]
 * [!vkInfo? &id=`laravel_rus` &expiretime=`10800` &field=`members_count`!]
 *
 * vkInfo is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * vkInfo is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 */

require_once 'helpers.inc.php';
require_once 'fbcache.class.php';

// Group ID
$id = isset($id) ? (string) $id : null;
// Group field
$field = isset($field) ? $field : null;
$lang = isset($lang) ? (string) $lang : 'ru';
$expiretime = isset($expiretime) ? (int) $expiretime : 10800;
$namespace = 'vkInfo';

if (!$id) {
    return 'You need to specify the group id (&id=`` parameter)!';
}

if (!$field) {
    return 'You need to specify the field (&field=`` parameter)!';
}

$cache = FbCache::instance();

if (!$page = $cache->get($namespace, $id, $expiretime)) {
    $response = fileGetContents("http://api.vk.com/method/groups.getById?v=5.24&lang={$lang}&group_id={$id}&fields=city,country,place,description,wiki_page,members_count,counters,start_date,finish_date,can_post,can_see_all_posts,activity,status,contacts,links,fixed_post,verified,site");
    $response = json_decode($response, true);

    if (!$response || !is_array($response) || !isset($response['response'][0])) {
        return 'Data currently not available.';
    }

    $page = $response['response'][0];

    $cache->put($page, $namespace, $id);
}

return array_get($page, $field, '');
