# Resource Locator

The ResourceLocator class locates files and classes within directories and namespaces.

Basic example:

```php
use Starbug\ResourceLocator\ResourceLocator;

$namespaces = [
  "Starbug\Core",
  "Starbug\Log",
  "Starbug\State",
  "Starbug\Var"
]
$paths = [
  "core",
  "modules/log",
  "modules/state",
  "var"
]

$locator = new ResourceLocator(dirname(__FILE__));
$locator->setNamespaces($namespaces);
$locator->setPaths($paths);

// This will check each module for a file at the path
// "etc/config.json" and return an array of matches.
// For instance, if core and log both contained the file,
// we would get:
// [
//   "core/etc/config.json",
//   "modules/log/config.json"
// ]
$locator->locate("config.json", "etc");

// This will check each module namespace and return
// the first one with a class named AdminController.
// For example, Starbug\Log\AdminController.
$locator->className("admin", "Controller");
```
