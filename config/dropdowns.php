<?php

use Kirby\Cms\Find;

$item = fn($model) => [
	'icon'     => 'key',
	'text'     => t('medienbaecker.change-uuid.label'),
	'dialog'   => $model->panel()->url(true) . '/changeUuid',
	'disabled' => !$model->permissions()->can('changeUuid', option('medienbaecker.change-uuid.defaultPermission', false)),
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
			$items = $page->panel()->dropdown();

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
			return $append($file->panel()->dropdown(), $item($file));
		}
	],
	'site.file' => [
		'pattern' => '(site)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append($file->panel()->dropdown(), $item($file));
		}
	],

	// Users area
	'user' => [
		'pattern' => 'users/(:any)',
		'options' => function (string $id) use ($item, $append) {
			$user = Find::user($id);
			return $append($user->panel()->dropdown(), $item($user));
		}
	],
	'user.file' => [
		'pattern' => '(users/[^/]+)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append($file->panel()->dropdown(), $item($file));
		}
	],

	// Account area
	'account' => [
		'pattern' => '(account)',
		'options' => function (string $id) use ($item, $append) {
			$user = Find::user($id);
			return $append($user->panel()->dropdown(), $item($user));
		}
	],
	'account.file' => [
		'pattern' => '(account)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append($file->panel()->dropdown(), $item($file));
		}
	],
];
