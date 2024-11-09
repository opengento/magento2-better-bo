// imports
import { createApp } from 'vue'
import Shimmer from 'vue3-shimmer';
import { createPinia } from 'pinia'

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import Unicon from 'vue-unicons/dist/vue-unicons.umd.js'

import { 
    uniTrashAlt
} from 'vue-unicons/dist/icons'

Unicon.add([
    uniTrashAlt
])

import App from '@/vue/adminhtml/catalog/product/Attributes.vue'

import * as _ from 'lodash'

document.addEventListener('DOMContentLoaded', () => {

    createApp(App)
        .use(Shimmer)
        .use(createPinia())
        .use(ElementPlus)
        .use(Unicon, {
            fill: '#000',
            width: 24,
            height: 24
        })
        .mount('#product_attributes')

})