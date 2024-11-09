// imports
import { createApp } from 'vue'
import Shimmer from 'vue3-shimmer';
import { createPinia } from 'pinia'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

import App from '@/vue/adminhtml/catalog/product/Attributes.vue'

import * as _ from 'lodash'

document.addEventListener('DOMContentLoaded', () => {

    createApp(App)
        .use(Shimmer)
        .use(createPinia())
        .use(ElementPlus)
        .mount('#product_attributes')

})