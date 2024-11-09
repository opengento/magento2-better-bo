<template>
    <el-drawer 
        v-model="drawer" 
        direction="rtl" 
        size="60%" 
        id="product-attributes-drawer" 
        :title="`Values for ${attributeCode}`"
        :append-to-body="true"
        :lock-scroll="true" 
    >
        <template #default>
            <el-form label-position="top">
                <div v-for="(attribute, index) in productStore.values" :key="attribute.storeViewId">
                    <el-form-item 
                        :label="attribute.storeViewLabel"
                        :class="{ 
                            'error': _findStoreViewId(productStore.errorValues, attribute.storeViewId),
                            'success': _findStoreViewId(productStore.successValues, attribute.storeViewId),
                        }"
                    >
                        <el-input 
                            v-if="productStore.config?.type === 'text'" 
                            v-model="attribute.value"
                        />
                        <select 
                            class="el-select input-with-trash"
                            v-else-if="productStore.config?.type === 'select' && productStore.config?.options" 
                            @change="attribute.value = $event.target.value"
                        >
                            <option
                                v-for="item in productStore.config?.options"
                                :key="item.value"
                                :value="item.value"
                                :selected="item.value === attribute.value"
                            >
                                {{ item.label }}
                            </option>
                        </select>
                        <span @click="_delete(attributeCode, attribute.storeViewId)" class="trash-icon">
                            <unicon 
                                name="trash-alt" 
                                width="16" 
                                height="16" 
                                fill="white" 
                                class="cursor-pointer"
                            />
                        </span>
                    </el-form-item>
                </div>
            </el-form>
        </template>
        <template #footer>
            <div style="flex: auto">
                <el-button @click="drawer = false">
                    Cancel
                </el-button>
                <el-button type="primary" @click="_post()" :loading="productStore.loading">
                    Save
                </el-button>
            </div>
        </template>
    </el-drawer>
</template>

<script setup lang="ts">

    import { ref, onMounted, onUnmounted } from 'vue';
    import { useProduct } from '@/vue/adminhtml/stores/product';

    /**
     * Props from HTML
     */
    const mountEl = document.querySelector("#product_attributes");
    const props = Object.assign({}, (mountEl instanceof HTMLElement) ? mountEl.dataset : {}) as any;

    /**
     * Set data
     */
    const productStore = useProduct();
    const drawer = ref<boolean>(false);
    const attributeCode = ref<string|null>(null);

    /**
     * Handle click
     * 
     * @param event 
     */
    const handleClick = (event: MouseEvent) => {
        const target = event.target as HTMLElement;
        if (target.dataset.attributeCode !== undefined && drawer.value === false) {
            attributeCode.value = target.dataset.attributeCode;
            _get()
            drawer.value = true;
        }
    };

    /**
     * Get attributes
     */
    const _get = () => {
        productStore.getAttributes(props.productId, attributeCode.value)
    }

    /**
     * Post attributes
     */
    const _post = () => {
        productStore.postAttributes(props.productId, attributeCode.value, productStore.values)
            ?.then((data: any) => {
                // console.log(data)
                // drawer.value = false
            })
    }

    /**
     * Delete attribute
     */
    const _delete = (attributeCode: string, storeViewId: number) => {
        productStore.deleteAttribute(props.productId, attributeCode, storeViewId)
    }

    /**
     * Find in array
     * 
     * @param array 
     * @param value 
     */
    const _findStoreViewId = (array: any[], storeViewId: number) => {
        return array.find((item: any) => item.storeViewId === storeViewId)
    }

    /**
     * Setup observer after component is mounted
     */
    onMounted(() => {
        document.addEventListener('click', handleClick)
    });

    /**
     * Cleanup listener when component is unmounted
     */
    onUnmounted(() => {
        document.removeEventListener('click', handleClick)
    });

</script>

<style lang="scss">
    .el-select {
        width: 100%;
        border: 1px solid var(--el-border-color);
        background-color: var(--el-input-bg-color,var(--el-fill-color-blank));
        border-radius: var(--el-input-border-radius,var(--el-border-radius-base));
        padding: 0 10px;
        height: 32px;
        &:focus {
            border-color: var(--el-color-primary);
            outline: 0;
        }
        &.saved {
            background-color: var(--el-color-success);
        }
    }
    // .input-with-trash .el-input-group__prepend {
    //     background-color: var(--el-color-error);
    // }
    .trash-icon {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        // background-color: var(--el-color-error);
        background-color: #e6e6e6;
        border-radius: var(--el-input-border-radius,var(--el-border-radius-base));
        width: 30px;
        display: grid;
        align-content: center;
        justify-content: center;
        padding-bottom: 2px;
        padding-left: 1px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        &:hover {
            background-color: var(--el-color-error);
        }
    }
</style>
