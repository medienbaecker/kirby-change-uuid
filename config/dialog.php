<?php

use Kirby\Cms\App;
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
		'submit' => function (string ...$args) use ($findModel, $can) {
			$model = $findModel(...$args);

			if ($can($model) === false) {
				throw new PermissionException(I18n::translate('medienbaecker.change-uuid.permission'));
			}

			$request = App::instance()->request();
			$newUuid = trim($request->get('uuid', ''));

			if (empty($newUuid)) {
				$newUuid = $request->get('fallback', Uuid::generate());
			}

			$model->uuid()->clear();
			$model->update(['uuid' => $newUuid]);
			App::instance()->cache('uuid')->flush();

			return [
				'event' => 'model.update',
			];
		},
	];
};
