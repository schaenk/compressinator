compressinator
==============

Lightweight PHP class which generates compressed / minified CSS and JavaScript files


Usage
=====

```php
$compressinator = new Compressinator();

// compress css files
$compressinator->compressCss(
	'/home/me/workspace/css/',
	'/home/me/workspace/cached/compressed.css',
	array('ignore_me.css', 'me_as_well.css')
);

// compress js files
$compressinator->compressJs(
	'/home/me/workspace/js/',
	'/home/me/workspace/cached/compressed.js',
	array('ignore_me.js', 'me_as_well.js')
);
```

[![githalytics.com alpha](https://cruel-carlota.pagodabox.com/163f1c7a62aa2f702dd61082773a09d9 "githalytics.com")](http://githalytics.com/schaenk/compressinator)
