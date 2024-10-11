<template>
    <header class="bg-white shadow-md p-4 flex items-center justify-between">
        <div class="text-xl font-semibold text-gray-800">
            Customer - Details
        </div>

        <div>
            <p v-if="loader">
                Loading...
            </p>
            <router-link :to="{name:'customers'}"
                         class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700"
            >
                Back
            </router-link>
            <button
                @click.prevent="saveData"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700"
            >
                Save
            </button>
        </div>
    </header>

    <template v-if="loader">
        Loading...
    </template>
    <template v-else>
        <div class="p-6">
            <div class="flex grid-cols-2 gap-5 mx-auto">
                <!-- General Section -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-4">General</h2>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="name" name="name" v-model="formData.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <span class="text-tiny+ text-red-700" v-if="errors?.name?.length">{{ errors.name.at(0) }}</span>
                            </div>
                            <div>
                                <label for="reference" class="block text-sm font-medium text-gray-700">Reference</label>
                                <input type="text" id="reference" name="reference" v-model="formData.reference" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <span class="text-tiny+ text-red-700" v-if="errors?.reference?.length">{{ errors.reference.at(0) }}</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="categroy" class="block text-sm font-medium text-gray-700">Category</label>
                            <select
                                class="block p-2 w-full text-sm text-gray-900 border border-gray-300 rounded-lg"
                                v-model="formData.category_id"
                            >
                                <option value="" selected >Select</option>
                                <option v-for="( item, index ) in categories" :key="'filter_category_' + index" :value="item.id">{{ item.title }}</option>
                            </select>
                            <span class="text-tiny+ text-red-700" v-if="errors?.category_id?.length">{{ errors.category_id.at(0) }}</span>
                        </div>
                    </form>
                </div>

                <!-- Details Section -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-4">Details</h2>
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start_date" name="start_date" v-model="formData.start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <span class="text-tiny+ text-red-700" v-if="errors?.start_date?.length">{{ errors.start_date.at(0) }}</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">description</label>
                            <textarea id="description" name="description" rows="3" v-model="formData.description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            <span class="text-tiny+ text-red-700" v-if="errors?.description?.length">{{ errors.description.at(0) }}</span>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="p-6">
            <div class="bg-white shadow-md p-4 flex items-center justify-between">
                <h4 class="text-xl font-semibold text-gray-800">
                    Contacts
                </h4>

                <div>
                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700"
                        @click.prevent="showContactForm"
                    >
                        Create
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto p-6" ref="list_view">
                <table class="min-w-full text-sm text-left text-gray-500 w-full">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">First Name</th>
                        <th scope="col" class="px-6 py-3">Last Name</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-if="formData.contacts">
                        <tr class="bg-white border-b hover:bg-gray-50" v-for="(item, index) in formData.contacts" :key="'customer_contact_' + index">
                            <td class="px-6 py-4">{{ item.first_name }} <span class="text-tiny+ text-red-700" v-if="('contacts.' + index + '.first_name') in errors">{{ errors['contacts.' + index + '.first_name'].at(0) }}</span></td>
                            <td class="px-6 py-4">{{ item.last_name }} <span class="text-tiny+ text-red-700" v-if="('contacts.' + index + '.last_name') in errors">{{ errors['contacts.' + index + '.last_name'].at(0) }}</span></td>
                            <td class="px-6 py-4"> <a href="#" @click.prevent="showContactForm( index )"> Edit </a> | <a href="#" @click.prevent="removeContact(index)" >Delete</a></td>
                        </tr>
                    </template>
                    <template v-else>
                        <tr>
                            <td colspan="3">
                                <p class="text-red-500">
                                    No Records found.
                                </p>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
    </template>

    <div id="contactModal" class="modal fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" v-show="showContactModal">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-xl font-semibold">Contact Details</h3>
                <button id="closeModal" class="text-gray-600 hover:text-gray-900 focus:outline-none" @click.prevent="showContactModal = false">&times;</button>
            </div>
            <div class="p-6">
                <form>
                    <div class="mb-4">
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
                        <input type="text" id="first_name" name="first_name" v-model="contactForm.first_name"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                        <input type="text" id="last_name" name="last_name" v-model="contactForm.last_name"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="closeModalBtn"
                                class="mr-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600" @click.prevent="showContactModal = false">Cancel</button>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none" @click.prevent="addContact">Save</button>
                    </div>
                </form>
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
            showContactModal: false,
            categories: window.categories,
            selectedContact: null,
            errors: {},
            formData: {
                name: null,
                reference: null,
                category_id: null,
                start_date: null,
                description: null,
                contacts: [],
            },
            contactForm: {}
        }

    },
    mounted(){
        this.init();
    },
    methods:{

        init() {

            if( this.$route?.params?.id ){
                this.formData.id = this.$route?.params?.id;
                this.loadEditData( this.$route.params.id );
            }
        },
        loadEditData ( id ) {
            this.loader = true;
            request.get( '/api/customers/' + id )
                .then(
                    ( response ) => {
                        if( response.data ){

                            this.formData = response.data;

                        }
                    },

                    ( err ) => {

                    }
                ).finally( () => {
                this.loader = false;
            })
        },
        saveData () {
            if( this.loader ){
                return;
            }
            this.loader = true;
            let existsData = this?.formData?.id;
            if (existsData) {
                this.updateData();
            } else {
                this.createData();
            }
        },
        updateData () {
            request.put( '/api/customers/' + this.formData.id, this.formData )
                .then(
                    ( res ) => {
                        if( res.data ){
                            this.$router.push({ name: 'customers' });
                        }
                    },
                    ( err ) => {
                        if( err.response?.data?.errors ){
                            this.errors = err.response.data.errors;
                        }
                    }
                ).finally( () => {
                this.loader = false;
            })
        },
        createData () {
            request.post( '/api/customers', this.formData )
                .then(
                    ( res ) => {
                        if( res.data ){
                            this.$router.push({ name: 'customers' });
                        }
                    },
                    ( err ) => {
                        if( err.response?.data?.errors ){
                            this.errors = err.response.data.errors;
                        }
                    }
                ).finally( () => {
                this.loader = false;
            })
        },
        showContactForm ( id ) {
            if( this?.formData?.contacts[id] ){
                this.selectedContact = id;
                let existsData = this?.formData?.contacts[id];

                this.contactForm = Object.assign(existsData,{
                    first_name: this?.formData?.contacts[id].first_name,
                    last_name: this?.formData?.contacts[id].last_name,
                })

            }else{
                this.selectedContact = null;

                this.contactForm = {
                    first_name: '',
                    last_name: '',
                }
            }
            this.showContactModal = !this.showContactModal;
        },
        addContact () {

            if( this.selectedContact !== null && this.selectedContact !== "" ){
                this.formData.contacts[ this.selectedContact ] = Object.assign( {} , this.contactForm);
            }else{
                this.formData.contacts.push( this.contactForm );

            }
            this.showContactModal = false;
        },
        removeContact( index ){
            if( confirm('Are you sure?')){
                this.formData.contacts.splice( index, 1);
            }
        }
    }
}
</script>

<style>

</style>
