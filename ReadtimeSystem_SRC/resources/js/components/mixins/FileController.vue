<script>
  import CsvUploadRepository from '../../api/CsvUploadRepository';
  export default {
    data: function() {
      return {
        mUploadfile: null,
        uploadLeadtimeUrl: CsvUploadRepository.uploadLeadtimeUrl(),
        uploadDepoItemUrl: CsvUploadRepository.uploadDepoItemUrl(),
        uploadDepoAddressUrl: CsvUploadRepository.uploadDepoAddressUrl(),
      };
    },
    methods: {
    /** CSVダウンロード */
      download: function(pFileName,pParam,url) {
        var fileFullName = makeDateTimeFilename(pFileName, ".csv");
        this.$root.$refs.appProgress.busy(true);
        fileDownload(url, pParam, fileFullName)
        .then(function(response) {
          alert('ダウンロードが完了しました');
        })
        .catch(function(error) {
          alert(error.message);
        })
        .finally(() => {
          this.$root.$refs.appProgress.busy(false);
        });
      },
      /** CSV取込 */
      upload: function(url,file,$func = null) {
        if (file) {
          this.$root.$refs.appProgress.busy(true);
          CsvUploadRepository.uploadApi(url,file)
          .then(function(response) {
            if($func) {
              $func(response);
            }
          })
          .catch(function(error) {
            if($func) {
              $func(error);
            }
          })
          .finally(() => {
            this.$root.$refs.appProgress.busy(false);
          });
        } else {
          alert("ファイルを選択してください");
        }
      },
      /** 選択された File の情報を保存 */
      selectedFile: function(e) {
        let files = e.target.files;
        this.mUploadfile = files[0];
        e.preventDefault();
      },
      /** 選択ファイル解除 */
      resetFile: function(e) {
        this.mUploadfile = null;
        e.preventDefault();
      }
    }
  }
</script>