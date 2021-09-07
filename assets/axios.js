import axios from "axios";

axios.defaults.baseURL = 'http://localhost:8000/';
if(localStorage.getItem('token') != 'null') {
     axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('token')}`;
 } 