import axios from 'axios';

// axios.defaults.withCredentials = true;

//we can have a instance from axios
const Axios = axios.create({
    //base url -> API address
     baseURL :'http://127.0.0.1:8000/api/v1/'
});

Axios.defaults.withCredentials = true;
export default Axios;
