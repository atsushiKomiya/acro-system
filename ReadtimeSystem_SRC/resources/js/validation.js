// 0以上の整数のみ
isNumber = function(val){
  var regexp = new RegExp(/^[0-9]+(\.[0-9]+)?$/);
  return regexp.test(val);
}
