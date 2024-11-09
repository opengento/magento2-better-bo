import { defineStore } from "pinia";
import axios from 'axios'
import { _apiResult, _message, _ttl } from '@/vue/utils/api'

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
                const originalValue = state.originalValues.find((original: any) => original.storeViewId === currentValue.storeViewId);
                return originalValue?.value !== currentValue.value;
            }).map((value: any) => ({
                storeViewId: value.storeViewId,
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
        getAttributes(entityId: number, attributeCode: string) {
            this.loading = true
            _apiResult(
                axios({
                    url: `/rest/V1/betterbo/catalog/product/attributes`,   
                    method: 'POST',
                    data: {
                        entityId,
                        attributeCode,
                    },
                    // cache: {
                    //     ttl: _ttl(),
                    //     interpretHeader: false,
                    // }
                })
            ).then((data: any) => {
                this.values = data?.data?.values
                this.originalValues = JSON.parse(JSON.stringify(data?.data?.values))
                this.config = data?.data?.config
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

            return _apiResult(
                axios({
                    url: `/rest/V1/betterbo/catalog/product/attributes/save`,   
                    method: 'POST',
                    data: {
                        entityId,
                        attributeCode,
                        values: this._differentValues
                    },
                    // cache: {
                    //     ttl: _ttl(),
                    //     interpretHeader: false,
                    // }
                })
            ).then((data: any) => {
                console.log(data)
                this.loading = false
                this.successValues = JSON.parse(JSON.stringify(data.data.successValues))
                this.errorValues = JSON.parse(JSON.stringify(data.data.errorValues))
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

            _apiResult(
                axios({
                    url: `/rest/V1/betterbo/catalog/product/attributes/delete`,   
                    method: 'POST',
                    data: {
                        entityId,
                        attributeCode,
                        storeViewId,
                    },
                })
            ).then((data: any) => {
                console.log(data)
                this.errorLoading = false
            })
        }
    }
})