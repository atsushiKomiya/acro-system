<?php

namespace App\Infrastructure\Eloquents;

use App\Consts\AppConst;
use App\Domain\Factories\MessageDuplicationFactory;
use App\Domain\Entities\IrregularEntity;
use App\Domain\Entities\IrregularListSearchEntity;
use App\Domain\Entities\MessageSearchEntity;
use App\Domain\Factories\IrregularFactory;
use App\Domain\Models\Irregular;
use App\Domain\Models\IrregularDepo;
use App\Domain\Repositories\IrregularRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentIrregularRepository implements IrregularRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;
    private $irregularFactory;

    /**
     * コンストラクタ
     *
     * @param Irregular $irregular
     */
    public function __construct(Irregular $irregular, MessageDuplicationFactory $factory, IrregularFactory $irregularFactory)
    {
        $this->eloquent = $irregular;
        $this->factory = $factory;
        $this->irregularFactory = $irregularFactory;
    }

    /**
     * イレギュラーメッセージ一一覧取得
     *
     * @param MessageSearchEntity $entity
     * @return void
     */
    public function findAnnoMessageList(MessageSearchEntity $entity): array
    {
        // ---------- 一時テーブル（赤字注釈の絞り込み） Query ----------
        $subIrregularQuery = $this->eloquent::select('irregular_id');
        // 日付が存在する場合は日付も条件に設定する
        if ($entity->deliveryDateList) {
            $deliveryDateList = $entity->deliveryDateList;
            // 赤字注釈（通年以外）
            $subIrregularQuery->orWhere(function($subIrregularQuery) use($deliveryDateList) {
                $subIrregularQuery->whereNotNull('anno_from')->whereNotNull('anno_to')->whereNull('irregular.deleted_at');
                $subIrregularQuery->whereRaw("to_char(anno_from, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                $subIrregularQuery->whereRaw("to_char(anno_to, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                $subIrregularQuery->where(function($subIrregularQuery) use($deliveryDateList){
                    foreach($deliveryDateList as $deliveryDate) {
                        $date = Carbon::parse($deliveryDate)->format('Y-m-d');
                        $subIrregularQuery->orWhere(function($subIrregularQuery) use($date){
                            $subIrregularQuery->where('anno_from', '<=', $date);
                            $subIrregularQuery->where('anno_to', '>=', $date);
                        });
                    }
                });
            });
            // 赤字注釈（通年　通常）
            $subIrregularQuery->orWhere(function($subIrregularQuery) use($deliveryDateList) {
                $subIrregularQuery->whereNotNull('anno_from')->whereNotNull('anno_to')->whereNull('irregular.deleted_at');
                $subIrregularQuery->whereRaw("to_char(anno_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                $subIrregularQuery->whereRaw("to_char(anno_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                $subIrregularQuery->whereRaw("to_char(anno_from, 'MMDD') <=  to_char(anno_to, 'MMDD')");
                $subIrregularQuery->where(function($subIrregularQuery) use($deliveryDateList){
                    foreach($deliveryDateList as $deliveryDate) {
                        $md = Carbon::parse($deliveryDate)->format('md');
                        $subIrregularQuery->orWhere(function($subIrregularQuery) use($md){
                            $subIrregularQuery->whereRaw("to_char(anno_from, 'MMDD') <= '" .$md ."'");
                            $subIrregularQuery->whereRaw("to_char(anno_to, 'MMDD') >= '" . $md ."'");
                        });
                    }
                });
            });
            // 赤字注釈（通年　年跨ぎ）
            $subIrregularQuery->orWhere(function($subIrregularQuery) use($deliveryDateList) {
                $subIrregularQuery->whereNotNull('anno_from')->whereNotNull('anno_to')->whereNull('irregular.deleted_at');
                $subIrregularQuery->whereRaw("to_char(anno_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                $subIrregularQuery->whereRaw("to_char(anno_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                $subIrregularQuery->whereRaw("to_char(anno_from, 'MMDD') >  to_char(anno_to, 'MMDD')");
                $subIrregularQuery->where(function($subIrregularQuery) use($deliveryDateList){
                    foreach($deliveryDateList as $deliveryDate) {
                        $md = Carbon::parse($deliveryDate)->format('md');
                        $subIrregularQuery->orWhere(function($subIrregularQuery) use($md){
                            $subIrregularQuery->orWhere(function($subIrregularQuery) use($md){
                                $subIrregularQuery->whereRaw("to_number(to_char(anno_from, 'MMDD'), '9999') <= ((to_number('" . $md ."', '9999') + 1200))");
                                $subIrregularQuery->whereRaw("to_char(anno_to, 'MMDD') >= '" . $md ."'");
                            });
                            $subIrregularQuery->orWhere(function($subIrregularQuery) use($md){
                                $subIrregularQuery->whereRaw("to_char(anno_from, 'MMDD') <= '" .$md ."'");
                                $subIrregularQuery->whereRaw("(to_number(to_char(anno_to, 'MMDD'), '9999') + 1200) >= '" . $md ."'");
                            });
                        });
                    }
                });
            });
        }

        // 期間
        if ($entity->deliveryDateFrom && $entity->deliveryDateTo) {
            $subIrregularQuery->whereNotNull('anno_from')->whereNotNull('anno_to')->whereNull('irregular.deleted_at');
            $dateFrom = Carbon::parse($entity->deliveryDateFrom)->format('Y-m-d');
            $dateTo = Carbon::parse($entity->deliveryDateTo)->format('Y-m-d');
            // 赤字注釈（通年以外）
            $subIrregularQuery->orWhere(function($subIrregularQuery) use($dateFrom,$dateTo) {
                $subIrregularQuery->whereRaw("to_char(anno_from, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                $subIrregularQuery->whereRaw("to_char(anno_to, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                $subIrregularQuery->where(function($subIrregularQuery) use($dateFrom,$dateTo){
                    $subIrregularQuery->where('anno_from', '<=', $dateTo);
                    $subIrregularQuery->where('anno_to', '>=', $dateFrom);
                });
            });
            // 赤字注釈（通年　通常）
            $subIrregularQuery->orWhere(function($subIrregularQuery) use($dateFrom,$dateTo) {
                $subIrregularQuery->whereNotNull('anno_from')->whereNotNull('anno_to')->whereNull('irregular.deleted_at');
                $subIrregularQuery->whereRaw("to_char(anno_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                $subIrregularQuery->whereRaw("to_char(anno_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                $subIrregularQuery->whereRaw("to_char(anno_from, 'MMDD') <=  to_char(anno_to, 'MMDD')");
                $subIrregularQuery->where(function($subIrregularQuery) use($dateFrom,$dateTo){
                    $mdFrom = Carbon::parse($dateFrom)->format('md');
                    $mdTo = Carbon::parse($dateTo)->format('md');
                    $subIrregularQuery->whereRaw("to_char(anno_from, 'MMDD') <= '" .$mdTo ."'");
                    $subIrregularQuery->whereRaw("to_char(anno_to, 'MMDD') >= '" . $mdFrom ."'");
                });
            });
            // 赤字注釈（通年　年跨ぎ）
            $subIrregularQuery->orWhere(function($subIrregularQuery) use($dateFrom,$dateTo) {
                $subIrregularQuery->whereNotNull('anno_from')->whereNotNull('anno_to')->whereNull('irregular.deleted_at');
                $subIrregularQuery->whereRaw("to_char(anno_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                $subIrregularQuery->whereRaw("to_char(anno_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                $subIrregularQuery->whereRaw("to_char(anno_from, 'MMDD') >  to_char(anno_to, 'MMDD')");
                $subIrregularQuery->where(function($subIrregularQuery) use($dateFrom,$dateTo){
                    $mdFrom = Carbon::parse($dateFrom)->format('md');
                    $mdTo = Carbon::parse($dateTo)->format('md');
                    $subIrregularQuery->whereRaw("to_number(to_char(anno_from, 'MMDD'), '9999') <= (to_number('" . $mdTo ."', '9999') + 1200)");
                    $subIrregularQuery->whereRaw("(to_number(to_char(anno_to, 'MMDD'), '9999') + 1200) >= '" . $mdFrom ."'");
                });
            });

        }

        // お届け日、期間のどちらも未指定
        if (count($entity->deliveryDateList) == 0 && $entity->deliveryDateFrom == null && $entity->deliveryDateTo == null) {
            // 赤文字注釈期間がnullでない、かつ、削除日がnullの条件設定
            $subIrregularQuery->whereNotNull('anno_from')->whereNotNull('anno_to')->whereNull('irregular.deleted_at');
        }

        // ---------- メイン Query ----------
        $mainQuery = $this->eloquent::select(
            DB::raw("'2' AS message_type"),
            'irregular.irregular_id',
            'irregular.irregular_type',
            'irregular.anno_addr',
            'irregular.anno_period',
            'irregular.anno_trans',
            'irregular.error_message',
        )->joinSub($subIrregularQuery, 'irregular_temp', function ($join) {
            $join->on('irregular_temp.irregular_id', '=', 'irregular.irregular_id');
        });

        // WHERE 句
        // 日付・期間・曜日
        if($entity->deliveryDateList || ($entity->deliveryDateFrom && $entity->deliveryDateTo) ||
         $entity->dayOfWeekList || $entity->publicHolidayStatusList) {
            $deliveryDateList = $entity->deliveryDateList;
            $deliveryDateFrom = $entity->deliveryDateFrom;
            $deliveryDateTo = $entity->deliveryDateTo;
            $dayOfWeekList = $entity->dayOfWeekList;
            $publicHolidayStatusList = $entity->publicHolidayStatusList;
            $mainQuery->where(function($mainQuery) use($deliveryDateList,$deliveryDateFrom,$deliveryDateTo,$dayOfWeekList,$publicHolidayStatusList) {
                // 共通条件
                $mainQuery->orWhere(function ($mainQuery) {
                    $mainQuery->whereNull('irregular.delivery_date_type');
                    $mainQuery->whereNull('irregular.delivery_date');
                    $mainQuery->whereNull('irregular.delivery_date_from');
                    $mainQuery->whereNull('irregular.delivery_date_type');
                });

                // 日付
                if ($deliveryDateList) {
                    $mainQuery->orWhere(function($mainQuery) use($deliveryDateList) {
                        // お届け日
                        $mainQuery->orWhere(function($mainQuery) use($deliveryDateList){
                            $mainQuery->where('irregular.delivery_date_type', '1');
                            $mainQuery->where(function($mainQuery) use($deliveryDateList){
                                foreach($deliveryDateList as $deliveryDate) {
                                    $date = Carbon::parse($deliveryDate)->format('Y-m-d');
                                    $mainQuery->orWhere('irregular.delivery_date', '=', $date);
                                }
                            });
                        });
                        // お届け日（期間　・　通年以外）
                        $mainQuery->orWhere(function($mainQuery) use($deliveryDateList) {
                            $mainQuery->where('irregular.delivery_date_type', '2');
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                            $mainQuery->where(function($mainQuery) use($deliveryDateList){
                                foreach($deliveryDateList as $deliveryDate) {
                                    $date = Carbon::parse($deliveryDate)->format('Y-m-d');
                                    $mainQuery->orWhere(function($mainQuery) use($date){
                                        $mainQuery->where('irregular.delivery_date_from', '<=', $date);
                                        $mainQuery->where('irregular.delivery_date_to', '>=', $date);
                                    });
                                }
                            });
                        });
                        // お届け日（期間　・　通年　通常）
                        $mainQuery->orWhere(function($mainQuery) use($deliveryDateList) {
                            $mainQuery->where('irregular.delivery_date_type', '2');
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'MMDD') <=  to_char(irregular.delivery_date_to, 'MMDD')");
                            $mainQuery->where(function($mainQuery) use($deliveryDateList){
                                foreach($deliveryDateList as $deliveryDate) {
                                    $md = Carbon::parse($deliveryDate)->format('md');
                                    $mainQuery->orWhere(function($mainQuery) use($md){
                                        $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'MMDD') <= '" .$md ."'");
                                        $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'MMDD') >= '" . $md ."'");
                                    });
                                }
                            });
                        });
                        // お届け日（期間　・　通年　年跨ぎ）
                        $mainQuery->orWhere(function($mainQuery) use($deliveryDateList) {
                            $mainQuery->where('irregular.delivery_date_type', '2');
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'MMDD') >  to_char(irregular.delivery_date_to, 'MMDD')");
                            $mainQuery->where(function($mainQuery) use($deliveryDateList){
                                foreach($deliveryDateList as $deliveryDate) {
                                    $md = Carbon::parse($deliveryDate)->format('md');
                                    $mainQuery->orWhere(function($mainQuery) use($md){
                                        $mainQuery->orWhere(function($mainQuery) use($md){
                                            $mainQuery->whereRaw("to_number(to_char(irregular.delivery_date_from, 'MMDD'), '9999') <= ((to_number('" . $md ."', '9999') + 1200))");
                                            $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'MMDD') >= '" . $md ."'");
                                        });
                                        $mainQuery->orWhere(function($mainQuery) use($md){
                                            $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'MMDD') <= '" .$md ."'");
                                            $mainQuery->whereRaw("(to_number(to_char(irregular.delivery_date_to, 'MMDD'), '9999') + 1200) >= '" . $md ."'");
                                        });
                                    });
                                }
                            });
                        });
                    });
                }

                // 期間
                if ($deliveryDateFrom && $deliveryDateTo) {
                    $dateFrom = Carbon::parse($deliveryDateFrom)->format('Y-m-d');
                    $dateTo = Carbon::parse($deliveryDateTo)->format('Y-m-d');
                    // お届け日
                    $mainQuery->orWhere(function($mainQuery) use($dateFrom,$dateTo) {
                        $mainQuery->where('irregular.delivery_date_type', '1');
                        $mainQuery->where('irregular.delivery_date', '<=', $dateTo);
                        $mainQuery->where('irregular.delivery_date', '>=', $dateFrom);
                    });

                    // お届け日（期間　・　通年以外）
                    $mainQuery->orWhere(function($mainQuery) use($dateFrom,$dateTo) {
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'YYYY') <> '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                        $mainQuery->where(function($mainQuery) use($dateFrom,$dateTo){
                            $mainQuery->where('irregular.delivery_date_from', '<=', $dateTo);
                            $mainQuery->where('irregular.delivery_date_to', '>=', $dateFrom);
                        });
                    });
                    // お届け日（期間　・　通年　通常）
                    $mainQuery->orWhere(function($mainQuery) use($dateFrom,$dateTo) {
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'MMDD') <=  to_char(irregular.delivery_date_to, 'MMDD')");
                        $mainQuery->where(function($mainQuery) use($dateFrom,$dateTo){
                            $mdFrom = Carbon::parse($dateFrom)->format('md');
                            $mdTo = Carbon::parse($dateTo)->format('md');
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'MMDD') <= '" .$mdTo ."'");
                            $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'MMDD') >= '" . $mdFrom ."'");
                        });
                    });
                    // お届け日（期間　・　通年　年跨ぎ）
                    $mainQuery->orWhere(function($mainQuery) use($dateFrom,$dateTo) {
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_FROM . "'");
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_to, 'YYYY') = '" . AppConst::ALL_YEAR_ROUND_TO . "'");
                        $mainQuery->whereRaw("to_char(irregular.delivery_date_from, 'MMDD') >  to_char(irregular.delivery_date_to, 'MMDD')");
                        $mainQuery->where(function($mainQuery) use($dateFrom,$dateTo){
                            $mdFrom = Carbon::parse($dateFrom)->format('md');
                            $mdTo = Carbon::parse($dateTo)->format('md');
                            $mainQuery->whereRaw("to_number(to_char(irregular.delivery_date_from, 'MMDD'), '9999') <= (to_number('" . $mdTo ."', '9999') + 1200)");
                            $mainQuery->whereRaw("(to_number(to_char(irregular.delivery_date_to, 'MMDD'), '9999') + 1200) >= '" . $mdFrom ."'");
                        });
                    });
                }

                // 曜日
                if ($dayOfWeekList || $publicHolidayStatusList) {
                    // 条件
                    $mainQuery->orWhere(function($mainQuery) {
                        $mainQuery->where('irregular.delivery_date_type', '3');
                        $mainQuery->whereNotNull('irregular_dayofweek.irregular_id');
                    });
                }
            });
        }

        // JOIN 句
        // 曜日
        if ($entity->dayOfWeekList || $entity->publicHolidayStatusList) {
            // ------------- 曜日・祝日 SubQuery ---------------
            $subDayofweekQuery = DB::table('irregular_dayofweek')->select(
                'irregular_id'
            )->whereNull(
                'deleted_at'
            )->groupBy(
                'irregular_id'
            );
            // 曜日 & 祝日ステータスの組み合わせ作成
            $params = [];
            if (count($entity->dayOfWeekList) == 0) {
                // 祝日のみ設定されている場合
                foreach ($entity->publicHolidayStatusList as $holiday) {
                    $params[] = ['public_holiday_status' => $holiday];
                }
            } elseif (count($entity->publicHolidayStatusList) == 0) {
                // 曜日のみ設定されている場合
                foreach ($entity->dayOfWeekList as $dayofweek) {
                    $params[] = ['dayofweek' => $dayofweek];
                }
            } else {
                // どちらも設定されている場合
                foreach ($entity->dayOfWeekList as $dayofweek) {
                    $params[] = ['dayofweek' => $dayofweek, 'public_holiday_status' => null];
                }
                foreach ($entity->publicHolidayStatusList as $holiday) {
                    $params[] = ['dayofweek' => null, 'public_holiday_status' => $holiday];
                }
                foreach ($entity->dayOfWeekList as $dayofweek) {
                    foreach ($entity->publicHolidayStatusList as $holiday) {
                        $params[] = ['dayofweek' => $dayofweek, 'public_holiday_status' => $holiday];
                    }
                }
            }

            if ($params) {
                $subDayofweekQuery->where(function ($subDayofweekQuery) use ($params) {
                    foreach ($params as $param) {
                        $subDayofweekQuery->orWhere(function ($subDayofweekQuery) use ($param) {
                            if (array_key_exists('dayofweek', $param)) {
                                $subDayofweekQuery->where('dayofweek', '=', $param['dayofweek']);
                            }
                            if (array_key_exists('public_holiday_status', $param)) {
                                $subDayofweekQuery->where('public_holiday_status', '=', $param['public_holiday_status']);
                            }
                        });
                    }
                });
            }
            // 結合
            $mainQuery->leftJoinSub($subDayofweekQuery, 'irregular_dayofweek', function ($join) {
                $join->on('irregular_dayofweek.irregular_id', '=', 'irregular.irregular_id');
            });
        }

        // デポ
        if ($entity->depoCdList) {
            // ------------- デポ SubQuery ---------------
            $subDepoQuery = DB::table('irregular_depo')->select(
                'irregular_id'
            )->whereIn(
                'depo_cd',
                $entity->depoCdList
            )->whereNull(
                'deleted_at'
            )->groupBy(
                'irregular_id'
            );
            // 結合
            $mainQuery->leftJoinSub($subDepoQuery, 'irregular_depo', function ($join) {
                $join->on('irregular_depo.irregular_id', '=', 'irregular.irregular_id');
            });
            // 条件
            $mainQuery->where(function ($mainQuery) use ($entity) {
                $mainQuery->orWhere('irregular.is_depo', '0');
                $mainQuery->orWhere(function ($mainQuery) {
                    $mainQuery->where('irregular.is_depo', '1');
                    $mainQuery->whereNotNull('irregular_depo.irregular_id');
                });
            });
        }

        // 商品
        if ($entity->itemList) {
            // ------------- 商品 SubQuery ---------------
            $subItemQuery = DB::table('irregular_item')->select(
                'irregular_id'
            )->whereNull(
                'deleted_at'
            )->groupBy(
                'irregular_id'
            );
            $itemList = $entity->itemList;
            $subItemQuery->where(function($subItemQuery) use($itemList) {
                foreach($itemList as $item) {
                    $subItemQuery->orWhere(function($subItemQuery) use($item) {
                        if ($item->itemCategoryLargeCd) {
                            $subItemQuery->where('lcat_cd', $item->itemCategoryLargeCd);
                        }
                        if ($item->itemCategoryMediumCd) {
                            $subItemQuery->where('mcat_cd', $item->itemCategoryMediumCd);
                        }
                        if ($item->itemCd) {
                            $subItemQuery->where('item_cd', $item->itemCd);
                        }
                    });
                }
            });
            // 結合
            $mainQuery->leftJoinSub($subItemQuery, 'irregular_item', function ($join) {
                $join->on('irregular_item.irregular_id', '=', 'irregular.irregular_id');
            });
            // 条件
            $mainQuery->where(function ($mainQuery) use ($entity) {
                // 商品
                $mainQuery->where('irregular.is_item', '0');
                $mainQuery->orWhere(function ($mainQuery) {
                    $mainQuery->where('irregular.is_item', '1');
                    $mainQuery->whereNotNull('irregular_item.irregular_id');
                });
            });
        }

        // 住所
        if ($entity->addressList) {
            // ------------- 住所 SubQuery ---------------
            $subAreaQuery = DB::table('irregular_area')->select(
                'irregular_id'
            )->whereNull(
                'deleted_at'
            )->groupBy(
                'irregular_id'
            );

            $subAreaQuery->where(function ($subAreaQuery) use ($entity) {

                foreach($entity->addressList as $address) {
                    $subAreaQuery->orWhere(function($subAreaQuery) use($address){
                        if($address->pref) {
                            $subAreaQuery->where('pref_cd',$address->pref);
                        }
                        if($address->siku) {
                            $subAreaQuery->where('siku',$address->siku);
                        }
                        if($address->tyou) {
                            $subAreaQuery->where('tyou',$address->tyou);
                        }
                    });
                }
            });
            // 結合
            $mainQuery->leftJoinSub($subAreaQuery, 'irregular_area', function ($join) {
                $join->on('irregular_area.irregular_id', '=', 'irregular.irregular_id');
            });
            // 条件
            $mainQuery->where(function ($mainQuery) use ($entity) {
                $mainQuery->orWhere('irregular.is_area', '0');
                $mainQuery->orWhere(function ($mainQuery) {
                    $mainQuery->where('irregular.is_area', '1');
                    $mainQuery->whereNotNull('irregular_area.irregular_id');
                });
            });
        }

        $cursors = $mainQuery->groupBy(
            'message_type',
            'irregular.irregular_id',
            'irregular.irregular_type',
            'irregular.anno_addr',
            'irregular.anno_period',
            'irregular.anno_trans',
            'irregular.error_message',
        )->orderBy(
            'irregular.irregular_id'
        )->cursor();

        $result = [];

        $factory = new MessageDuplicationFactory();
        foreach ($cursors as $cursor) {
            $result[] = $factory->makeIrregularMessageDuplication($cursor);
        }

        return $result;
    }


    /**
     * イレギュラー情報取得
     * @param $irregularId
     * @return IrregularEntity
     */
    public function findIrregular($irregularId): IrregularEntity
    {
        $irregularFactory = $this->irregularFactory;
        $query = $this->eloquent::select(
            'irregular.irregular_id AS irregular_id',
            'irregular.irregular_type AS irregular_type',
            'irregular.title AS title',
            'irregular.c_use AS c_use',
            'irregular.is_valid AS is_valid',
            'irregular.is_before_deadline_undeliv AS is_before_deadline_undeliv',
            'irregular.is_today_deadline_undeliv AS is_today_deadline_undeliv',
            'irregular.is_time_select_undeliv AS is_time_select_undeliv',
            'irregular.time_select AS time_select',
            'irregular.is_personal_delivery AS is_personal_delivery',
            'irregular.delivery_date_type AS delivery_date_type',
            'irregular.delivery_date AS delivery_date',
            'irregular.delivery_date_from AS delivery_date_from',
            'irregular.delivery_date_to AS delivery_date_to',
            'irregular.order_date_type AS order_date_type',
            'irregular.order_date AS order_date',
            'irregular.order_date_from AS order_date_from',
            'irregular.order_date_to AS order_date_to',
            'irregular.is_depo AS is_depo',
            'irregular.is_item AS is_item',
            'irregular.is_area AS is_area',
            'irregular.anno_from AS anno_from',
            'irregular.anno_to AS anno_to',
            'irregular.anno_addr AS anno_addr',
            'irregular.anno_period AS anno_period',
            'irregular.anno_trans AS anno_trans',
            'irregular.error_message AS error_message',
            'irregular.trans_depo_cd AS trans_depo_cd',
            'view_depo.deponame AS deponame',
            'irregular.remark AS remark',
            'irregular.created_id AS created_id',
            'irregular.created_at AS created_at',
            'irregular.updated_id AS updated_id',
            'irregular.updated_at AS updated_at',
            'view_shain.name1 AS name1',
            'view_shain.name2 AS name2'
        );
        $query->join('view_shain', 'view_shain.e_code', '=', 'irregular.updated_id');
        $query->leftJoin('view_depo', function ($join) {
            $join->on('irregular.trans_depo_cd', '=', 'view_depo.depocd');
        });
        $query->where('irregular_id', $irregularId);

        $model = $query->first();

        $result = null;
        if (!is_null($model)) {
            $result = $irregularFactory->make($model);
        }
        return $result;
    }

    /**
     * イレギュラー設定
     *
     * @param IrregularEntity $entity
     * @return int
     */
    public function save(IrregularEntity $entity): int
    {
        $irregular = $this->eloquent::find($entity->irregularId);

        if (is_null($irregular)) {
            $irregular = new Irregular();
        }

        $irregular->title = $entity->title;
        $irregular->irregular_type = $entity->irregularType;
        $irregular->c_use = $entity->cUse;
        $irregular->is_valid = $entity->isValid;
        $irregular->is_before_deadline_undeliv = $entity->isBeforeDeadlineUndeliv;
        $irregular->is_today_deadline_undeliv = $entity->isTodayDeadlineUndeliv;
        $irregular->is_time_select_undeliv = $entity->isTimeSelectUndeliv;
        $irregular->time_select = $entity->timeSelect;
        $irregular->is_personal_delivery = $entity->isPersonalDelivery;

        $irregular->delivery_date_type = $entity->deliveryDateType;
        $irregular->delivery_date = $entity->deliveryDate;
        $irregular->delivery_date_from = $entity->deliveryDateFrom;
        $irregular->delivery_date_to = $entity->deliveryDateTo;

        $irregular->order_date_type = $entity->orderDateType;
        $irregular->order_date = $entity->orderDate;
        $irregular->order_date_from = $entity->orderDateFrom;
        $irregular->order_date_to = $entity->orderDateTo;

        $irregular->is_depo = $entity->isDepo;
        $irregular->is_item = $entity->isItem;
        $irregular->is_area = $entity->isArea;

        $irregular->anno_from = $entity->annoFrom;
        $irregular->anno_to = $entity->annoTo;

        $irregular->anno_addr = $entity->annoAddr;
        $irregular->anno_period = $entity->annoPeriod;
        $irregular->anno_trans = $entity->annoTrans;
        $irregular->error_message = $entity->errorMessage;

        $irregular->trans_depo_cd = $entity->transDepoCd;

        $irregular->remark = $entity->remark;

        $irregular->save();

        return $irregular->irregular_id;
    }
    /**
     * イレギュラー設定 削除
     *
     * @param integer $irregularId
     * @param integer $loginCd
     * @return void
     */
    public function deleteByIrregularId(int $irregularId, int $loginCd)
    {
        $result = $this->eloquent::where('irregular_id', $irregularId)
        ->update([
            'deleted_id' => $loginCd,
            'deleted_at' => now()
        ]);

        return $result;
    }

    /**
     * 【C_LI_01_リードタイムAPIフロント】
     * イレギュラー情報取得
     *
     * @param array $cond 検索条件
     * @return array
     */
    public function getIrregularInfo($cond): array
    {
        $query = $this->eloquent::query();
        $query->select(
            'irregular.irregular_id',
            'irregular.title',
            'irregular.irregular_type',
            'irregular.c_use',
            'irregular.is_valid',
            'irregular.is_before_deadline_undeliv',
            'irregular.is_today_deadline_undeliv',
            'irregular.is_time_select_undeliv',
            'irregular.time_select',
            'irregular.is_personal_delivery',
            'irregular.delivery_date_type',
            'irregular.delivery_date',
            DB::raw('tsunen_from(irregular.delivery_date_from) AS delivery_date_from'),
            DB::raw('tsunen_to(irregular.delivery_date_from, irregular.delivery_date_to) AS delivery_date_to'),
            'irregular.order_date_type',
            'irregular.order_date',
            DB::raw('tsunen_from(irregular.order_date_from) AS order_date_from'),
            DB::raw('tsunen_to(irregular.order_date_from, irregular.order_date_to) AS order_date_to'),
            'irregular.is_depo',
            'irregular.is_item',
            'irregular.is_area',
            DB::raw('tsunen_from(irregular.anno_from) AS anno_from'),
            DB::raw('tsunen_to(irregular.anno_from, irregular.anno_to) AS anno_to'),
            'irregular.anno_addr',
            'irregular.anno_period',
            'irregular.anno_trans',
            'irregular.error_message',
            'irregular.trans_depo_cd',
            'irregular_depo.depo_cd',
            'irregular_dayofweek.date_type',
            'irregular_dayofweek.dayofweek',
            'irregular_dayofweek.public_holiday_status',
        )
        ->join('irregular_depo', 'irregular_depo.irregular_id', '=', 'irregular.irregular_id')
        ->join('irregular_item', 'irregular_item.irregular_id', '=', 'irregular.irregular_id')
        ->join('irregular_area', 'irregular_area.irregular_id', '=', 'irregular.irregular_id')
        ->join('irregular_dayofweek', 'irregular_dayofweek.irregular_id', '=', 'irregular.irregular_id')
        ->where('irregular.is_valid', true)
        ->whereNull('irregular.deleted_at');

        $query->where(function ($query) use ($cond) {
            $query->where(function ($query) {
                $query->where('irregular.is_item', 0);
            })
            ->orWhere(function ($query) use ($cond) {
                $query->where('irregular_item.lcat_cd', $cond->lcat_cd)
                      ->whereNull('irregular_item.mcat_cd')
                      ->whereNull('irregular_item.item_cd');
            })
            ->orWhere(function ($query) use ($cond) {
                $query->where('irregular_item.lcat_cd', $cond->lcat_cd)
                      ->where('irregular_item.mcat_cd', $cond->mcat_cd)
                      ->whereNull('irregular_item.item_cd');
            })
            ->orWhere(function ($query) use ($cond) {
                $query->where('irregular_item.lcat_cd', $cond->lcat_cd)
                      ->where('irregular_item.mcat_cd', $cond->mcat_cd)
                      ->where('irregular_item.item_cd', $cond->item_cd);
            });
        });
        $query->where(function ($query) use ($cond) {
            $query->where(function ($query) {
                $query->where('irregular.is_area', 0);
            })
            ->orWhere(function ($query) use ($cond) {
                $query->where('irregular_area.pref_cd', $cond->pref_cd)
                      ->whereNull('irregular_area.siku')
                      ->whereNull('irregular_area.tyou');
            })
            ->orWhere(function ($query) use ($cond) {
                $query->where('irregular_area.pref_cd', $cond->pref_cd)
                      ->where('irregular_area.siku', $cond->siku)
                      ->whereNull('irregular_area.tyou');
            })
            ->orWhere(function ($query) use ($cond) {
                $query->where('irregular_area.pref_cd', $cond->pref_cd)
                      ->where('irregular_area.siku', $cond->siku)
                      ->where('irregular_area.tyou', $cond->tyou);
            });
        });
        if ($cond->procKbn == 2) {
            $query->where(function ($query) use ($cond) {
                $query->where(function ($query) use ($cond) {
                    $query->whereNull('irregular.c_use');
                })
                ->orWhere(function ($query) use ($cond) {
                    $query->where('irregular.c_use', $cond->c_use);
                });
            });
        }
        $query->orderBy('irregular.updated_at', 'desc');

        return ($query->count() > 0) ? $query->get()->all() : [];
    }

    /**
     * イレギュラー情報リストクエリ
     *
     * @param IrregularListSearchEntity $cond
     * @return Object 
     */
    private function irregularListQuery(IrregularListSearchEntity $searchCondition)
    {
        // 一時 query
        $subQuery = $this->eloquent::select(
            'irregular.irregular_id',
            'irregular.irregular_type',
            'irregular.title',
            'irregular.is_valid',
            DB::raw("array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT depo.depocd ))), ',') AS depo_cd"),
            DB::raw("array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT '【' || depo.depocd::varchar(255) || '】' ||  depo.deponame))), ',') AS depo_name"),
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT depo.depocd))) AS depo_cd_list"),
            'trans_depo.deponame as trans_depo_name',
            'trans_depo.depocd as trans_depo_cd',
            'irregular.c_use',
            'c_use.c_use_name',
            'irregular.is_before_deadline_undeliv',
            'irregular.is_today_deadline_undeliv',
            'irregular.is_time_select_undeliv',
            'irregular.time_select',
            'irregular.is_personal_delivery',
            'irregular.is_area',
            'irregular.delivery_date_type',
            'irregular.delivery_date',
            'irregular.delivery_date_from',
            'irregular.delivery_date_to',
            DB::raw("array_to_string(dayofweek_trans_delivery.dayofweek_list || dayofweek_trans_delivery.public_holiday_status_list, ',') AS delivery_week_holiday_list"),
            'dayofweek_trans_delivery.dayofweek_cd_list AS delivery_dayofweek_cd_list',
            'dayofweek_trans_delivery.public_holiday_status_cd_list AS delivery_public_holiday_status_cd_list',
            'irregular.order_date_type',
            'irregular.order_date',
            'irregular.order_date_from',
            'irregular.order_date_to',
            DB::raw("array_to_string(dayofweek_trans_order.dayofweek_list || dayofweek_trans_order.public_holiday_status_list, ',') AS order_week_holiday_list"),
            'dayofweek_trans_order.dayofweek_cd_list AS order_dayofweek_cd_list',
            'dayofweek_trans_order.public_holiday_status_cd_list AS order_public_holiday_status_cd_list',
            DB::raw("view_shain.name1 || ' ' || view_shain.name2 AS updated_name"),
            'irregular.updated_id',
            'irregular.updated_at',
            'irregular.remark',
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT irregular_item.lcat_cd))) AS lcat_cd_list"),
            DB::raw("array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT irregular_item.mcat_cd))), ',') AS mcat_cd"),
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT irregular_item.mcat_cd))) AS mcat_cd_list"),
            DB::raw("array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT irregular_item.item_cd))), ',') AS item_cd"),
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT irregular_item.item_cd))) AS item_cd_list"),
            DB::raw("array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT irregular_item.lcat_cd))), ',') AS lcat_cd"),
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT irregular_area.zip_cd))) AS zip_cd_list"),
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT irregular_area.pref_cd))) AS pref_cd_list"),
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT irregular_area.siku))) AS siku_list"),
            DB::raw("ARRAY(SELECT unnest(array_agg(DISTINCT irregular_area.tyou))) AS tyou_list"),
        );

        // 個人宅
        $subQuery
        ->join('view_shain', 'view_shain.e_code', '=', 'irregular.updated_id')
        ->leftJoin('irregular_depo', function ($join) {
            $join->on('irregular_depo.irregular_id', '=', 'irregular.irregular_id');
        })
        ->leftJoin('view_depo as depo', function ($join) {
            $join->on('irregular_depo.depo_cd', '=', 'depo.depocd');
        })
        ->leftJoin('view_depo as trans_depo', function ($join) {
            $join->on('trans_depo.depocd', '=', 'irregular.trans_depo_cd');
        })
        ->leftJoin('c_use', function ($join) {
            $join->on('c_use.c_use', '=', 'irregular.c_use');
        })
        ->leftJoin('irregular_item', function ($join) {
            $join->on('irregular_item.irregular_id', '=', 'irregular.irregular_id');
        })
        ->leftJoin('irregular_area', function ($join) {
            $join->on('irregular_area.irregular_id', '=', 'irregular.irregular_id');
        })
        ->leftJoinSub($this->getWeekHolidayTempQuery(), 'dayofweek_trans_delivery', function ($join) {
            $join->on('dayofweek_trans_delivery.irregular_id', '=', 'irregular.irregular_id');
            $join->where('dayofweek_trans_delivery.date_type', '=', '1');
        })
        ->leftJoinSub($this->getWeekHolidayTempQuery(), 'dayofweek_trans_order', function ($join) {
            $join->on('dayofweek_trans_order.irregular_id', '=', 'irregular.irregular_id');
            $join->where('dayofweek_trans_order.date_type', '=', '2');
        });

        $subQuery->groupBy(
            'irregular.irregular_id',
            'irregular.irregular_type',
            'irregular.title',
            'trans_depo.depocd',
            'trans_depo.deponame',
            'irregular.c_use',
            'c_use.c_use_name',
            'irregular.is_before_deadline_undeliv',
            'irregular.is_today_deadline_undeliv',
            'irregular.is_time_select_undeliv',
            'irregular.time_select',
            'irregular.is_personal_delivery',
            'irregular.is_area',
            'irregular.delivery_date_type',
            'irregular.delivery_date',
            'irregular.delivery_date_from',
            'irregular.delivery_date_to',
            'delivery_week_holiday_list',
            'irregular.order_date_type',
            'irregular.order_date',
            'irregular.order_date_from',
            'irregular.order_date_to',
            'order_week_holiday_list',
            'updated_name',
            'irregular.updated_id',
            'irregular.updated_at',
            'irregular.remark',
            'delivery_dayofweek_cd_list',
            'delivery_public_holiday_status_cd_list',
            'order_dayofweek_cd_list',
            'order_public_holiday_status_cd_list'
        );

        $query = $this->eloquent::joinSub($subQuery, 'irregular_tmp', function ($join) {
            $join->on('irregular.irregular_id', '=', 'irregular_tmp.irregular_id');
        });

        // 検索条件
        // イレギュラー設定区分
        if ($searchCondition->searchIrregularConfig) {
            $query->where('irregular_tmp.irregular_type', $searchCondition->searchIrregularConfig);
        }
        // タイトル
        if ($searchCondition->searchTitle) {
            // 部分一致
            $query->where('irregular_tmp.title', 'LIKE', '%' . $searchCondition->searchTitle . '%');
        }
        // デポ複数
        if ($searchCondition->searchChoiceDepoList) {
            $choiceDepoList = $searchCondition->searchChoiceDepoList;
            $query->where(function ($query) use ($choiceDepoList) {
                foreach ($choiceDepoList as $depodata) {
                    if (is_string($depodata)) {
                        $depodata = json_decode($depodata);
                        $depocd = $depodata->depocd;
                    } else {
                        $depocd = $depodata['depocd'];
                    }
                    $query->orWhereRaw('? = ANY (irregular_tmp.depo_cd_list)', $depocd);
                }
            });
        }
        // 用途
        if ($searchCondition->searchCUseCd) {
            $query->where('irregular_tmp.c_use', $searchCondition->searchCUseCd);
        }
        // 有効区分
        if (!is_null($searchCondition->searchIsValid)) {
            $query->where('irregular_tmp.is_valid', (int) $searchCondition->searchIsValid);
        }
        // 当日配送不可
        if ($searchCondition->searchIsTodayDelivery) {
            $query->where('irregular_tmp.is_today_deadline_undeliv', $searchCondition->searchIsTodayDelivery);
        }
        // 個人宅
        if ($searchCondition->searchIsPrivateHome) {
            $query->where('irregular_tmp.is_personal_delivery', $searchCondition->searchIsPrivateHome);
        }
        // 時間指定不可
        if ($searchCondition->searchIsTimeSelect) {
            $query->where('irregular_tmp.is_time_select_undeliv', $searchCondition->searchIsTimeSelect);
        }
        // 前日締切不可
        if ($searchCondition->searchIsBeforeDeadline) {
            $query->where('irregular_tmp.is_before_deadline_undeliv', $searchCondition->searchIsBeforeDeadline);
        }
        // 配送時間
        if ($searchCondition->searchDeliveryTime) {
            $query->where('irregular_tmp.time_select', '=', $searchCondition->searchDeliveryTime);
        }
        // 振替先配送デポ複数
        if ($searchCondition->searchChoiceTransDepoList) {
            $choiceDepoList = $searchCondition->searchChoiceTransDepoList;
            $query->where(function ($query) use ($choiceDepoList) {
                foreach ($choiceDepoList as $depodata) {
                    if (is_string($depodata)) {
                        $depodata = json_decode($depodata);
                        $depocd = $depodata->depocd;
                    } else {
                        $depocd = $depodata['depocd'];
                    }
                    $query->orWhereRaw('? = ANY (irregular_tmp.trans_depo_cd)', $depocd);
                }
            });
        }
        if ($searchCondition->searchItemList) {
            $itemList = $searchCondition->searchItemList;
            $query->where(function ($query) use($itemList) {
                foreach ($itemList as $item) {
                    $query->orWhere(function ($query) use ($item) {
                        if (is_string($item)) {
                            $item = json_decode($item);
                            $largeCd = $item->itemCategoryLargeCd;
                            $mediumCd = $item->itemCategoryMediumCd;
                            $itemCd = $item->itemCd;
                        } else {
                            $largeCd = $item['itemCategoryLargeCd'];
                            $mediumCd = $item['itemCategoryMediumCd'];
                            $itemCd = $item['itemCd'];
                        }
                        if ($mediumCd != null && $itemCd != null) {
                            // カテゴリ大
                            $query->whereRaw('? = ANY (irregular_tmp.lcat_cd_list)', [$largeCd])
                            // カテゴリ中
                            ->whereRaw('? = ANY (irregular_tmp.mcat_cd_list)', [$mediumCd])
                            // 商品名
                            ->whereRaw('? = ANY (irregular_tmp.item_cd_list)', $itemCd);
                        } elseif ($mediumCd != null && $itemCd == null) {
                            // カテゴリ大
                            $query->whereRaw('? = ANY (irregular_tmp.lcat_cd_list)', [$largeCd])
                            // カテゴリ中
                            ->whereRaw('? = ANY (irregular_tmp.mcat_cd_list)', [$mediumCd]);
                        } else {
                            // カテゴリ大
                            $query->whereRaw('? = ANY (irregular_tmp.lcat_cd_list)', [$largeCd]);
                        }
                    });
                }
            });
        }
        // お届け
        if ($searchCondition->searchDeliveryDateType) {
            // 日
            if ($searchCondition->searchDeliveryDate) {
                $query->where('irregular_tmp.delivery_date', $searchCondition->searchDeliveryDate);
            }
            // FROM~TO
            if ($searchCondition->searchDeliveryPeriodStart && $searchCondition->searchDeliveryPeriodEnd) {
                $from = $searchCondition->searchDeliveryPeriodStart;
                $to = $searchCondition->searchDeliveryPeriodEnd;
                $query->where(function ($query) use ($from, $to) {
                    $query->whereRaw('? <= irregular_tmp.delivery_date_to', $from)
                    ->whereRaw('irregular_tmp.delivery_date_from <= ?', $to);
                });
            }
            // 曜日絞り込み
            if ($searchCondition->searchDeliveryWeekList) {
                $deliveryWeekList = $searchCondition->searchDeliveryWeekList;
                $query->where(function ($query) use ($deliveryWeekList) {
                    foreach ($deliveryWeekList as $week) {
                        $query->orWhereRaw('? = ANY (irregular_tmp.delivery_dayofweek_cd_list)', [$week]);
                    }
                });
            }
            // 祝日ステータス絞り込み
            if ($searchCondition->searchDeliveryHolidayList) {
                $deliveryHolidayList = $searchCondition->searchDeliveryHolidayList;
                $query->where(function ($query) use ($deliveryHolidayList) {
                    foreach ($deliveryHolidayList as $holiday) {
                        $query->orWhereRaw('? = ANY (irregular_tmp.delivery_public_holiday_status_cd_list)', [$holiday]);
                    }
                });
            }
        }
        // 受注日
        if ($searchCondition->searchOrderType) {
            // 日
            if ($searchCondition->searchOrderDate) {
                $query->where('irregular_tmp.order_date', $searchCondition->searchOrderDate);
            }
            // FROM~TO
            if ($searchCondition->searchOrderPeriodStart && $searchCondition->searchOrderPeriodEnd) {
                $from = $searchCondition->searchOrderPeriodStart;
                $to = $searchCondition->searchOrderPeriodEnd;
                $query->where(function ($query) use ($from, $to) {
                    $query->whereRaw('? <= irregular_tmp.order_date_to', $from)
                    ->whereRaw('irregular_tmp.order_date_from <= ?', $to);
                });
            }
            // 曜日絞り込み
            if ($searchCondition->searchOrderWeekList) {
                $orderWeekList = $searchCondition->searchOrderWeekList;
                $query->where(function ($query) use ($orderWeekList) {
                    foreach ($orderWeekList as $week) {
                        $query->orWhereRaw('? = ANY (irregular_tmp.order_dayofweek_cd_list)', [$week]);
                    }
                });
            }
            // 祝日ステータス絞り込み
            if ($searchCondition->searchOrderHolidayList) {
                $orderHolidayList = $searchCondition->searchOrderHolidayList;
                $query->where(function ($query) use ($orderHolidayList) {
                    foreach ($orderHolidayList as $holiday) {
                        $query->orWhereRaw('? = ANY (irregular_tmp.order_public_holiday_status_cd_list)', [$holiday]);
                    }
                });
            }
        }
        // 郵便番号
        if ($searchCondition->searchZipcdList) {
            $zipcdList = $searchCondition->searchZipcdList;
            $query->where(function ($query) use ($zipcdList) {
                foreach ($zipcdList as $zipCd) {
                    if($zipCd != 'null') {
                        $query->orWhereRaw('? = ANY (irregular_tmp.zip_cd_list)', [$zipCd]);
                    }
                }
            });
        }
        // 都道府県
        if ($searchCondition->searchPrefList) {
            $prefList = $searchCondition->searchPrefList;
            $query->where(function ($query) use ($prefList) {
                foreach ($prefList as $pref) {
                    if($pref != 'null') {
                        $query->orWhereRaw('? = ANY(irregular_tmp.pref_cd_list)', $pref);
                    }
                }
            });
        }
        // 市区群
        if ($searchCondition->searchSikuList) {
            $sikuList = $searchCondition->searchSikuList;
            $query->where(function ($query) use ($sikuList) {
                foreach ($sikuList as $siku) {
                    if($siku != 'null') {
                        $query->orWhereRaw('? = ANY (irregular_tmp.siku_list)', [$siku]);
                    }
                }
            });
        }
        // 町
        if ($searchCondition->searchTyouList) {
            $tyouList = $searchCondition->searchTyouList;
            $query->where(function ($query) use ($tyouList) {
                foreach ($tyouList as $tyou) {
                    if($tyou != 'null') {
                        $query->orWhereRaw('? = ANY (irregular_tmp.tyou_list)', [$tyou]);
                    }
                }
            });
        }

        // 並び替え
        $query->orderBy('irregular_tmp.irregular_id', 'ASC');
        return $query;
    }

    /**
     * イレギュラー情報リスト取得
     *
     * @param IrregularListSearchEntity $cond
     * @return LazyCollection
     */
    public function findIrregularList(IrregularListSearchEntity $searchCondition): LazyCollection
    {
        $query = $this->irregularListQuery($searchCondition);

        // 取得
        $result = $query->cursor();

        return $result;
    }

    /**
     * イレギュラー件数取得
     * 
     * @param IrregularListSearchEntity $condition
     * @return int
     */
    public function countIrregularList(IrregularListSearchEntity $condition): int
    {
        $query = $this->irregularListQuery($condition);
        $result = $query->count();
        return $result;
    }

    /**
     * 曜日・祝日取得Queryの生成
     *
     * @return void
     */
    private function getWeekHolidayTempQuery()
    {
        // 曜日・祝日一時 query
        $weekQuery = DB::table('irregular_dayofweek')->select(
            'irregular_id',
            'date_type',
            'dayofweek',
            DB::raw("
                CASE
                    WHEN dayofweek = 0 THEN '日'
                    WHEN dayofweek = 1 THEN '月'
                    WHEN dayofweek = 2 THEN '火'
                    WHEN dayofweek = 3 THEN '水'
                    WHEN dayofweek = 4 THEN '木'
                    WHEN dayofweek = 5 THEN '金'
                    WHEN dayofweek = 6 THEN '土'
                END as dayofweek_list
            "),
            'public_holiday_status',
            DB::raw("
                CASE
                    WHEN public_holiday_status = 1 THEN '祝日'
                    WHEN public_holiday_status = 2 THEN '祝前'
                    WHEN public_holiday_status = 3 THEN '祝後'
                END as public_holiday_status_list
            "),
        )
        ->groupBy(
            'irregular_id',
            'date_type',
            'dayofweek',
            'public_holiday_status'
        )
        ->orderBy('irregular_id', 'asc')
        ->orderBy('date_type', 'asc')
        ->orderBy('dayofweek', 'asc')
        ->orderBy('public_holiday_status', 'asc');

        // 曜日・祝日取得Query
        $query = DB::table('irregular_dayofweek')->select(
            'irregular_dayofweek.irregular_id',
            'irregular_dayofweek.date_type',
            DB::raw("array_agg(DISTINCT dayofweek_trans_temp.dayofweek_list) as dayofweek_list"),
            DB::raw("array_agg(DISTINCT dayofweek_trans_temp.dayofweek) as dayofweek_cd_list"),
            DB::raw("array_agg(DISTINCT dayofweek_trans_temp.public_holiday_status_list) as public_holiday_status_list"),
            DB::raw("array_agg(DISTINCT dayofweek_trans_temp.public_holiday_status) as public_holiday_status_cd_list"),
        )
        ->joinSub($weekQuery, 'dayofweek_trans_temp', function ($join) {
            $join->on('dayofweek_trans_temp.irregular_id', '=', 'irregular_dayofweek.irregular_id');
            $join->on('dayofweek_trans_temp.date_type', '=', 'irregular_dayofweek.date_type');
        })
        ->groupBy(
            'irregular_dayofweek.irregular_id',
            'irregular_dayofweek.date_type',
        );

        return $query;
    }

    /**
     * 【C_L_30_リードタイムAPIフロント】
     * イレギュラー一覧結合
     *
     * @return Collection
     */
    public function unionIrregularList($cursor1, $cursor2, $cursor3): Collection
    {
        $allItems = new Collection();

        if (!is_null($cursor1)) {
            $allItems = $allItems->merge($cursor1);
        }
        if (!is_null($cursor2)) {
            $allItems = $allItems->merge($cursor2);
        }
        if (!is_null($cursor3)) {
            $allItems = $allItems->merge($cursor3);
        }

        return $allItems;
    }
}
