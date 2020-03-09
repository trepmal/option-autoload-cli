Feature: Option Autoload

  Scenario: Option Autoload
    Given a WP install

    When I run `wp option autoload list`
    Then STDOUT should contain:
      """
      siteurl
      """

    When I run `wp option autoload list no`
    Then STDOUT should contain:
      """
      blacklist_keys
      """
