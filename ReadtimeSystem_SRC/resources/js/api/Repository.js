import Client from './BaseApi';
import { API_BASE_URL } from "../common/AppUrl";

const searchLeadtimePref = '/common/depoPrefList'

const downloadCalendarConfirm = '/C_L10/download';
const searchCalendarConfirm = '/C_L10/search';
const countCalendarConfirm = '/C_L10/count';
const approvalCalendarConfirm = '/C_L10/approval';

const searchDefaultList = '/C_L20/search';
const countDefaultList = '/C_L20/count';
const downloadDefaultList = '/C_L20/download';

const applicationDepoRequest = '/C_L11/application';
const approvalDepoRequest = '/C_L11/approval';
const confirmDepoRequest = '/C_L11/confirm';

const searchCalendar = '/C_L21/calendar/search';
const saveCalendar = '/C_L21/calendar/save';
const reflectCalendar = '/C_L21/calendar/reflect';

const searchLeadtimeList = '/C_L21/leadtime/leadtimeList';
const saveLeadtime = '/C_L21/leadtime/save';
const downloadLeadtime = '/C_L21/leadtime/download';
const saveDepoItem = '/C_L21/depoitem/save';
const searchDepoItemList = '/C_L21/depoitem/depoItemList';
const downloadDepoItem = '/C_L21/depoitem/download';
const saveDepoAddress = '/C_L21/depoaddress/save';
const downloadDepoAddress = '/C_L21/depoaddress/download';
const searchPrefAddressList = '/C_L21/depoaddress/addressList';
const searchDepoAddressList = '/C_L21/depoaddress/depoAddressList';

const downloadIrregularList = '/C_L30/download';
const searchIrregularList = '/C_L30/search';
const countIrregularList = '/C_L30/count';

const reflectIrregular = '/C_L31/irregular/reflect';
const deleteIrregular = '/C_L31/irregular/delete';

const searchAddressList = '/C_L55/addressList';


export default {
    searchLeadtimePref(depoCd) {
        var data = {
            'depoCd': depoCd
        }
        return Client.get(`${searchLeadtimePref}`, {
            params: data
        });
    },
    searchCalendar(depoCd) {
        var data = {
            'depoCd': depoCd
        }
        return Client.get(`${searchCalendar}`, {
            params: data
        });
    },
    saveCalendar(calendar) {
        return Client.post(`${saveCalendar}`, JSON.stringify(calendar));
    },
    reflectCalendar(depoCd, startDate) {
        return Client.post(`${reflectCalendar}`, {
            'depoCd': depoCd,
            'startDate': startDate
        });
    },
    searchLeadtimeList(depoCd, prefCd) {
        var data = {
            'depoCd': depoCd,
            'prefCd': prefCd
        }
        return Client.get(`${searchLeadtimeList}`, {
            params: data
        });
    },
    saveLeadtime(depoCd, leadtimeList, displayType) {
        return Client.post(`${saveLeadtime}`, {
            'depoCd': depoCd,
            'leadtimeList': leadtimeList,
            'displayType': displayType,
        });
    },
    saveDepoItem(depoCd, depoItemList) {
        return Client.post(`${saveDepoItem}`, {
            'depoCd': depoCd,
            'depoItemList': depoItemList,
        });
    },
    saveDepoAddress(depoCd, depoAddressList) {
        return Client.post(`${saveDepoAddress}`, {
            'depoCd': depoCd,
            'depoAddressList': depoAddressList,
        });
    },
    applicationDepoRequest(depoCd,dateYm,calendarList){
        var param = {
            'depoCd': depoCd,
            'dateYm': dateYm,
            'calendarList': calendarList
        };
        return Client.post(`${applicationDepoRequest}`, JSON.stringify(param));
    },
    approvalDepoRequest(depoCd,dateYm,calendarList){
        var param = {
            'depoCd': depoCd,
            'dateYm': dateYm,
            'calendarList': calendarList
        };
        return Client.post(`${approvalDepoRequest}`, JSON.stringify(param));
    },
    confirmDepoRequest(depoCd,dateYm){
        return Client.post(`${confirmDepoRequest}`, {
            'depoCd': depoCd,
            'dateYm': dateYm,
        });
    },
    searchDepoAddressList(depoCd, prefCd) {
        var data = {
            'depoCd': depoCd,
            'prefCd': prefCd
        }
        return Client.get(`${searchDepoAddressList}`, {
            params: data
        });
    },
    searchPrefAddressList(prefCd) {
        var data = {
            'prefCd': prefCd
        }
        return Client.get(`${searchPrefAddressList}`, {
            params: data
        });
    },
    searchAddressList(jiscode) {
        var data = {
            'jiscode': jiscode
        }
        return Client.get(`${searchAddressList}`, {
            params: data
        });
    },
    searchDepoItemList(depoCd) {
        var data = {
            'depoCd': depoCd,
        }
        return Client.get(`${searchDepoItemList}`, {
            params: data
        });
    },
    reflectIrregular(
        irregular,
        irregularDepoList,
        irregularAreaList,
        irregularItemList,
        irregularDeliveryDayofweekList,
        irregularOrderDayofweekList
    ){
        var param = {
            'irregular': irregular,
            'irregularDepoList': irregularDepoList,
            'irregularAreaList': irregularAreaList,
            'irregularItemList': irregularItemList,
            'irregularDeliveryDayofweekList': irregularDeliveryDayofweekList,
            'irregularOrderDayofweekList': irregularOrderDayofweekList,
        };

        return Client.post(`${reflectIrregular}`, JSON.stringify(param));
    },
    deleteIrregular(
        irregularId
    ){
        return Client.post(`${deleteIrregular}`, {
            'irregularId':irregularId
        });
    },
    downloadLeadtimeUrl() {
        return API_BASE_URL + downloadLeadtime;
    },
    downloadDepoItemUrl() {
        return API_BASE_URL + downloadDepoItem;
    },
    downloadDepoAddressUrl() {
        return API_BASE_URL + downloadDepoAddress;
    },
    downloadCalendarConfirmUrl() {
        return API_BASE_URL + downloadCalendarConfirm;
    },
    searchCalendarConfirm(targetYm, prefCd, isNotApproval, isNotConfirm, displayType) {
        var data = {
            'searchYm': targetYm,
            'searchPrefCd': prefCd,
            'searchIsNotApproval': isNotApproval,
            'searchIsNotConfirm': isNotConfirm,
            'searchDisplayType': displayType,
        }
        return Client.get(`${searchCalendarConfirm}`, {
            params: data
        });
    },
    countCalendarConfirm(targetYm, prefCd, isNotApproval, isNotConfirm, displayType) {
        var data = {
            'searchYm': targetYm,
            'searchPrefCd': prefCd,
            'searchIsNotApproval': isNotApproval,
            'searchIsNotConfirm': isNotConfirm,
            'searchDisplayType': displayType,
        }
        return Client.get(`${countCalendarConfirm}`, {
            params: data
        });
    },
    searchDefaultList(prefCd, depoCd, itemCategoryLargecd, itemCategoryMediumcd ,itemCd, isConfig) {
        var data = {
            'prefCd': prefCd,
            'depoCd': depoCd,
            'itemCategoryLargecd': itemCategoryLargecd,
            'itemCategoryMediumcd': itemCategoryMediumcd,
            'itemCd': itemCd,
            'isConfig': isConfig,
        }
        return Client.get(`${searchDefaultList}`, {
            params: data
        });
    },
    countDefaultList(prefCd, depoCd, itemCategoryLargecd, itemCategoryMediumcd ,itemCd, isConfig) {
        var data = {
            'prefCd': prefCd,
            'depoCd': depoCd,
            'itemCategoryLargecd': itemCategoryLargecd,
            'itemCategoryMediumcd': itemCategoryMediumcd,
            'itemCd': itemCd,
            'isConfig': isConfig,
        }
        return Client.get(`${countDefaultList}`, {
            params: data
        });
    },
    approvalCalendarConfirm(targetYm, depoCd) {
        return Client.post(`${approvalCalendarConfirm}`, {
            'searchYm': targetYm,
            'depoCd': depoCd
        });
    },
    downloadDefaultListUrl() {
        return API_BASE_URL + downloadDefaultList;
    },
    searchIrregularList(searchParam) {
        return Client.get(`${searchIrregularList}`, {
            params: searchParam
        });

    },
    countIrregularList(searchParam) {
        return Client.get(`${countIrregularList}`, {
            params: searchParam
        });

    },
    downloadIrregularListUrl() {
        return API_BASE_URL + downloadIrregularList;
    }
};