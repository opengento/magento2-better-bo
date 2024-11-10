import { defineStore } from "pinia";
import axios from 'axios'
import { _axios, _message, _catch } from '@/vue/utils/api'

/**
 * Category store
 */
export const useProduct = defineStore('product', {
    state: () => {
        return {
            values: [] as any,
            originalValues: [] as any,
            successValues: [] as any,
            errorValues: [] as any,
            config: null as any,

            // bearer: localStorage.getItem('token') as string,
            bearer: null as unknown as string,

            loading: true as boolean,
            errorLoading: false as boolean,
        }
    },
    getters: {
        /**
         * Get the different values
         * 
         * @returns 
         */
        _differentValues(state: any) {
            return state.values.filter((currentValue: any) => {
                console.log(currentValue)
                const originalValue = state.originalValues.find((original: any) => original.store_view_id === currentValue.store_view_id);
                return originalValue?.value !== currentValue.value;
            }).map((value: any) => ({
                store_view_id: value.store_view_id,
                value: value.value
            }))
        }
    },
    actions: {
        /**
         * Get the cart
         * 
         * @param storeId 
         * 
         * @returns 
         */
        async getAttributes(entityId: number, attributeCode: string) {
            this.loading = true
            this.successValues = []
            this.errorValues = []
        
            return axios({ // Return the promise
                url: `/rest/V1/betterbo/catalog/product/attributes`,   
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${this.bearer}`
                },
                data: {
                    entityId,
                    attributeCode,
                }
            }).then((response: any) => {
                const data = response.data
                this.values = data.data.values
                this.originalValues = JSON.parse(JSON.stringify(data.data.values))
                this.config = data.data.config
                this.loading = false
            }).catch((error: any) => {
                _catch(error)
                this.loading = false
            })
        },
        /**
         * Post the attributes
         * 
         * @param entityId 
         * @param attributeCode 
         * @param values 
         */
        postAttributes(entityId: any, attributeCode: string) {

            if (this._differentValues.length === 0) {
                _message({
                    status: 'warning',
                    message: 'No changes to save'
                })
                return
            }

            this.loading = true

            return axios({
                url: `/rest/V1/betterbo/catalog/product/attributes/save`,   
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${this.bearer}`
                },
                data: {
                    entityId,
                    attributeCode,
                    values: this._differentValues
                }
            }).then((response: any) => {
                const data = response.data
                this.loading = false
                this.successValues = data?.data?.success
                this.errorValues = data?.data?.error

                if (this.successValues.length > 0) {
                    _message({
                        status: 'success',
                        message: `Values saved for ${this.successValues.length} stores`
                    })
                }

                if (this.errorValues.length > 0) {
                    _message({
                        status: 'error',
                        message: `Values not saved for ${this.errorValues.length} stores`
                    })
                }
            }).catch((error: any) => {
                _catch(error)
                this.loading = false
            })
        },
        /**
         * Delete attribute
         * 
         * @param entityId 
         * @param attributeCode 
         * @param storeViewId 
         */
        deleteAttribute(entityId: number, attributeCode: string, storeViewId: number) {
            this.errorLoading = true

            axios({
                url: `/rest/V1/betterbo/catalog/product/attributes/delete`,   
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${this.bearer}`
                },
                data: {
                    entityId,
                    attributeCode,
                    storeViewId
                }
            }).then((response: any) => {
                const data = response.data
                this.errorLoading = false
            }).catch((error: any) => {
                _catch(error)
                this.errorLoading = false
            })
        }
    }
})