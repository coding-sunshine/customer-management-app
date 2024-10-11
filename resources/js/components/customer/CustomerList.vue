<template>
    <header class="bg-white shadow-md p-4 flex items-center justify-between">
        <div class="text-xl font-semibold text-gray-800">
            Customer
        </div>

        <div>
            <router-link :to="{name: 'customer_create'}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700"
            >
                Add New Customer
            </router-link>
        </div>
    </header>

    <div class="p-6">
        <!-- Search Container -->
        <div class="flex items-center justify-between mb-4 space-x-2">
            <!-- Single Input Search -->
            <div class="relative w-1/2">
                <input
                    type="text"
                    class="block p-2 w-full text-sm text-gray-900 border border-gray-300 rounded-lg"
                    placeholder="Search..."
                    v-model="filter.search"
                />
            </div>

            <!-- Dropdown Search -->
            <div class="relative w-1/4">
                <select
                    class="block p-2 w-full text-sm text-gray-900 border border-gray-300 rounded-lg"
                    v-model="filter.category"
                >
                    <option value="" selected >Filter by Category</option>
                    <option v-for="( item, index ) in categories" :key="'filter_category_' + index" :value="item.id">{{ item.title }}</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-2">
                <button
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-400"
                    type="buttons"
                    @click="clearFilter"
                >
                    Clear
                </button>
                <button
                    type="button"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700" @click.prevent="applyFilter"
                >
                    Apply
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto" ref="list_view">
            <table class="min-w-full text-sm text-left text-gray-500 w-full">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Reference</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">No Of Contacts</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
                </thead>
                <tbody>
                <template v-if="loader">
                    <p>
                        Loading....
                    </p>
                </template>
                <template v-else >

                    <template v-if="lists?.data?.length">

                        <tr class="bg-white border-b hover:bg-gray-50" v-for="(item, index) in lists.data" :key="'customer_record_' + index">
                            <td class="px-6 py-4">{{ item.name }}</td>
                            <td class="px-6 py-4">{{ item.reference }}</td>
                            <td class="px-6 py-4">{{ item.category.title }}</td>
                            <td class="px-6 py-4">{{ item.contacts.length }}</td>
                            <td class="px-6 py-4"> <router-link :to="{name: 'customer_edit', params: {id: item.id}}" >Edit</router-link> | <a href="#" @click.prevent="removeRecord( item.id )">Delete</a></td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="5">
                                <p class="text-red-500">
                                    No Records Found.
                                </p>
                            </td>
                        </tr>
                    </template>
                </template>
                </tbody>
            </table>
            <div class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
                <div class="text-xs+">{{ lists?.from ?? 0 }} - {{ lists?.to ?? 0 }} of {{ lists?.total ?? 0 }} entries</div>
                <pagination :total-records="lists?.total" :per-page="lists?.per_page" :current-page="page" @pageChange="updatePage"></pagination>
            </div>
        </div>
    </div>


</template>

<script>

import request from '../../requests';

export default {

    data(){


        return {
            loader: false,
            pageTitle: 'Customer Management',
            categories: window.categories,
            lists: {},
            page: 1,
            filter: {
                search: null,
                category: ''
            }
        }

    },
    mounted(){
        this.init();
    },
    methods:{

        init() {
            this.loadData();
        },
        loadData () {
            this.loader = true;
            request.get( '/api/customers/', { params: {search: this.filter, category: this.category, page: this.page }} )
                .then(
                    ( res ) => {
                        if( res.data ){
                            this.lists = res.data;
                            this.$refs?.list_view?.scrollIntoView({behavior: 'smooth'});
                        }
                    },

                    ( err ) => {

                    }
                ).finally( () => {
                this.loader = false;
            })
        },
        updatePage ( page ) {
            this.page = page;
            this.loadData();
        },

        applyFilter() {
            this.page = 1;
            this.loadData();
        },
        clearFilter() {
            this.page = 1;
            this.filter = {
                search: null,
                category: ''
            }
            this.loadData();
        },
        removeRecord( id ){
            if( confirm( 'Are you sure ?') ){
                request.delete( '/api/customers/' + id)
                    .then(
                        ( res ) => {
                            this.loadData();
                        }
                    )
            }
        }
    }
}
</script>

<style>

</style>
