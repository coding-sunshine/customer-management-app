import axios from 'axios';
const http = axios.create({
    baseURL: import.meta.env.VITE_BASE_API_URL,
    headers:{
        accept: 'application/json'
        // 'Access-Control-Allow-Origin': 'tb10'
    }
});
http.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        if (error.response && ![422, 500].includes( error.status ) ) {
            router.push({name: 'error'});
        }
        return Promise.reject(error);
    }
);
export default http;
