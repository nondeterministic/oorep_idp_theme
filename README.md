# A SimpleSAMLphp theme for OOREP

This module provides the `oorepnew` theme for SimpleSAMLphp 2.x.

## Installation

Copy the `oorepmodule` directory into your SimpleSAMLphp `modules/` directory.

Enable the module and theme in `config/config.php`:

```php
'module.enable' => [
    // ...
    'oorepmodule' => true,
],

'theme.use' => 'oorepmodule:oorepnew',
'theme.controller' => '\SimpleSAML\Module\oorepmodule\controller',
```

The theme controller is a Jinja2 template (`src/controller.php.j2`) in this repo because it is rendered by Ansible with deployment-specific URLs. For a manual install, copy it to `src/controller.php` and replace the template variables.
