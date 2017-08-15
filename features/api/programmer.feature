Feature: Programmer
  In order to battle projects
  As an API client
  I need to be able to create programmers and power them up

  Background:
    # Given the user "CowboyCfoder" exists


  Scenario: Error response on invalid JSON
    Given I have the payload:
    """
    {
      "avatarNumber" : "2
      "tagLine": "I'm from a test!"
    }
    """
    When I request "POST /api/programmers"
    Then the response status code should be 400