import CustomerList from '../components/customer/CustomerList.vue';
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
];
export default routes;
