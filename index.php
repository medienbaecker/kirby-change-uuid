<?php

use Kirby\Cms\App as Kirby;
use Kirby\Data\Json;
use Kirby\Filesystem\Dir;
use Kirby\Filesystem\F;
use Kirby\Toolkit\A;

$pick = fn(array $array, array $keys) =>
array_intersect_key($array, array_flip($keys));

Kirby::plugin('medienbaecker/change-uuid', [
	'options' => [
		'defaultPermission' => false,
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
		'site' => function () use ($pick) {
			$dropdowns = require __DIR__ . '/config/dropdowns.php';
			$dialogs   = require __DIR__ . '/config/dialogs.php';

			return [
				'dropdowns' => $pick($dropdowns, ['page', 'page.file', 'site.file']),
				'dialogs'   => $pick($dialogs, ['page.changeUuid', 'page.file.changeUuid', 'site.file.changeUuid']),
			];
		},
		'users' => function () use ($pick) {
			$dropdowns = require __DIR__ . '/config/dropdowns.php';
			$dialogs   = require __DIR__ . '/config/dialogs.php';

			return [
				'dropdowns' => $pick($dropdowns, ['user', 'user.file']),
				'dialogs'   => $pick($dialogs, ['user.changeUuid', 'user.file.changeUuid']),
			];
		},
		'account' => function () use ($pick) {
			$dropdowns = require __DIR__ . '/config/dropdowns.php';
			$dialogs   = require __DIR__ . '/config/dialogs.php';

			return [
				'dropdowns' => $pick($dropdowns, ['account', 'account.file']),
				'dialogs'   => $pick($dialogs, ['account.changeUuid', 'account.file.changeUuid']),
			];
		},
	],
]);
