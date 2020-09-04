タイトル：{{ '【' . $irregularId . '】' . $title }} <br>
@if ($irregularType === 1)
イレギュラー設定区分：配送不可 <br>
@elseif ($irregularType === 2)
イレギュラー設定区分：受注制御 <br>
@elseif ($irregularType === 3)
イレギュラー設定区分：配送先振替 <br>
@endif
用途：{{ $cUse }} <br>
有効区分：{{ $isValid ? '有効' : '無効' }} <br>
@if ($irregularType === 1)
前日締切：{{ $isBeforeDeadlineUndeliv ? '不可' : '可能' }} <br>
当日配送：{{ $isTodayDeadlineUndeliv ? '不可' : '可能' }} <br>
時間指定：{{ $isTimeSelectUndeliv ? '不可' : '可能' }} <br>
個人宅：{{ $isPersonalDelivery ? '不可' : '可能' }} <br>
@elseif ($irregularType === 2)
前日締切：{{ $isBeforeDeadlineUndeliv ? '不可' : '可能' }} <br>
配送時間：{{ $timeSelect }} <br>
個人宅：{{ $isPersonalDelivery ? '不可' : '可能' }} <br>
@elseif ($irregularType === 3)
@endif
@if (!is_null($orderDateType))
@if ($orderDateType === 1)
受注日指定（日付）：{{ $orderDate }} <br>
@elseif ($orderDateType === 2)
受注日指定（期間）：{{ $orderDateFrom . '〜' . $orderDateTo }} <br>
@elseif ($orderDateType === 3)
受注日指定（曜日）：{{ $irregularOrderDayofweekListStr }} <br>
@endif
@endif
@if (!is_null($deliveryDateType))
@if ($deliveryDateType === 1)
お届け日指定（日付）：{{ $deliveryDate }} <br>
@elseif ($deliveryDateType === 2)
お届け日指定（期間）：{{ $deliveryDateFrom . '〜' . $deliveryDateTo }} <br>
@elseif ($deliveryDateType === 3)
お届け日指定（曜日）：{{ $irregularDeliveryDayofweekListStr }} <br>
@endif
@endif
デポ指定：{{ $irregularDepoListStr }} <br>
商品指定：{{ $irregularItemListStr }} <br>
地域指定：{{ $irregularAreaListStr }} <br>
@if ($irregularType === 3)
<!-- 配送先振替 -->
振替先配送デポ：{{ '【' . $transDepoCd . '】' . $transDepoName }} <br>
@endif
地域注釈：{{ $annoAddr }} <br>
期間注釈：{{ $annoPeriod }} <br>
振替注釈：{{ $annoTrans }} <br>
エラーメッセージ：{{ $errorMessage }} <br>
設定日時：{{ $createdAt  }} <br>
設定者：{{ '【' . $createdId . '】' .  $name1 . ' ' . $name2 }} <br>
