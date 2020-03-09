Feature: Option Autoload

  Scenario: Option Autoload
    Given a WP install

    When I run `wp option autoload get home`
    Then STDOUT should contain:
      """
      yes
      """

    When I run `wp option autoload set home no`
    And I run `wp option autoload get home`
    Then STDOUT should contain:
      """
      no
      """

    When I try `wp option autoload set notanoption no`
    Then STDERR should contain:
      """
      Error: Option does not exist
      """
    And the return code should be 1

    When I try `wp option autoload get notanoption`
    Then STDERR should contain:
      """
      Error: Option does not exist
      """
    And the return code should be 1

