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

####Output:
```
Name: Nail Tone Studio
Link: https://www.facebook.com/nailtone
Likes: 2106
```
