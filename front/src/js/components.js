import Vue from 'vue';
Vue.component('booking-list', require('./Components/booking/List').default);
Vue.component('booking-item', require('./Components/booking/Item').default);


Vue.component('transfer-list', require('./Components/transfer/List').default);
Vue.component('transfer-item', require('./Components/transfer/Item').default);
Vue.component('transfer-search', require('./Components/transfer/Search').default);

Vue.component('tailwind-empty-resource', require('./Components/tailwind/EmptyResource').default);
Vue.component('tailwind-card', require('./Components/tailwind/Card').default);
Vue.component('tailwind-pagination', require('./Components/tailwind/Pagination').default);
Vue.component('resource-table-card', require('./Components/tailwind/ResourceTableCard').default);
