# Kirby Change UUID

Change UUIDs of pages and files directly from the [Kirby](https://getkirby.com/) Panel.

<img width="1070" height="850" alt="Image" src="https://github.com/user-attachments/assets/b16e3aea-33f3-4cad-b18e-d5ba352284fb" />

## Requirements

- Kirby 6+

For Kirby 5, use version 1.x from the `main` branch.

## Installation

### Composer

```
composer require medienbaecker/kirby-change-uuid
```

### Manual

Download and extract this repository to `/site/plugins/kirby-change-uuid`.

## Permissions

You can enable UUID changes per user role or per blueprint. Users with the built-in `admin` role, and roles with `"*": true`, can change UUIDs by default.

### Per user role

```yaml
# site/blueprints/users/editor.yml
permissions:
  medienbaecker.change-uuid:
    pages: true
    files: true
```

`medienbaecker.change-uuid: true` enables both. To turn it off for admins, set it to `false` in `site/blueprints/users/admin.yml`.

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
    editor: true
    "*": false
```

Blueprint options win over role permissions.

## Users

Kirby always uses the user ID as a user's UUID, so it can't be changed. You can change the UUIDs of user files.

## Upgrading from 1.x

- Move the role permissions to the plugin's own category:

  ```yaml
  # 1.x
  permissions:
    pages:
      changeUuid: true
    files:
      changeUuid: true

  # 6.x
  permissions:
    medienbaecker.change-uuid:
      pages: true
      files: true
  ```

  With `debug` on, a role blueprint that still uses the 1.x syntax throws an error on every Panel request, for every user.

- Admins can now change UUIDs by default.
- The `medienbaecker.change-uuid.defaultPermission` option is gone. Enable the permission per role instead.
- Blueprint `options: changeUuid` work as before.
- The user and account dropdowns no longer have a "Change UUID" item. It never changed anything, because Kirby always uses the user ID as a user's UUID.

## License

MIT
