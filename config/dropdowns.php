<?php

use Kirby\Cms\Find;

$item = fn ($url) => [
	'icon'   => 'key',
	'text'   => t('medienbaecker.change-uuid.label'),
	'dialog' => $url . '/changeUuid',
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
					$result['changeUuid'] = $item($page->panel()->url(true));
				}
			}

			return $result;
		}
	],
	'page.file' => [
		'pattern' => '(pages/[^/]+)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append($file->panel()->dropdown(), $item($file->panel()->url(true)));
		}
	],
	'site.file' => [
		'pattern' => '(site)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append($file->panel()->dropdown(), $item($file->panel()->url(true)));
		}
	],

	// Users area
	'user' => [
		'pattern' => 'users/(:any)',
		'options' => function (string $id) use ($item, $append) {
			$user = Find::user($id);
			return $append($user->panel()->dropdown(), $item($user->panel()->url(true)));
		}
	],
	'user.file' => [
		'pattern' => '(users/[^/]+)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append($file->panel()->dropdown(), $item($file->panel()->url(true)));
		}
	],

	// Account area
	'account' => [
		'pattern' => '(account)',
		'options' => function (string $id) use ($item, $append) {
			$user = Find::user($id);
			return $append($user->panel()->dropdown(), $item($user->panel()->url(true)));
		}
	],
	'account.file' => [
		'pattern' => '(account)/files/(:any)',
		'options' => function (string $parent, string $filename) use ($item, $append) {
			$file = Find::file($parent, $filename);
			return $append($file->panel()->dropdown(), $item($file->panel()->url(true)));
		}
	],
];
