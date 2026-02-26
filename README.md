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

By default, UUID changes are disabled for all users. You can enable them per user role, per blueprint, or globally.

### Per user role

Enable UUID changes for an entire role:

```yaml
# site/blueprints/users/admin.yml
permissions:
  pages:
    changeUuid: true
  files:
    changeUuid: true
```

> [!NOTE]
> The `changeUuid` permission must be set explicitly. Setting `pages: true` or `"*": true` won't affect it because Kirby's wildcard only covers core permissions, not ones added by plugins.

### Per blueprint

Enable UUID changes for a specific page type:

```yaml
# site/blueprints/pages/default.yml
options:
  changeUuid: true
```

Or control it per user role:

```yaml
options:
  changeUuid:
    admin: true
    "*": false
```

### Global default

Enable UUID changes for all pages, files and users by default:

```php
// site/config/config.php
return [
    'medienbaecker.change-uuid.defaultPermission' => true,
];
```

After enabling it globally, you can still disable it for specific user roles or blueprints as shown above.

## License

MIT
