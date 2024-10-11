import CustomerList from '../components/customer/CustomerList.vue';
import ErrorPage from '../components/error/Index.vue';
const routes = [
    {
        path: '/app/',
        redirect:'/app/customers'
    },
    {
        path: '/app/customers',
        name: 'customers',
        component: CustomerList,
        meta:{
            title: 'Customers'
        }
    },
    {
        path: '/app/error',
        name: 'error',
        component: ErrorPage,
        meta:{
            title: 'Error'
        }
    },
];
export default routes;
