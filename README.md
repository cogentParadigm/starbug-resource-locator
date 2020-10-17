# Resource Locator

The ResourceLocator class locates files and classes within list of modules. The modules passed to ResourceLocator must pre-ordered, as this package does not provide dependency resolution / topological sorting.

Basic example:

```php
use Starbug\ResourceLocator\ResourceLocator;

$modules = [
  "Starbug\Core" => "core",
  "Starbug\Log" => "modules/log",
  "Starbug\State" => "modules/state",
  "Starbug\Var" => "var"
]

$locator = new ResourceLocator(dirname(__FILE__), $modules);

// This will return "modules/log"
$locator->get("Starbug\Log");

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
