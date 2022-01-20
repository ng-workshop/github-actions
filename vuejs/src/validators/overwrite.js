const email = {
    message: 'You should add a valid email address',
}

const max = {
    length: 50,
    params: ['length'],
    message: 'The property "{_field_}" is too long. It should have {length} characters or less.',
}

const min = {
    length: 5,
    params: ['length'],
    message: 'The property "{_field_}" is too short. It should have {length} characters or more.',
}

const required = {
    message: 'The {_field_} is required.'
}

export { email, max, min, required }
