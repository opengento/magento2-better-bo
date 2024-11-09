import { defineStore } from "pinia";
import axios from 'axios'
import { _apiResult } from '@boeki/vui/utils/toolBox'

/**
 * Category store
 */
export const useCart = defineStore('cart', {
    state: () => {
        return {
            loading: true as boolean,
            product: true as boolean,
            attribute: null as any
            // attributes: [] as any,
        }
    },
    getters: {
        //
    },
    actions: {
        /**
         * Get the cart
         * 
         * @param storeId 
         * 
         * @returns 
         */
        get(storeId: number) {
            _apiResult(
                axios.post(`/rest/V1/betterbo/catalog/product/attributes`, {
                    entityId,
                    attributeCode
                })
            ).then((data: any) => {
                console.log(data)
                this.attribute = data.attribute
                this.loading = false
            }).catch((error: any) => {
                console.log(error)
            })
        },
        put(attribute: any) {
            _apiResult(
                axios.post(`/rest/V1/betterbo/catalog/product/attributes`, {
                    entityId,
                    storeId,
                    attributeCode,
                    value
                })
            ).then((data: any) => {
                console.log(data)
            }).catch((error: any) => {
                console.log(error)
            })
        }
    }
})