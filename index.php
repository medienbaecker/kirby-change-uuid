<?php

use Kirby\Cms\App as Kirby;
use Kirby\Data\Json;
use Kirby\Filesystem\Dir;
use Kirby\Filesystem\F;
use Kirby\Toolkit\A;
use Kirby\Uuid\Uuids;

$area = fn(array $keys) => function () use ($keys) {
	if (Uuids::enabled() === false) {
		return [];
	}

	$dropdowns = require __DIR__ . '/config/dropdowns.php';
	$dialogs   = require __DIR__ . '/config/dialogs.php';

	return [
		'dropdowns' => array_intersect_key($dropdowns, array_flip($keys)),
		'dialogs'   => array_intersect_key($dialogs, array_flip(array_map(fn($key) => $key . '.changeUuid', $keys))),
	];
};

Kirby::plugin('medienbaecker/change-uuid', [
	'permissions' => [
		'pages' => false,
		'files' => false,
	],
	'translations' => A::keyBy(
		A::map(
			Dir::read(__DIR__ . '/translations'),
			function ($file) {
				$translations = [];
				foreach (Json::read(__DIR__ . '/translations/' . $file) as $key => $value) {
					$translations["medienbaecker.change-uuid.{$key}"] = $value;
				}
				return A::merge(['lang' => F::name($file)], $translations);
			}
		),
		'lang'
	),
	'areas' => [
		'site'    => $area(['page', 'page.file', 'site.file']),
		'users'   => $area(['user.file']),
		'account' => $area(['account.file']),
	],
]);
