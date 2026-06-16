# HBG Component Library

This plugin is a [Municipio LTS](https://github.com/municipio-se/municipio-lts)
version of Helsingborg stad's
[Component Library plugin](https://github.com/helsingborg-stad/component-library).

## Fork Base

This LTS fork is based on upstream tag
[`4.11.6`](https://github.com/helsingborg-stad/component-library/tree/4.11.6),
commit
[`cf6f319d`](https://github.com/helsingborg-stad/component-library/commit/cf6f319d735a06a488741a1cd046ef38a5c732a9).

## Changes in this Fork

This LTS version includes important security enhancements and accessibility improvements. A comprehensive XSS protection framework has been implemented with TagSanitizer and ID sanitization to remove potentially harmful spaces from user input.

Accessibility has been significantly improved through fixes to aria attributes across multiple components including drawer menus, steppers, and removal of invalid aria-labelledby attributes. Icons are now decorative by default, and misleading alt text has been removed from subfooter logotypes.

New features include datalist support for form fields, the ability to override viewbox width in Brand components, and improved context handling for card tags. Navigation components now properly handle target attributes using null coalescing operators.

Various bugs have been fixed including issues with box blade templates, signature update time handling, and proper language loading when used as an MU plugin. The fork also includes updated package configurations and streamlined development workflows.

## Installation

1. Install the package:
   ```bash
   composer require municipio/wp-plugin-hbg-component-library
   ```
2. Activate the plugin in WordPress.
