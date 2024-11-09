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
            values: [] as any,
            config: null as any,
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
                this.values = data?.data?.values
                this.config = data?.data?.config
                this.loading = false
            }).catch((error: any) => {
                console.log(error)
            })
        },
        /**
         * Post the attributes
         * 
         * @param entityId 
         * @param attributeCode 
         * @param values 
         */
        postAttributes(entityId: any, attributeCode: string, values: any) {
            _apiResult(
                axios.post(`/rest/V1/betterbo/catalog/product/attributes`, {
                    entityId,
                    attributeCode,
                    values
                })
            ).then((data: any) => {
                console.log(data)
            }).catch((error: any) => {
                console.log(error)
            })
        }
    }
})