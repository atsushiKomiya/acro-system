import Client from './BaseFileUploadApi';
import { API_BASE_URL } from "../common/AppUrl";

const uploadLeadtime = '/C_L21/leadtime/upload';
const uploadDepoItem = '/C_L21/depoitem/upload';
const uploadDepoAddress = '/C_L21/depoaddress/upload';


export default {
    uploadApi(url,file,param) {
        let formData = new FormData();
        formData.append('uploadFile', file);
        formData.append('param', param);
        return Client.post(url, formData);
    },
    uploadLeadtimeUrl() {
        return API_BASE_URL + uploadLeadtime;
    },
    uploadDepoItemUrl() {
        return API_BASE_URL + uploadDepoItem;
    },
    uploadDepoAddressUrl() {
        return API_BASE_URL + uploadDepoAddress;
    },
};