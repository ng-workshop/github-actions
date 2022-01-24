import { getPlanetIds, getPlanetNames, getPlanetSelectOptions } from '../../../src/utils'

describe('test "planet" module', () => {
    test('test "getPlanetIds" function', () => {
        expect(getPlanetIds()).toEqual(['donut-factory', 'duck-invaders', 'hq', 'raccoons-of-asgard', 'schizo-cats'])
    })

    test('test "getPlanetNames" function', () => {
        expect(getPlanetNames()).toEqual(['Donut Factory', 'Duck Invaders', 'HQ', 'Raccoons Of Asgard', 'Schizo Cats'])
    })

    test('test "getPlanetSelectOptions" function', () => {
        const options = [
            { value: null, text: 'Select astronaut planet' },
            { value: 'donut-factory', text: 'Donut Factory' },
            { value: 'duck-invaders', text: 'Duck Invaders' },
            { value: 'hq', text: 'HQ' },
            { value: 'raccoons-of-asgard', text: 'Raccoons Of Asgard' },
            { value: 'schizo-cats', text: 'Schizo Cats' },
        ]

        expect(getPlanetSelectOptions()).toEqual(options)
    })
})
