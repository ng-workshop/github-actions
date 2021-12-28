Feature:
  CRUD to astronauts

  Scenario: Add temporary avatar
    When I send a 'POST' to '/astronauts/avatars' with file 'test.png'
    Then The status code is 201
    Then The data is json
    Then The json data have 'filename'
    Then Cache response

  Scenario: Remove temporary avatar
    When I send a 'DELETE' to '/astronauts/avatars/{filename}' replacing the values in path with the last cached json response
    Then The status code is 200
