<?php

use Kirby\Cms\App;
use Kirby\Cms\File;
use Kirby\Cms\ModelWithContent;
use Kirby\Cms\Page;

return function (ModelWithContent $model): bool {
	$category = match (true) {
		$model instanceof Page => 'pages',
		$model instanceof File => 'files',
	};

	// guards only read role permissions from the model's own category,
	// so the plugin's category is passed in as the fallback
	$role = App::instance()->user()?->role()->permissions()->for('medienbaecker.change-uuid', $category) ?? false;

	return $model->guards()->isAvailable('changeUuid', $role);
};
