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
                    <el-form-item :label="attribute.storeViewLabel">
                        <el-input 
                            v-if="productStore.config?.type === 'text'" 
                            v-model="attribute.value"
                        />
                        <select 
                            class="el-select"
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
                    </el-form-item>
                </div>
            </el-form>
        </template>
        <template #footer>
            <div style="flex: auto">
                <el-button @click="drawer = false">
                    Cancel
                </el-button>
                <el-button type="primary" @click="_post()">
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
        height: 40px;
        border: 1px solid lightgrey;
        border-radius: 5px;
        padding: 0 10px;
        &:focus {
            border-color: #409EFF;
            outline: 0;
        }
    }
</style>