Feature:
  CRUD to astronauts

  Scenario: Call astronauts route
    When I send a 'GET' request to '/astronauts/'
    Then The status code is 200
    Then The data is json
    Then The json data have 5 items
    Then Element 0 of the json data have 'username' = 'wilson'
    Then Element 0 of the json data have 'planet' = 'hq'
    Then Element 0 of the json data have 'email' = 'wilson@eleven-labs.com'
    Then Element 0 of the json data have 'avatar' = 'https://avatar.eleven-labs.com/wilson'

  Scenario: Call astronauts route o get the astronaut with id 2
    When I send a 'GET' request to '/astronauts/2'
    Then The status code is 200
    Then The data is json
    Then The json data have 'username' = 'rocket raccoon'
    Then The json data have 'planet' = 'raccoons of asgard'
    Then The json data have 'email' = 'rocket-raccoon@eleven-labs.com'
    Then The json data have 'avatar' = 'https://avatar.eleven-labs.com/rocket-raccoon'

  Scenario: Call astronauts route to get the astronaut with id 6 (Not Found)
    When I send a 'GET' request to '/astronauts/6'
    Then The status code is 404
    Then The data is json
    When The json data have 'error' = 'The astronaut with id "6" is not found'

  Scenario: Call astronaut route to create new astronaut
    When I send a 'POST' to '/astronauts/' with json data
"""
{
	"username": "new-astronaut",
	"planet": "hq",
	"email": "new-astronaut@eleven-labs.com",
	"avatar": "https://avatar.eleven-labs.com/new-astronaut"
}
"""
    Then The data is json
    Then The status code is 201
    Then The json data have 'id' = 6
    Then The json data have 'username' = 'new-astronaut'
    Then The json data have 'planet' = 'hq'
    Then The json data have 'email' = 'new-astronaut@eleven-labs.com'
    Then The json data have 'avatar' = 'https://avatar.eleven-labs.com/new-astronaut'

  Scenario: Call astronaut route to create new astronaut whit bad request
    When I send a 'POST' to '/astronauts/' with json data
"""
{
  "username": "test",
  "planet": "hq",
  "email": "test@eleven-labs.com",
  "avatar": "https://avatar.eleven-labs.com/test"
}
"""
    Then The data is json
    Then The status code is 400
    Then The response is a violation with
"""
{
  "error": {
    "username": [
      "the \"username\" must have a minimum size of 5 characters."
    ]
  }
}
"""

  Scenario: Call astronauts route
    When I send a 'GET' request to '/astronauts/'
    Then The status code is 200
    Then The data is json
    Then The json data have 6 items

  Scenario: Call astronaut route to partial update the astronaut with id 6
    When I send a 'PATCH' to '/astronauts/6' with json data
"""
{
  "username": "new-astronaut-updated",
  "email": "new-astronaut-updated@eleven-labs.com",
  "avatar": "https://avatar.eleven-labs.com/new-astronaut-updated"
}
"""
    Then The data is json
    Then The status code is 200
    Then The json data have 'id' = 6
    Then The json data have 'username' = 'new-astronaut-updated'
    Then The json data have 'planet' = 'hq'
    Then The json data have 'email' = 'new-astronaut-updated@eleven-labs.com'
    Then The json data have 'avatar' = 'https://avatar.eleven-labs.com/new-astronaut-updated'

  Scenario: Call astronaut route to full update the astronaut with id 6
    When I send a 'PUT' to '/astronauts/6' with json data
"""
{
  "username": "new-raccoon",
  "planet": "raccoons of asgard",
  "email": "new-raccoon@eleven-labs.com",
  "avatar": "https://avatar.eleven-labs.com/new-raccoon"
}
"""
    Then The data is json
    Then The status code is 200
    Then The json data have 'id' = 6
    Then The json data have 'username' = 'new-raccoon'
    Then The json data have 'planet' = 'raccoons of asgard'
    Then The json data have 'email' = 'new-raccoon@eleven-labs.com'
    Then The json data have 'avatar' = 'https://avatar.eleven-labs.com/new-raccoon'

  Scenario: Call astronauts route to get the astronaut with id 6
    When I send a 'GET' request to '/astronauts/6'
    Then The status code is 200
    Then The data is json
    Then The json data have 'username' = 'new-raccoon'
    Then The json data have 'planet' = 'raccoons of asgard'
    Then The json data have 'email' = 'new-raccoon@eleven-labs.com'
    Then The json data have 'avatar' = 'https://avatar.eleven-labs.com/new-raccoon'

  Scenario: Call astronauts route to delete astronaut with di 6
    When I send a 'DELETE' request to '/astronauts/6'
    Then The status code is 204

  Scenario: Call astronauts route to get the astronaut with id 6 (Not Found)
    When I send a 'GET' request to '/astronauts/6'
    Then The status code is 404
    Then The data is json
    When The json data have 'error' = 'The astronaut with id "6" is not found'
