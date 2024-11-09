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
            <!-- {{ productStore.values }}
            {{ productStore.config }} -->
            <el-form 
                label-position="top"
                ref="form"
            >
                <div v-for="(attribute, index) in productStore.values" :key="attribute.storeViewId">
                    <!-- {{ attribute }} -->
                    <el-form-item :label="attribute.storeViewLabel">
                        <!-- {{ attribute.value }} -->
                        <el-input 
                            v-if="productStore.config?.type === 'text'" 
                            v-model="attribute.value"
                        />
                        <!-- <el-select 
                            v-else-if="productStore.config?.type === 'select' && productStore.config?.options" 
                            v-model="attribute.value"
                            value-key="value"
                            filterable
                        >
                            <el-option
                                v-for="item in productStore.config?.options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select> -->
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
                <el-button @click="drawer = false">cancel</el-button>
                <el-button type="primary" @click="_post()">save</el-button>
            </div>
        </template>
    </el-drawer>
</template>

<script setup lang="ts">

    import { ref, watch, onMounted, onUnmounted } from 'vue';
    import { useProduct } from '@/vue/adminhtml/stores/product';

    /**
     * Tests requests
     */
    import { getAttributes } from '@/vue/tests/requests';

    /**
     * Props from HTML
     */
    const mountEl = document.querySelector("#product_attributes");
    const props = Object.assign({}, (mountEl instanceof HTMLElement) ? mountEl.dataset : {}) as any;

    /**
     * Environment
     */
    // const env = ref<'test' | 'prod'>('prod');

    /**
     * Set data
     */
    const productStore = useProduct();
    const drawer = ref<boolean>(false);
    const attributeCode = ref<any>(null);
    const attributes = ref<any>(null);
    const config = ref<any>(null);
    const form = ref<any>(null);
    /**
     * Handle click
     * 
     * @param event 
     */
    const handleClick = (event: MouseEvent) => {
        const target = event.target as HTMLElement;
        if (target.dataset.attributeCode !== undefined && drawer.value === false) {
            console.log('ping')
            attributeCode.value = target.dataset.attributeCode;
            // (env === 'test') ? _test() : _get()
            _get()
            drawer.value = true;
        }
    };

    /**
     * Get attributes
     */
    const _get = () => {
        productStore.getAttributes(props.productId, attributeCode.value)
        form.value = productStore.values.reduce((acc: any, value: any) => {
            acc[value.storeViewId] = value.value;
            return acc;
        }, {});
    }

    /**
     * Post attributes
     */
    const _post = () => {
        // productStore.postAttributes(props.productId, attributeCode.value, attributes.value)
        //     .then(() => {
        //         drawer.value = false;
        //     });
    }

    /**
     * Setup observer after component is mounted
     */
    onMounted(() => {
        document.addEventListener('click', handleClick);
    });

    /**
     * Cleanup listener when component is unmounted
     */
    onUnmounted(() => {
        document.removeEventListener('click', handleClick);
    });


    /**
     * Test
     */
    const _test = () => {
        const _test = getAttributes(attributeCode.value, props.productId);
        console.log(_test);
        attributes.value = _test.return.data.values;
        config.value = _test.return.data.config;
        // console.log(attributes.value);
        // console.log(config.value);
    }

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