<?php
/**
 * Luna plugin utilities.
 *
 * A class to place any functionality which alters or extends plugin functionality.
 * Most of these should be done using hooks defined within a plugin.
 *
 * @package luna
 */

/**
 * Luna plugin utils class.
 */
final class Luna_Plugin_Utils extends Luna_Base_Plugin_Utils {
  /**
   * Instantiation.
   * Call the parent's construct which contains a number of hooks for ACF, yoast etc.
   */
  public function __construct() {
    // Instantiate the base plugin utils.
    parent::__construct();
  }
}
