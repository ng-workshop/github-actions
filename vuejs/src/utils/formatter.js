export const arrayToString = data => {
    const countElements = data.length - 1
    let formattedString = ''

    for (let value of data) {
        switch(data.indexOf(value)) {
            case 0:
                formattedString += `"${value}"`
                break
            case countElements:
                formattedString += ` and "${value}"`
                break
            default:
                formattedString += `, "${value}"`
        }
    }
    return formattedString
}

export const dateToString = dateObject => {
    if (dateObject === null) {
        return
    }

    const date = new Date(dateObject.date)

    const formatter = new Intl.DateTimeFormat(
        'en-US',
        {
            timeZone: dateObject.timezone,
            dateStyle: 'medium',
            timeStyle: 'medium',
        });

    return formatter.format(date)
}

export const capitalize = value => {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1);
}

export default { arrayToString, dateToString, capitalize }
