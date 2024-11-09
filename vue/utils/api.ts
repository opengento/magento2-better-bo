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
export const _apiResult = (axios: any, message: boolean = true, reload: boolean = false) => {
    return axios
        .then((response: any) => {
            const data = JSON.parse(response.data)
            message ? _message(data) : null

            // if (reload) {
            //     _loading()
            //     location.reload()
            // }

            return data
        })
        .catch((error: any) => {
            _catch(error)
        })
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

/**
 * Standard catch message
 * 
 * @param error 
 */
export const _catch = (error: any) => {
    _message({
        status: 'error',
        message: error.message
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