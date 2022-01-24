import { arrayToString, getPlanetIds, getPlanetNames } from '../utils'

const planetChoices = {
    validate: value => getPlanetIds().includes(value),
    message: `The planet you selected is not a valid choice. The possible choices are ${arrayToString(getPlanetNames())}`
}

export { planetChoices }
