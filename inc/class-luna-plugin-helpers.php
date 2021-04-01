<?php
/**
 * Luna plugin helpers.
 *
 * A class to place any functionality which alters or extends plugin functionality.
 * Most of these should be done using hooks defined within a plugin.
 *
 * @package luna
 */

/**
 * Luna plugin helpers class.
 */
final class Luna_Plugin_Helpers extends Luna_Base_Plugin_Helpers {
  /**
   * Instantiation.
   * Call the parent's construct which contains a number of hooks for ACF, yoast etc.
   */
  public function __construct() {
    // Instantiate the base plugin helpers.
    parent::__construct();
  }
}
