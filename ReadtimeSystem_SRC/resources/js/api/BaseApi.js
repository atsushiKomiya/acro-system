import axios from "axios";
import {API_BASE_URL} from "../common/AppUrl";

export default axios.create({
    baseURL: API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
        // "Authorization": "Bearer xxxxx"
    },
    responseType: 'json' 
});
