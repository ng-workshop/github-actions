import { arrayToString, dateToString, capitalize } from '@/utils/formatter'

describe('test "formatter" package', () => {
    describe('test "arrayToString" function', () => {
        test('test format array to string with array of one element', () => {
            const array = ['element-1']

            expect(arrayToString(array)).toEqual('"element-1"')
        })

        test('test format array to string with array of two element', () => {
            const array = ['element-1', 'element-2']

            expect(arrayToString(array)).toEqual('"element-1" and "element-2"')
        })

        test('test format array to string with array of three element', () => {
            const array = ['element-1', 'element-2', 'element-3']

            expect(arrayToString(array)).toEqual('"element-1", "element-2" and "element-3"')
        })

        test('test format array to string with array of five element', () => {
            const array = ['element-1', 'element-2', 'element-3', 'element-4', 'element-5']

            expect(arrayToString(array))
                .toEqual('"element-1", "element-2", "element-3", "element-4" and "element-5"')
        })
    })

    describe('test "dateToString" function', () => {
        test('test format date object when dateObject params is null', () => {
            expect(dateToString(null)).toEqual(undefined);
        })

        test('test format date object to string (UTC)', () => {
            const dateObject = {
                "date": "2022-01-14 14:54:00.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }

            expect(dateToString(dateObject)).toEqual('Jan 14, 2022, 2:54:00 PM')
        })

        test('test format date object to string (EST)', () => {
            const dateObject = {
                "date": "2022-01-14 14:54:00.000000",
                "timezone_type": 3,
                "timezone": "EST"
            }

            expect(dateToString(dateObject)).toEqual('Jan 14, 2022, 9:54:00 AM')
        })
    })

    describe('test "capitalize" function', () => {
        test('test to format a lowercase string to capitalize string', () => {
            expect(capitalize('capitalize')).toEqual('Capitalize')
        })

        test('test to format a lowercase string to capitalize string with null value', () => {
            expect(capitalize(null)).toEqual('')
        })
    })
})
