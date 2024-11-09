/**
 * Get attributes data
 * 
 * @param code 
 * @param entityId 
 * 
 * @returns 
 */
export const data = (code: string = 'name', entityId: number = 1, type: string = 'string') => {
    if (code === 'visibility') {
        console.log('visibility');
        type = 'select';
    }
    return {
        "payload": {
            "attribute_code": code,
            "entity_id": entityId
        },
        "return": {
            "type": "success",
            "message": "Retrieved attribute successfully",
            "data": {
                "config": {
                    "type": type,
                    "options": type === 'select' ? _options : null
                },
                "values": [
                    {
                        "store_view_id": "0",
                        "value": _value(type)
                    },
                    {
                        "store_view_id": "1",
                        "value": _value(type)
                    }
                ]
            }
        }
    }
}

const _value = (type: string) => {
    return type === 'select' ? "9991" : 'test string value';
}

const _options = [
    {
        "value": "",
        "label": ""
    },
    {
        "value": "999",
        "label": "Default option label"
    },
    {
        "value": "9991",
        "label": "Option 1"
    },
    {
        "value": "9992",
        "label": "Option 2"
    },
    {
        "value": "9993",
        "label": "Option 3"
    }
]