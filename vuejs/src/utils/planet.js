const PLANETS = {
    'donut-factory': {
        name: 'Donut Factory',
    },
    'duck-invaders': {
        name: 'Duck Invaders',
    },
    'hq': {
        name: 'HQ',
    },
    'raccoons-of-asgard': {
        name: 'Raccoons Of Asgard',
    },
    'schizo-cats': {
        name: 'Schizo Cats',
    },
}

export const getPlanetIds = () => Object.keys(PLANETS)

export const getPlanetNames = () => Object.values(PLANETS).map(planet => planet.name)

export const getPlanetSelectOptions = () => {
    const ids = Object.keys(PLANETS)
    const options = [
        { value: null, text: 'Select astronaut planet' }
    ]

    for (const id of ids) {
        options.push({ value: id, text: PLANETS[id].name })
    }

    return options
}

export default { getPlanetIds, getPlanetNames, getPlanetSelectOptions }
