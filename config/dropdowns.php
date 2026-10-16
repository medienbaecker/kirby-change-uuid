<?php

use Kirby\Cms\Find;
use Kirby\Panel\Controller\Dropdown\FileSettingsDropdownController;
use Kirby\Panel\Controller\Dropdown\PageSettingsDropdownController;

$can = require __DIR__ . '/can.php';

$item = fn($model) => [
	'icon'     => 'key',
	'text'     => t('medienbaecker.change-uuid.label'),
	'dialog'   => $model->panel()->url(true) . '/changeUuid',
	'disabled' => !$can($model),
];

$append = function (array $items, array $newItem) {
	array_splice($items, -2, 0, [$newItem]);
	return $items;
};

return [
	// Site area
	'page' => [
		'pattern' => 'pages/(:any)',
		'options' => function (string $path) use ($item) {
			$page  = Find::page($path);
			$items = (new PageSettingsDropdownController(model: $page))->load();

			$result = [];
			foreach ($items as $key => $value) {
				$result[$key] = $value;
				if ($key === 'changeTemplate') {
					$result['changeUuid'] = $item($page);
				}
			}

			return $result;
		}
	],
	'page.file' => [
		'pattern' => '(pages/[^/]+)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append((new FileSettingsDropdownController(model: $file))->load(), $item($file));
		}
	],
	'site.file' => [
		'pattern' => '(site)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append((new FileSettingsDropdownController(model: $file))->load(), $item($file));
		}
	],

	// Users area
	'user.file' => [
		'pattern' => '(users/[^/]+)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append((new FileSettingsDropdownController(model: $file))->load(), $item($file));
		}
	],

	// Account area
	'account.file' => [
		'pattern' => '(account)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append((new FileSettingsDropdownController(model: $file))->load(), $item($file));
		}
	],
];
