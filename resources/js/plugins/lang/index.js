import Vue from 'vue'
import VueI18n from 'vue-i18n'
import module from "./ru";
import base from "gird-base-front/src/plugins/lang/ru";

let ru = {...base, ...module};

Vue.use(VueI18n)

const i18n = new VueI18n({
    locale: 'ru',
    messages: {ru}
});

export {i18n};
