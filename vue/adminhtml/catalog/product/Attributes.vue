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

                <div v-if="['textarea', 'texteditor'].includes(productStore.config?.type) && !productStore.config?.tinymceApiKey">
                    <el-alert title="TinyMCE API key is not set" type="error" />
                </div>

                <div 
                    v-for="(attribute, index) in productStore.values" :key="attribute.storeViewId"
                    class="drawer-row"
                >
                    <el-form-item 
                        :label="attribute.storeViewLabel"
                        :class="{ 
                            'test': true,
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
                        <div 
                            v-else-if="['textarea', 'texteditor'].includes(productStore.config?.type)" 
                            style="width: 100%;"
                        >
                            <editor
                                v-if="productStore.config?.tinymceApiKey || true"
                                v-model="attribute.value"
                                :api-key="productStore.config?.tinymceApiKey"
                                :init="_editorInit"
                            />
                        </div>
                        <select 
                            v-else-if="productStore.config?.type === 'multiselect' && productStore.config?.options"
                            class="el-select input-with-trash"
                            @change="attribute.value = $event.target.value"
                            multiple
                            >
                            <option
                                v-for="item in productStore.config?.options"
                                :key="item.value"
                                :value="item.value"
                                :selected="attribute.value.split(',').includes(item.value)"
                            >
                                {{ item.label }}
                            </option>
                        </select>
                        <el-popconfirm title="Are you sure to delete this?">
                            <template #reference>
                                <span class="trash-icon">
                                    <unicon 
                                        name="trash-alt" 
                                        width="16" 
                                        height="16" 
                                        fill="white" 
                                        class="cursor-pointer"
                                    />
                                </span>
                            </template>
                        </el-popconfirm>
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

    // import { useCookies } from '@vueuse/integrations/useCookies'
    import { ref, watch, onMounted, onUnmounted } from 'vue';
    import { useProduct } from '@/vue/adminhtml/stores/product';
    import { _editorInit } from '@/vue/utils/form';

    import Editor from '@tinymce/tinymce-vue'

    /**
     * Props from HTML
     */
    const mountEl = document.querySelector("#product_attributes");
    const props = Object.assign({}, (mountEl instanceof HTMLElement) ? mountEl.dataset : {}) as any;

    /**
     * Set data
     */
    const productStore = useProduct()
    const drawer = ref<boolean>(false)
    const attributeCode = ref<string|null>(null)

    const cookie = "eyJraWQiOiIxIiwiYWxnIjoiSFMyNTYifQ.eyJ1aWQiOjEsInV0eXBpZCI6MiwiaWF0IjoxNzMxMTk5NTQ0LCJleHAiOjE3MzEyMDMxNDR9.pLW6XJwesMJ3qxqqG_IVyW9SakhWbdAyZwIpyBD1iHg"
    productStore.bearer = cookie

    // Add watcher for drawer
    watch(drawer, (newValue) => {
        if (!newValue) { // When drawer is closed
            productStore.values = [] // Reset values
            attributeCode.value = null
        }
    })

    /**
     * Handle click
     * 
     * @param event 
     */
    const handleClick = async (event: MouseEvent) => {
        const target = event.target as HTMLElement;
        const parentWithAttribute = target.closest('[data-attribute-code]');
        
        if (parentWithAttribute && drawer.value === false) {
            attributeCode.value = parentWithAttribute.getAttribute('data-attribute-code');
            await _get() // Wait for _get to complete

            drawer.value = true;
        }
    };

    /**
     * Get attributes
     */
    const _get = async () => {
        await productStore.getAttributes(props.productId, attributeCode.value)
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
        return array.find((item: any) => item === storeViewId)
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
    .el-form-item .el-select {
        width: 100%;
        // border: 1px solid var(--el-border-color);
        border: none !important;
        box-shadow: 0 0 0 1px var(--el-input-border-color,var(--el-border-color)) inset;
        background-color: var(--el-input-bg-color,var(--el-fill-color-blank));
        border-radius: var(--el-input-border-radius,var(--el-border-radius-base));
        padding: 0 10px;
        &[multiple] {
            height: auto;
            option {
                padding: 3px;
            }
        }
        height: 32px;
        &:focus {
            border-color: var(--el-color-primary);
            outline: 0;
        }
        &.saved {
            background-color: var(--el-color-success);
        }
    }
    .el-form-item.success {
        .el-select, .el-input__wrapper {
            box-shadow: 0 0 0 1px var(--el-color-success) inset;
        }
        .tox-tinymce {
            border-color: var(--el-color-success);
        }
    }
    .el-form-item.error {
        .el-select, .el-input__wrapper, .tox-tinymce {
            box-shadow: 0 0 0 1px var(--el-color-error) inset;
        }
        .tox-tinymce {
            border-color: var(--el-color-error);
        }
    }
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
    .drawer-row {
        width: 100%;
        .tox-tinymce {
            width: calc(100% - 40px);
        }
    }
</style>
