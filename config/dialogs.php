<?php

use Kirby\Cms\Find;

$dialog = require __DIR__ . '/dialog.php';

return [
	// Site area
	'page.changeUuid' => [
		'pattern' => 'pages/(:any)/changeUuid',
		...$dialog('page', fn(string $id) => Find::page($id)),
	],
	'page.file.changeUuid' => [
		'pattern' => '(pages/[^/]+)/files/(:any)/changeUuid',
		...$dialog('file', fn(string $parent, string $filename) => Find::file($parent, $filename)),
	],
	'site.file.changeUuid' => [
		'pattern' => '(site)/files/(:any)/changeUuid',
		...$dialog('file', fn(string $parent, string $filename) => Find::file($parent, $filename)),
	],

	// Users area
	'user.file.changeUuid' => [
		'pattern' => '(users/[^/]+)/files/(:any)/changeUuid',
		...$dialog('file', fn(string $parent, string $filename) => Find::file($parent, $filename)),
	],

	// Account area
	'account.file.changeUuid' => [
		'pattern' => '(account)/files/(:any)/changeUuid',
		...$dialog('file', fn(string $parent, string $filename) => Find::file($parent, $filename)),
	],
];
