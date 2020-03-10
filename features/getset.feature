Feature: Get and Set Option Autoload

  Scenario: Get and Set Option Autoload
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

    When I try `wp option autoload set home no`
    Then STDERR should contain:
      """
      Error: Option autoload already set to 'no'.
      """
    And the return code should be 1

    When I run `wp option autoload set home yes`
    And I run `wp option autoload get home --format=json`
    Then STDOUT should contain:
      """
      "yes"
      """

  Scenario: Set invalid options and autoload values
    Given a WP install

    When I try `wp option autoload set home invalid`
    Then STDERR should contain:
      """
      Error: Invalid <yn>. Please specify 'yes' or 'no'.
      """
    And the return code should be 1

    When I try `wp option autoload set alloptions no`
    Then STDERR should contain:
      """
      Error: alloptions is a protected WP option and may not be modified
      """
    And the return code should be 1

    When I try `wp option autoload set notanoption no`
    Then STDERR should contain:
      """
      Error: Option does not exist.
      """
    And the return code should be 1

    When I try `wp option autoload get notanoption`
    Then STDERR should contain:
      """
      Error: Option does not exist.
      """
    And the return code should be 1

