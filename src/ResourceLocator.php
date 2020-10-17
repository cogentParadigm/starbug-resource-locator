<?php
namespace Starbug\ResourceLocator;

class ResourceLocator implements ResourceLocatorInterface {

  protected $base_directory;
  protected $modules;

  public function __construct($base_directory = "", $modules = []) {
    $this->base_directory = $base_directory;
    $this->modules = $modules;
  }

  /**
   * {@inheritDoc}
   */
  public function get($mid) : string {
    return $this->modules[$mid];
  }

  /**
   * {@inheritDoc}
   */
  public function set($mid, $path) {
    $this->modules[$mid] = $path;
  }

  /**
   * {@inheritDoc}
   */
  public function locate($name, $scope = "templates") : array {
    if (!empty($scope)) $scope .= "/";
    $path = $scope.$name;
    $paths = [];
    foreach ($this->modules as $mid => $module_path) {
      $target = $this->base_directory."/".$module_path."/".$path;
      if (file_exists($target)) $paths[$mid] = $target;
    }
    return $paths;
  }

  /**
   * {@inheritDoc}
   */
  public function className($class, $suffix = false) : ?string {
    if (false === strpos($class, "\\")) {
      if (false !== $suffix) {
        $class = $class.$suffix;
      }
      $class = $this->formatClassName($class);
      for (end($this->modules); ($mid = key($this->modules)) !== null; prev($this->modules)) {
        if (class_exists($mid."\\".$class)) return $mid."\\".$class;
      }
    } else {
      return $class;
    }
    return false;
  }

  /**
   * Convert a name with underscores to camel case format
   *
   * @param string $className the name of a class
   *
   * @return string the camel case converted name
   */
  protected function formatClassName($className) {
    return str_replace(" ", "", ucwords(str_replace(["_", "-"], " ", $className)));
  }
}
