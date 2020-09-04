var callbackFunc;

// デポ子画面反映処理
depoReflect = function(depo) {
    // デポコード
    if(callbackFunc !== undefined) {
        callbackFunc(depo);
    }
}

// デポ子画面反映処理
depoListReflect = function(depoList) {
    if(callbackFunc !== undefined) {
        callbackFunc(depoList);
    }
}

// 商品子画面反映処理(デフォルト一覧)
itemReflect = function(
    selectItemCategoryLargeCd,
    selectItemCategoryLargeName,
    selectItemCategoryMediumCd,
    selectItemCategoryMediumName,
    selectItemCd,
    selectItemName) {
    if(callbackFunc !== undefined) {
        callbackFunc(
            selectItemCategoryLargeCd,
            selectItemCategoryLargeName,
            selectItemCategoryMediumCd,
            selectItemCategoryMediumName,
            selectItemCd,
            selectItemName);
    }

}

// 商品子画面反映処理(デフォルト設定)
itemListReflect = function(
    selectItemCategoryLargeCd,
    selectItemCategoryLargeName,
    selectItemCategoryMediumCd,
    selectItemCategoryMediumName,
    selectItem) {
    if(callbackFunc !== undefined) {
        callbackFunc(
            selectItemCategoryLargeCd,
            selectItemCategoryLargeName,
            selectItemCategoryMediumCd,
            selectItemCategoryMediumName,
            selectItem);
    }
}

// 商品複数選択子画面反映処理
itemMultipleReflect = function(
    selectItemCategoryLargeCd,
    selectItemCategoryLargeName,
    selectItemCategoryMediumCd,
    selectItemCategoryMediumName,
    selectItem) {
    if(callbackFunc !== undefined) {
        callbackFunc(
            selectItemCategoryLargeCd,
            selectItemCategoryLargeName,
            selectItemCategoryMediumCd,
            selectItemCategoryMediumName,
            selectItem);
    }
}

//日付選択子画面反映処理
dateReflect = function(
    selectType,
    selectYear,
    selectMonth,
    selectDate,
    selectWeekList,
    selectHolidayList,
    selectStartYear,
    selectStartMonth,
    selectStartDate,
    selectEndYear,
    selectEndMonth,
    selectEndDate
){
    if(callbackFunc !== undefined) {
        callbackFunc(
            selectType,
            selectYear,
            selectMonth,
            selectDate,
            selectWeekList,
            selectHolidayList,
            selectStartYear,
            selectStartMonth,
            selectStartDate,
            selectEndYear,
            selectEndMonth,
            selectEndDate
        );
    }
}

//地域選択子画面反映処理
addressReflect = function(
    displayType,
    reflectList
){
    if(callbackFunc !== undefined) {
        callbackFunc(
            displayType,
            reflectList
        );
    }
}

//地域選択子画面(市区郡)反映処理
cityReflect = function(
    displayType,
    reflectList
){
    if(callbackFunc !== undefined) {
        callbackFunc(
            displayType,
            reflectList
        );
    }
}

//ページ遷移
pageTransition = function(url){
    //ページ開く
    window.open(url ,'_blank');
}

// Windowオブジェクト
var winObj;
var winName = 'childWin';

childWinOpen = function(childUrl,urlParamArr,func,option = 'width=800,height=700,toolbar=0,menubar=0,scrollbars=0,resizable=0') {
    if( (!winObj) || ((winObj) && winObj.closed) ){
        // Windowオープン
        if(urlParamArr!=undefined){
            var param=[];
            for(let key in urlParamArr){
                param.push(key + '=' + urlParamArr[key]);
            }
           childUrl = childUrl + '?' + param.join('&');
        }
        winObj = window.open(childUrl, winName, option);
        // 初期化
        callbackFunc = (func !== undefined) ? func : undefined;
    } else {
        alert('既に子画面が開かれています。');
    }
}


childWinOpenPost = function(childUrl,urlParamArr,func,option = 'width=800,height=700,toolbar=0,menubar=0,scrollbars=0,resizable=0') {
    if( (!winObj) || ((winObj) && winObj.closed) ){

        var mapForm = document.createElement("form");
        mapForm.target = winName;
        mapForm.method = "POST";
        mapForm.action = childUrl;
        
        // Windowオープン
        if(urlParamArr!=undefined){
            for(let key in urlParamArr){
                if(urlParamArr[key] instanceof Array) {
                    for(let arrayKey in urlParamArr[key]) {
                        var mapInput = document.createElement("input");
                        mapInput.type = "hidden";
                        mapInput.name = key;
                        mapInput.value = urlParamArr[key][arrayKey];
                        mapForm.appendChild(mapInput);
                    }
                } else {
                    var mapInput = document.createElement("input");
                    mapInput.type = "hidden";
                    mapInput.name = key;
                    mapInput.value = urlParamArr[key];
                    mapForm.appendChild(mapInput);
                }
            }
            document.body.appendChild(mapForm);
        }
        winObj = window.open('', winName, option);
        if(winObj) {
            mapForm.submit();
            // 初期化
            callbackFunc = (func !== undefined) ? func : undefined;
        }
    } else {
        alert('既に子画面が開かれています。');
    }
}
