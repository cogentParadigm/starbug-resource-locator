<?php
namespace Starbug\ResourceLocator;

class ResourceLocator implements ResourceLocatorInterface {

  protected $base_directory;
  protected $namespaces = [];
  protected $paths = [];

  public function __construct($base_directory = "") {
    $this->base_directory = $base_directory;
  }

  /**
   * {@inheritDoc}
   */
  public function setNamespaces(array $namespaces) {
    $this->namespaces = $namespaces;
  }

  /**
   * {@inheritDoc}
   */
  public function setPaths(array $paths) {
    $this->paths = $paths;
  }

  /**
   * {@inheritDoc}
   */
  public function locate($name, $scope = "templates") : array {
    if (!empty($scope)) $scope .= "/";
    $path = $scope.$name;
    $paths = [];
    foreach ($this->paths as $dir) {
      $target = $this->base_directory."/".$dir."/".$path;
      if (file_exists($target)) $paths[$dir] = $target;
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
      for ($i = count($this->namespaces) - 1; $i >= 0; $i--) {
        if (class_exists($this->namespaces[$i]."\\".$class)) return $this->namespaces[$i]."\\".$class;
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
