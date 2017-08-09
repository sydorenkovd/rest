Feature: Programmer
  In order to battle projects
  As an API client
  I need to be able to create programmers and power them up

  Background:
    # Given the user "CowboyCfoder" exists


  Scenario: Validation errors
    Given I have the payload:
    """
    {
      "avatarNumber" : "2",
      "tagLine": "I'm from a test!"
    }
    """
    When I request "POST /api/programmers"
    Then the response status code should be 400
    And the following properties should exist:
    """
    type
    title
    errors
    """
    And the "errors.nickname" property should exist
    But the "errors.avatarNumber" property should not exist