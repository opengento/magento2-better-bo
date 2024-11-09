/**
 * @fileoverview Message
 * 
 * @version 1.0.0
 * 
 * @author Alexandre Buleté <bulete.alexandre@gmail.com>
 */

import { ElMessage, ElLoading } from 'element-plus'
import 'element-plus/es/components/message/style/css'

/**
 * Open full screen loading
 *
 * @param message 
 * 
 * @returns 
 */
export const _loading = (message: string|null = null) => {
    return ElLoading.service({
        lock: true,
        text: message || 'Loading...',
    })
}

/**
 * An axios wrapper to handle API result
 * @param axios 
 * @param message 
 * @returns 
 */
export const _apiResult = (axios: any, message = true, reload = false) => {
    return axios
        .then((response: any) => {
            const data = JSON.parse(response.data)
            message ? _message(data) : null

            // console.log(data)
            
            // if (reload) {
            //     _loading()
            //     location.reload()
            // }

            return data
        })
        .catch((error: any) => {
            console.error(error)
        })
}

/**
 * Cache delay
 * 
 * @returns 
 */
export const _ttl = () => {
    return (30 * 60 * 1000)
}

/**
 * After cart update
 * 
 * @param data 
 * @returns 
 */
export const _message = (data: any) => {
    data?.message 
        ? ElMessage({
            message: data?.message,
            type: data?.status || 'success'
        }) 
        : null
}