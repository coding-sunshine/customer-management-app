import CustomerList from '../components/customer/CustomerList.vue';
import ErrorPage from '../components/error/Index.vue';
import CustomerCreate from '../components/customer/CustomerCreate.vue';
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
        path: '/app/customers/create',
        name: 'customer_create',
        component: CustomerCreate,
    },
    {
        path: '/app/customers/edit/:id',
        name: 'customer_edit',
        component: CustomerCreate,
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
