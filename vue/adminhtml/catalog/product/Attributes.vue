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
            <el-form 
                label-position="top"
                ref="form"
            >
                <div v-for="attribute in attributes" :key="attribute.attribute_code">
                    <!-- {{ attribute }} -->
                    <div>
                        <el-text>
                            {{ attribute.store?.name }}
                        </el-text>
                    </div>
                    <el-form-item v-if="attribute" :label="attribute.store_view_id">
                        <!-- {{ attribute.value }} -->
                        <el-input v-if="config.type === 'string'" v-model="attribute.value" />
                        <el-select 
                            v-else-if="config.type === 'select' && config.options" 
                            v-model="attribute.value"
                            multiple
                        >
                            <el-option
                                v-for="item in config.options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select>
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
    const env = 'test'; // 'test' | 'prod'

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
            (env === 'test') ? _test() : _get()
            drawer.value = true;
        }
    };

    /**
     * Get attributes
     */
    const _get = () => {
        productStore.getAttributes(props.productId, attributeCode.value)
            .then(() => {
                // console.log(productStore.attributes);
                // attributes.value = productStore.attributes;
            });
    }

    /**
     * Post attributes
     */
    const _post = () => {
        productStore.postAttributes(props.productId, attributeCode.value, attributes.value)
            .then(() => {
                drawer.value = false;
            });
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