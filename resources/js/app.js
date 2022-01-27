//загрузка глобальных переменных
require('gird-base-front/src/bootstrap');

// компонент приложения
Vue.component('app', require('./views/layouts/App.vue').default);

// vuetify
import Vue from 'vue'
import vuetify from 'gird-base-front/src/plugins/vuetify'

//локализация
import {i18n} from "./plugins/lang";

// роутер
import {router} from './plugins/router';

//vuex
import {store} from './plugins/store';
import {USER_REQUEST} from "gird-base-front/src/plugins/store/actions/user";

//конечные точки
import endpoint from './plugins/endpoint'
window.endpoint = endpoint;

//vue app
store.dispatch(USER_REQUEST)
    .finally(resp => {
        // экземпляр vue
        const app = new Vue({
            el: '#app',
            vuetify,
            i18n,
            store,
            router,
        });
    })




