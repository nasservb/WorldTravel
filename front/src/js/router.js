import Vue from "vue";

import VueRouter from "vue-router";


import RootComponent from './Pages/Root';
import LoginComponent from './Pages/Auth/Login';
import BookingIndexComponent from './Pages/Booking/Index';
import BookingShowComponent from './Pages/Booking/Show';
import TransferShowComponent from './Pages/Transfer/Show';
import TransferSearchComponent from './Pages/Transfer/Search';

const baseUrl = '/front' ; 
const routePaths = [
    {
        path: baseUrl+'/',
        name: 'index',
        component: RootComponent
    },
    {
        path: baseUrl+'/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: baseUrl+'/panel',
        name: 'panel',
        component: BookingIndexComponent
    },
    {
        path:  baseUrl +'/booking/show/:id',
        name: 'booking.show',
        component: BookingShowComponent
    },
    {
        path:  baseUrl +'/transfer/show/:id',
        name: 'transfer.show',
        component: TransferShowComponent
    },
    {
        path:  baseUrl+'/transfer/search',
        name: 'transfer.search',
        component: TransferSearchComponent
    },
];
// configure router
Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes: routePaths
})

export default router;
