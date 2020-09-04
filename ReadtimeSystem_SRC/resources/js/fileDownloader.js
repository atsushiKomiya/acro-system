const moment = require('moment');

makeDateTimeFilename = function(basename, extension, incDate, incTime) {
    incDate = incDate || true;
    incTime = incTime || true;
    var filename = basename;
    var date = new Date();
    var momDt = moment(date);
    if (incDate) {
        filename += "_" + momDt.format("YYYYMMDD");
    }
    if (incTime) {
        filename += "_" + momDt.format("HHmmss");
    }
    filename += extension;

    return filename;
}

fileDownload = function(url, model, fileName) {

    return new Promise(function(resolve, reject) {

        axios.post(url, model)
            .then(function(response) {
                var csv = response.data;
                // csv = new Encoding.stringToCode(response.data);
                // csv = Encoding.convert( csv, 'UTF-8');
                // csv = new Uint8Array( csv );
                downloadCsvBlob( csv, fileName );

                resolve(response);
            }).catch(function(error) {
                reject(error);
            });
    });
    
    function downloadCsvBlob(blob, fileName) {
        if (window.navigator.msSaveOrOpenBlob) {
            // for IE,Edge
            var blob = new Blob([blob], { "type" : "text/csv" });    
            window.navigator.msSaveOrOpenBlob(blob, fileName);
        } else {
            // for chrome, firefox
            const url = URL.createObjectURL(new Blob([blob], {type: 'text/csv'}));
            const linkEl = document.createElement('a');
            linkEl.href = url;
            linkEl.setAttribute('download', fileName);
            document.body.appendChild(linkEl);
            linkEl.click();
            URL.revokeObjectURL(url);
            linkEl.parentNode.removeChild(linkEl);
        }
    }
}