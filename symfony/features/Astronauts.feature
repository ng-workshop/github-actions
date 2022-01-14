Feature:
  CRUD to astronauts

  Scenario: Call astronauts route
    When I send a 'GET' request to '/astronauts'
    Then The status code is 200
    Then The data is json
    Then The json data have 5 items
    Then Element 0 of the json data have 'username' = 'wilson'
    Then Element 0 of the json data have 'planet' = 'hq'
    Then Element 0 of the json data have 'email' = 'wilson@eleven-labs.com'
    Then Element 0 of the json data have 'avatar' = 'http://cdn.workshop-ci.local/planets/hq.png'

  Scenario: Call astronauts route to get the astronaut with id 2
    When I send a 'GET' request to '/astronauts/2'
    Then The status code is 200
    Then The data is json
    Then The json data have 'username' = 'rocket raccoon'
    Then The json data have 'planet' = 'raccoons-of-asgard'
    Then The json data have 'formattedPlanetName' = 'Raccoons of asgard'
    Then The json data have 'email' = 'rocket-raccoon@eleven-labs.com'
    Then The json data have 'avatar' = 'http://cdn.workshop-ci.local/planets/raccoons-of-asgard.png'

  Scenario: Call astronauts route to get the astronaut with id 6 (Not Found)
    When I send a 'GET' request to '/astronauts/6'
    Then The status code is 404
    Then The data is json
    When The json data have 'error' = 'The astronaut with id "6" is not found'

  Scenario: Create an astronaut
    When I send a 'POST' to '/astronauts/avatars' with file 'test.png'
    Then The status code is 201
    Then The data is json
    Then The json data have 'filename'
    And I send a 'POST' to '/astronauts' with json data and temporary astronaut avatar
"""
{
  "username": "new-astronaut",
  "planet": "hq",
  "email": "new-astronaut@eleven-labs.com",
  "avatar": "##TEMPORARY_ASTRONAUT_AVATAR##"
}
"""
    Then The data is json
    Then The status code is 201
    Then The json data have 'id' = 6
    Then The json data have 'username' = 'new-astronaut'
    Then The json data have 'planet' = 'hq'
    Then The json data have 'email' = 'new-astronaut@eleven-labs.com'
    Then The json data have 'avatar' = 'http://cdn.workshop-ci.local/astronauts/new-astronaut/avatar.png'

  Scenario: Call astronaut route to create new astronaut whit bad request
    When I send a 'POST' to '/astronauts' with json data
"""
{
  "username": "test",
  "planet": "bad-planet",
  "email": "bad-email",
  "avatar": "bad-avatar"
}
"""
    Then The data is json
    Then The status code is 400
    Then The response is a violation with
"""
{
  "errors": {
    "username": [
      "The property \"username\" is too short. It should have 5 characters or more."
    ],
    "planet": [
      "The planet you selected is not a valid choice. The possible choices are donut-factory, duck-invaders, hq, raccoons-of-asgard and schizo-cats."
    ],
    "email": [
      "This value is not a valid email address."
    ]
  }
}
"""

  Scenario: Call astronaut route to create new astronaut whit bad temporary astronaut avatar
    When I send a 'POST' to '/astronauts' with json data
"""
{
  "username": "new-astronaut_2",
  "planet": "hq",
  "email": "new-astronaut_2@eleven-labs.com",
  "avatar": "bad-avatar"
}
"""
    Then The data is json
    Then The status code is 500
    Then The response is a violation with
"""
{
  "error": "There is no temporary file with the name \"bad-avatar\"."
}
"""

  Scenario: Call astronauts route
    When I send a 'GET' request to '/astronauts'
    Then The status code is 200
    Then The data is json
    Then The json data have 6 items

  Scenario: Call astronaut route to partial update the astronaut with id 6
    When I send a 'PATCH' to '/astronauts/6' with json data
"""
{
  "username": "new-astronaut-updated",
  "email": "new-astronaut-updated@eleven-labs.com"
}
"""
    Then The data is json
    Then The status code is 200
    Then The json data have 'id' = 6
    Then The json data have 'username' = 'new-astronaut-updated'
    Then The json data have 'planet' = 'hq'
    Then The json data have 'email' = 'new-astronaut-updated@eleven-labs.com'

  Scenario: Call astronaut route to full update the astronaut with id 6
    When I send a 'POST' to '/astronauts/avatars' with file 'test.png'
    Then The status code is 201
    Then The data is json
    Then The json data have 'filename'
    And I send a 'PUT' to '/astronauts/6' with json data and temporary astronaut avatar
"""
{
  "username": "new-raccoon",
  "planet": "raccoons-of-asgard",
  "email": "new-raccoon@eleven-labs.com",
  "avatar": "##TEMPORARY_ASTRONAUT_AVATAR##"
}
"""
    Then The data is json
    Then The status code is 200
    Then The json data have 'id' = 6
    Then The json data have 'username' = 'new-raccoon'
    Then The json data have 'planet' = 'raccoons-of-asgard'
    Then The json data have 'formattedPlanetName' = 'Raccoons of asgard'
    Then The json data have 'email' = 'new-raccoon@eleven-labs.com'
    Then The json data have 'avatar' = 'http://cdn.workshop-ci.local/astronauts/new-raccoon/avatar.png'

  Scenario: Call astronauts route to get the astronaut with id 6
    When I send a 'GET' request to '/astronauts/6'
    Then The status code is 200
    Then The data is json
    Then The json data have 'username' = 'new-raccoon'
    Then The json data have 'planet' = 'raccoons-of-asgard'
    Then The json data have 'formattedPlanetName' = 'Raccoons of asgard'
    Then The json data have 'email' = 'new-raccoon@eleven-labs.com'
    Then The json data have 'avatar' = 'http://cdn.workshop-ci.local/astronauts/new-raccoon/avatar.png'

  Scenario: Call astronauts route to delete astronaut with di 6
    When I send a 'DELETE' request to '/astronauts/6'
    Then The status code is 204

  Scenario: Call astronauts route to get the astronaut with id 6 (Not Found)
    When I send a 'GET' request to '/astronauts/6'
    Then The status code is 404
    Then The data is json
    When The json data have 'error' = 'The astronaut with id "6" is not found'
