Facebook page info for MODX Evolution
======

##Setup
1. Copy this repository contents into your website folder
2. Create snippet `fbInfo` with this content:
```php
<?php
return require MODX_BASE_PATH . 'assets/snippets/fbinfo/fbinfo.snippet.php';
?>
```

##Sample Usage
```
Name: [[fbInfo? &id=`nailtone` &field=`name`]]<br>
Link: [[fbInfo? &id=`nailtone` &field=`link`]]<br>
Likes: [[fbInfo? &id=`nailtone` &field=`likes`]]
```

####Output
```
Name: Nail Tone Studio
Link: https://www.facebook.com/nailtone
Likes: 2106
```

Vkontakte groups info for MODX Evolution
======

##Setup
1. Copy this repository contents into your website folder
2. Create snippet `fbInfo` with this content:
```php
<?php
return require MODX_BASE_PATH . 'assets/snippets/fbinfo/vbinfo.snippet.php';
?>
```

##Sample Usage
```
<div>Name: [[vkInfo? &id=`mymodx` &field=`name`]]</div>
<div>Members: [[vkInfo? &id=`mymodx` &field=`members_count`]]</div>
<div>Link: [[vkInfo? &id=`mymodx` &field=`site`]]</div>
<div>Photos: [[vkInfo? &id=`mymodx` &field=`counters.photos`]]</div>
<div>Img: [[vkInfo? &id=`mymodx` &field=`photo_200`]]</div>
```

####Output
```
Name: MODx Evolution & Revolution
Members: 14426
Link: http://mymodx.ru
Photos: 24
Img: http://cs10975.vk.me/g25408690/d_3d206b56.jpg
```
