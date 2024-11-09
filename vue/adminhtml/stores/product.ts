import { defineStore } from "pinia";
import axios from 'axios'
import { _apiResult, _message } from '@/vue/utils/api'

/**
 * Category store
 */
export const useProduct = defineStore('product', {
    state: () => {
        return {
            loading: true as boolean,
            values: [] as any,
            originalValues: [] as any,
            savedValues: [] as any,
            config: null as any,
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
                axios.post(`/rest/V1/betterbo/catalog/product/attributes`, {
                    entityId,
                    attributeCode
                })
            ).then((data: any) => {
                // console.log(data)
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
                axios.post(`/rest/V1/betterbo/catalog/product/attributes/save`, {
                    entityId,
                    attributeCode,
                    values: this._differentValues
                })
            ).then((data: any) => {
                this.loading = false
            })
        }
    }
})