<?php
namespace Starbug\ResourceLocator;

interface ResourceLocatorInterface {
  /**
   * Get the path for a specified module namespace
   *
   * @param string $namespace The namespace to lookup.
   *
   * @return string The path of the corresponding module.
   */
  public function get($namespace) : string;
  /**
   * Set the path for a specified module namespace.
   *
   * @param string $namespace The namespace.
   * @param string $path The path to the corresponding module.
   */
  public function set($namespace, $path);
  /**
   * Locate a file by name and module sub-directory.
   *
   * @param string $name the name of the file.
   * @param string $dir a sub-directory path.
   *
   * @return array file paths
   */
  public function locate($name, $dir = "etc") : array;
  /**
   * Locate a class by name or partial name.
   *
   * - The name will be appropriately formatted as a class name.
   *   For example, "product_options" will be converted to "ProductOptions".
   * - If name contains a namespace, it will be returned as is.
   * - If name does not contain a namespace, each registered
   *   module namespace will be checked in order, and the
   *   first one found will be returned.
   *
   * Examples:
   *  - className("admin") will check each namespace
   *    for a class named Admin.
   *  - className("admin", "Controller") will check each namespace
   *    for a class named AdminController.
   *  - className("Starbug\Controller\Admin", "Controller") will
   *    return Starbug\Controller\Admin.
   *
   * @param string $name The name segment to lookup.
   * @param string $suffix a suffix to add to the class name.
   *
   * @return string The fully qualified class name.
   */
  public function className($class, $suffix = false) : ?string;
}
