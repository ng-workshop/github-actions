import { arrayToString } from '../utils/formatter'
import { getPlanetIds, getPlanetNames } from '../utils/planet'

const planetChoices = {
    validate: value => getPlanetIds().includes(value),
    message: `The planet you selected is not a valid choice. The possible choices are ${arrayToString(getPlanetNames())}`
}

export { planetChoices }
