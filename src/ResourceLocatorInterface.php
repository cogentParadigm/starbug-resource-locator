<?php
namespace Starbug\ResourceLocator;

interface ResourceLocatorInterface {
  /**
   * Set the list of namespaces for className lookups.
   *
   * @param array $namespaces The namespaces.
   */
  public function setNamespaces(array $namespaces);
  /**
   * Set the list of paths for file lookups.
   *
   * @param array $paths The paths.
   */
  public function setPaths(array $paths);
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
