# Kirby Change UUID

Change UUIDs of pages, files and users directly from the [Kirby](https://getkirby.com/) Panel.

<img width="1070" height="850" alt="Image" src="https://github.com/user-attachments/assets/b16e3aea-33f3-4cad-b18e-d5ba352284fb" />

## Requirements

- Kirby 5+

## Installation

### Composer

```
composer require medienbaecker/kirby-change-uuid
```

### Manual

Download and extract this repository to `/site/plugins/kirby-change-uuid`.

## Permissions

### Per blueprint

Disable UUID changes for a specific page type:

```yaml
# site/blueprints/pages/default.yml
options:
  changeUuid: false
```

Or control it per user role:

```yaml
options:
  changeUuid:
    admin: true
    "*": false
```

### Per user role

Restrict UUID changes for an entire role across all pages:

```yaml
# site/blueprints/users/editor.yml
permissions:
  pages:
    changeUuid: false
```

### Global default

Change the default for all pages, files and users that don't specify a `changeUuid` option:

```php
// site/config/config.php
return [
    'medienbaecker.change-uuid.defaultPermission' => false,
];
```

## License

MIT
