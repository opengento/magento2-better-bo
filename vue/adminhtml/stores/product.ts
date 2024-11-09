import { defineStore } from "pinia";
import axios from 'axios'
import { _apiResult } from '@/vue/utils/api'

/**
 * Category store
 */
export const useProduct = defineStore('product', {
    state: () => {
        return {
            loading: true as boolean,
            product: null as any,
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
        getAttributes(entityId: number, attributeCode: string) {
            this.loading = true
            _apiResult(
                axios.post(`/rest/V1/betterbo/catalog/product/attributes`, {
                    entityId,
                    attributeCode
                })
            ).then((data: any) => {
                console.log(data)
                this.attribute = data?.attribute
                this.loading = false
            }).catch((error: any) => {
                console.log(error)
            })
        },
        postAttributes(entityId: any, storeId: number, attributeCode: string, value: any) {
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