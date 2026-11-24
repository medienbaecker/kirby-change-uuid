<?php

use Kirby\Cms\App;
use Kirby\Cms\Language;
use Kirby\Exception\DuplicateException;
use Kirby\Exception\PermissionException;
use Kirby\Toolkit\I18n;
use Kirby\Uuid\Uuid;

$can = require __DIR__ . '/can.php';

return function (string $scheme, callable $findModel) use ($can) {
	return [
		'load' => function (string ...$args) use ($scheme, $findModel, $can) {
			$model = $findModel(...$args);

			if ($can($model) === false) {
				throw new PermissionException(I18n::translate('medienbaecker.change-uuid.permission'));
			}

			$fallback = Uuid::generate();

			return [
				'component' => 'k-form-dialog',
				'props'     => [
					'fields' => [
						'uuid' => [
							'label'       => 'UUID',
							'type'        => 'text',
							'before'      => $scheme . '://',
							'font'        => 'monospace',
							'placeholder' => $fallback,
						],
						'fallback' => [
							'type' => 'hidden',
						],
						'warning' => [
							'type'  => 'info',
							'theme' => 'negative',
							'text'  => I18n::translate('medienbaecker.change-uuid.warning'),
						],
					],
					'submitButton' => I18n::translate('change'),
					'value'        => [
						'uuid'     => $model->content()->get('uuid')->value(),
						'fallback' => $fallback,
					],
				],
			];
		},
		'submit' => function (string ...$args) use ($scheme, $findModel, $can) {
			$model = $findModel(...$args);

			if ($can($model) === false) {
				throw new PermissionException(I18n::translate('medienbaecker.change-uuid.permission'));
			}

			$request = App::instance()->request();
			$newUuid = trim($request->get('uuid', ''));

			if (empty($newUuid)) {
				$newUuid = $request->get('fallback', Uuid::generate());
			}

			$existing = Uuid::from($scheme . '://' . $newUuid)->model();

			if ($existing !== null && $existing->is($model) === false) {
				throw new DuplicateException(I18n::translate('medienbaecker.change-uuid.duplicate'));
			}

			$language = Language::ensure('default');

			if ($model->version('changes')->exists($language) === true) {
				$model->version('changes')->update(['uuid' => $newUuid], $language);
			}

			$model->uuid()->clear();
			$model->update(['uuid' => $newUuid], $language->code());
			App::instance()->cache('uuid')->flush();

			return [
				'event' => 'model.update',
			];
		},
	];
};
