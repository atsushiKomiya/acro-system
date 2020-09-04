<script>
  import moment from "moment";
  export default {
    methods: {
      /** 曜日文字列取得 */
      judgeWeek: function(week) {
        var result = '';
        switch(week) {
          case 0:
            result = '日';
            break
          case 1:
            result = '月';
            break
          case 2:
            result = '火';
            break
          case 3:
            result = '水';
            break
          case 4:
            result = '木';
            break
          case 5:
            result = '金';
            break
          case 6:
            result = '土';
            break
        }
        return result;
      },
      /** 祝日文字列取得 */
      judgeHoliday: function(holiday) {
        var result = '';
        switch(holiday) {
          case 1:
            result = '祝日';
            break
          case 2:
            result = '祝前';
            break
          case 3:
            result = '祝後';
            break
          case 4:
            result = 'その他';
            break
        }
        return result;
      },
      /** 年月日個別取得処理 dateCls 1:year 2:month 3:day */
      getDateSplit: function(targetDate,dateCls) {
        var result = '';
        if(targetDate) {
          var momentDate = moment(targetDate, ['YYYY-MM-DD', 'YYYY/MM/DD']);
          if(dateCls == 1) {
            result = momentDate.format("YYYY");
          } else if(dateCls == 2) {
            result = momentDate.format("M");
          } else {
            result = momentDate.format("D");
          }
        }
        return result;
      },
      /** YYYY/MM/DDへの変換 */
      dateForDefaultFormat: function(date) {
        return moment(date, ['YYYYMMDD', 'YYYY-MM-DD', 'YYYY/MM/DD']).format('YYYY/MM/DD');
      }
    }
  }
</script>