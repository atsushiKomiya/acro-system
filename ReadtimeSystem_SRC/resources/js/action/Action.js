import {BASE_URL} from "../common/AppUrl";

// TOP
const top = '/';

// デポ稼働日確認
const calendarConfirm = '/C_L10';
// デポ休業等申請
const depoRequest = '/C_L11';

// デフォルト設定
const depoDefault = '/C_L21';
const depoCalendar = '/C_L21/default';
const depoLeadtime = '/C_L21/leadtime';
const depoItem = '/C_L21/depoitem';
const depoItemAddress = '/C_L21/depoaddress';
// デフォルト一覧
const defaultList = '/C_L20';
// イレギュラー一覧
const irregularList = '/C_L30';
// イレギュラー設定
const irregularConfig = '/C_L31';
// デポ選択
const depoSelect = '/C_L50';
// デポ複数選択
const depoMultipleSelect = '/C_L51';
// 商品選択
const itemSelect = '/C_L52';
// 商品カテゴリ複数選択
const itemMultipleSelect = '/C_L53';
// 日程設定
const dateSelect = '/C_L54';
// 地域選択
const areaSelect = '/C_L55';
// メッセージ重複
const messageDuplication = '/C_L56';
//　イレギュラー
const irregularRemake = '/C_L31/remake';

export default Object.freeze({
    C_L01: `${BASE_URL}` + `${top}`,
    C_L10: `${BASE_URL}` + `${calendarConfirm}`,
    C_L11: `${BASE_URL}` + `${depoRequest}`,
    C_L20: `${BASE_URL}` + `${defaultList}`,
    C_L21: `${BASE_URL}` + `${depoDefault}`,
    C_L21_CALENDAR: `${BASE_URL}` + `${depoCalendar}`,
    C_L21_LEADTIME: `${BASE_URL}` + `${depoLeadtime}`,
    C_L21_ITEM: `${BASE_URL}` + `${depoItem}`,
    C_L21_ADDRESS: `${BASE_URL}` + `${depoItemAddress}`,
    C_L30: `${BASE_URL}` + `${irregularList}`,
    C_L31: `${BASE_URL}` + `${irregularConfig}`, 
    C_L31_REMAKE: `${BASE_URL}` + `${irregularRemake}`,
    C_L50: `${BASE_URL}` + `${depoSelect}`,
    C_L51: `${BASE_URL}` + `${depoMultipleSelect}`,
    C_L52: `${BASE_URL}` + `${itemSelect}`,
    C_L53: `${BASE_URL}` + `${itemMultipleSelect}`,
    C_L54: `${BASE_URL}` + `${dateSelect}`,
    C_L55: `${BASE_URL}` + `${areaSelect}`,
    C_L56: `${BASE_URL}` + `${messageDuplication}`,
});
