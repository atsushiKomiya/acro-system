<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\DepoAddressLeadtimeRepositoryInterface;
use App\Domain\Repositories\DepoItemInfoRepositoryInterface;
use App\Domain\Repositories\ViewAddressRepositoryInterface;

use Illuminate\Support\Facades\Config;

class DefaultCsvDownloadUseCase extends BaseCsvExportUseCase
{

    // デポ住所リードタイム情報
    private $iDepoAddressLeadtimeRepository;
    // デポ商品紐付け
    private $iDepoItemInfoRepository;
    // デフォルトリスト
    private $iViewAddressRepository;

    /**
     * コンストラクタ
     *
     * @param DepoAddressLeadtimeRepositoryInterface $iDepoAddressLeadtimeRepository
     * @param DepoItemInfoRepositoryInterface $iDepoItemInfoRepository
     * @param ViewAddressRepositoryInterface $iViewAddressRepository
     */
    public function __construct(
        DepoAddressLeadtimeRepositoryInterface $iDepoAddressLeadtimeRepository,
        DepoItemInfoRepositoryInterface $iDepoItemInfoRepository,
        ViewAddressRepositoryInterface $iViewAddressRepository
    ) {
        $this->iDepoAddressLeadtimeRepository = $iDepoAddressLeadtimeRepository;
        $this->iDepoItemInfoRepository = $iDepoItemInfoRepository;
        $this->iViewAddressRepository = $iViewAddressRepository;
    }

    /**
     * Leadtimeタブ用のCSV作成処理
     *
     * @param [type] $pref
     * @return void
     */
    public function leadtimeCsv(int $depocd)
    {
        // カーソル取得
        $model = $this->iDepoAddressLeadtimeRepository->findLeadtimeAddressListCsv($depocd, null);
        // CSV作成
        $this->makeStreamCSV('lead_time', $model);
    }

    /**
     * デポ商品コード紐付情報タブ用のCSV作成処理
     *
     * @param [type] $pref
     * @return void
     */
    public function depoItemCsv(int $depocd)
    {
        // カーソル取得
        $model = $this->iDepoItemInfoRepository->findDepoItemInfoListCsv($depocd);
        // CSV作成
        $this->makeStreamCSV('depo_item', $model);
    }

    /**
     * デポ住所コード紐付情報タブ用のCSV作成処理
     *
     * @param [type] $pref
     * @return void
     */
    public function depoAddressCsv(int $depocd, ?int $pref)
    {
        // カーソル取得
        $model = $this->iDepoAddressLeadtimeRepository->findLeadtimeAddressListCsv($depocd, $pref);
        // CSV作成
        $this->makeStreamCSV('depo_address', $model);
    }

    /**
     * デフォルトリストのCSV作成処理
     *
     * @param [type] $pref
     * @return void
     */
    public function defaultListCsv($prefCd, $depoCd, $itemCategoryLargecd, $itemCategoryMediumcd ,$itemCd, $isConfig, $names)
    {
        $model = $this->iViewAddressRepository->findDepoDefaultList($prefCd, $depoCd, $itemCategoryLargecd, $itemCategoryMediumcd ,$itemCd, $isConfig);
        $func = function ($cursor) {
            $returnRow = $cursor;
            // 時間指定変換
            $timeSelectList = Config::get('delivery.time_select_list');

            if (is_numeric($returnRow['next_day_time_type'])) {
                $returnRow['next_day_time_type'] = $timeSelectList[$returnRow['next_day_time_type']];
            } elseif (is_bool($returnRow['next_day_time_type'])) {
                $returnRow['next_day_time_type'] = $returnRow['next_day_time_type'] ? '時間指定不可' : '';
            }

            if (is_numeric($returnRow['next_day_time_deadline'])) {
                $returnRow['next_day_time_deadline'] = $timeSelectList[$returnRow['next_day_time_deadline']];
            }
           
            if (is_numeric($returnRow['today_time_deadline1'])) {
                $returnRow['today_time_deadline1'] = $timeSelectList[$returnRow['today_time_deadline1']];
            }
            
            if (is_numeric($returnRow['today_time_deadline2'])) {
                $returnRow['today_time_deadline2'] = $timeSelectList[$returnRow['today_time_deadline2']];
            }
            
            if (is_bool($returnRow['is_area_today_delivery_flg'])) {
                $returnRow['is_area_today_delivery_flg'] = $returnRow['is_area_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['mon_before_deadline_flg'])) {
                $returnRow['mon_before_deadline_flg'] = $returnRow['mon_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['mon_today_delivery_flg'])) {
                $returnRow['mon_today_delivery_flg'] = $returnRow['mon_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['tue_before_deadline_flg'])) {
                $returnRow['tue_before_deadline_flg'] = $returnRow['tue_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['tue_today_delivery_flg'])) {
                $returnRow['tue_today_delivery_flg'] = $returnRow['tue_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['wed_before_deadline_flg'])) {
                $returnRow['wed_before_deadline_flg'] = $returnRow['wed_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['wed_today_delivery_flg'])) {
                $returnRow['wed_today_delivery_flg'] = $returnRow['wed_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['thu_before_deadline_flg'])) {
                $returnRow['thu_before_deadline_flg'] = $returnRow['thu_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['thu_today_delivery_flg'])) {
                $returnRow['thu_today_delivery_flg'] = $returnRow['thu_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['fri_before_deadline_flg'])) {
                $returnRow['fri_before_deadline_flg'] = $returnRow['fri_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['fri_today_delivery_flg'])) {
                $returnRow['fri_today_delivery_flg'] = $returnRow['fri_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['sat_before_deadline_flg'])) {
                $returnRow['sat_before_deadline_flg'] = $returnRow['sat_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['sat_today_delivery_flg'])) {
                $returnRow['sat_today_delivery_flg'] = $returnRow['sat_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['sun_before_deadline_flg'])) {
                $returnRow['sun_before_deadline_flg'] = $returnRow['sun_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['sun_today_delivery_flg'])) {
                $returnRow['sun_today_delivery_flg'] = $returnRow['sun_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['holi_before_deadline_flg'])) {
                $returnRow['holi_before_deadline_flg'] = $returnRow['holi_before_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['holi_before_today_delivery_flg'])) {
                $returnRow['holi_before_today_delivery_flg'] = $returnRow['holi_before_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['holi_deadline_flg'])) {
                $returnRow['holi_deadline_flg'] = $returnRow['holi_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['holi_today_delivery_flg'])) {
                $returnRow['holi_today_delivery_flg'] = $returnRow['holi_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['holi_after_deadline_flg'])) {
                $returnRow['holi_after_deadline_flg'] = $returnRow['holi_after_deadline_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['holi_after_today_delivery_flg'])) {
                $returnRow['holi_after_today_delivery_flg'] = $returnRow['holi_after_today_delivery_flg'] ? '〇' : '×';
            }
            if (is_bool($returnRow['private_home_flg'])) {
                $returnRow['private_home_flg'] = $returnRow['private_home_flg'] ? '〇' : '×';
            }
            // 慶弔区分
            $keichoTypeList = Config::get('delivery.keicho_type');
            if (!is_null($returnRow['congratulation_kbn_flg'])) {
                $returnRow['congratulation_kbn_flg'] = $keichoTypeList[$returnRow['congratulation_kbn_flg']];
            }
            return $returnRow;
        };
        $this->makeStreamDynamicCSV('default_list', $model, $func, $names);
    }
}
