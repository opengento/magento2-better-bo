// imports
import { createApp } from 'vue'
import Shimmer from 'vue3-shimmer';
import { createPinia } from 'pinia'

import App from '@/vue/adminhtml/catalog/product/Attributes.vue'

import * as _ from 'lodash'

document.addEventListener('DOMContentLoaded', () => {

    createApp(App)
        .use(Shimmer)
        .use(createPinia())
        .mount('#product_attributes')

})