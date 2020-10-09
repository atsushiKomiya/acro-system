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
            $returnRow = array(); 
            $returnRow['addrcd'] = $cursor->addrcd;
            $returnRow['jiscode'] = $cursor->jiscode;
            $returnRow['zipcode'] = $cursor->zipcode;
            $returnRow['pref'] = $cursor->pref;
            $returnRow['siku'] = $cursor->siku;
            $returnRow['tyou'] = $cursor->tyou;
            $returnRow['deponame1'] = $cursor->deponame1;
            $returnRow['deponame2'] = $cursor->deponame2;
            $returnRow['depo_lead_time'] = $cursor->depo_lead_time;
            $returnRow['depo_cd'] = $cursor->depo_cd;
            $returnRow['transfer_post_depo_cd'] = $cursor->transfer_post_depo_cd;
            $returnRow['next_day_time_type'] = $cursor->next_day_time_type;
            $returnRow['next_day_time_deadline'] = $cursor->next_day_time_deadline;
            $returnRow['today_time_deadline1'] = $cursor->today_time_deadline1;
            $returnRow['today_time_deadline2'] = $cursor->today_time_deadline2;
            $returnRow['is_area_today_delivery_flg'] = $cursor->is_area_today_delivery_flg;
            $returnRow['mon_before_deadline_flg'] = $cursor->mon_before_deadline_flg;
            $returnRow['mon_today_delivery_flg'] = $cursor->mon_today_delivery_flg;
            $returnRow['tue_before_deadline_flg'] = $cursor->tue_before_deadline_flg;
            $returnRow['tue_today_delivery_flg'] = $cursor->tue_today_delivery_flg;
            $returnRow['wed_before_deadline_flg'] = $cursor->wed_before_deadline_flg;
            $returnRow['wed_today_delivery_flg'] = $cursor->wed_today_delivery_flg;
            $returnRow['thu_before_deadline_flg'] = $cursor->thu_before_deadline_flg;
            $returnRow['thu_today_delivery_flg'] = $cursor->thu_today_delivery_flg;
            $returnRow['fri_before_deadline_flg'] = $cursor->fri_before_deadline_flg;
            $returnRow['fri_today_delivery_flg'] = $cursor->fri_today_delivery_flg;
            $returnRow['sat_before_deadline_flg'] = $cursor->sat_before_deadline_flg;
            $returnRow['sat_today_delivery_flg'] = $cursor->sat_today_delivery_flg;
            $returnRow['sun_before_deadline_flg'] = $cursor->sun_before_deadline_flg;
            $returnRow['sun_today_delivery_flg'] = $cursor->sun_today_delivery_flg;
            $returnRow['holi_before_deadline_flg'] = $cursor->holi_before_deadline_flg;
            $returnRow['holi_before_today_delivery_flg'] = $cursor->holi_before_today_delivery_flg;
            $returnRow['holi_deadline_flg'] = $cursor->holi_deadline_flg;
            $returnRow['holi_today_delivery_flg'] = $cursor->holi_today_delivery_flg;
            $returnRow['holi_after_deadline_flg'] = $cursor->holi_after_deadline_flg;
            $returnRow['holi_after_today_delivery_flg'] = $cursor->holi_after_today_delivery_flg;
            $returnRow['private_home_flg'] = $cursor->private_home_flg;
            $returnRow['handing_flg'] = $cursor->handing_flg;
            $returnRow['congratulation_kbn_flg'] = $cursor->congratulation_kbn_flg;
            // 時間指定変換
            $timeSelectList = Config::get('delivery.time_select_list');

            if (is_numeric($cursor->next_day_time_type)) {
                $returnRow['next_day_time_type'] = $timeSelectList[$cursor->next_day_time_type];
            } elseif (is_bool($cursor->next_day_time_type)) {
                $returnRow['next_day_time_type'] = $cursor->next_day_time_type ? '時間指定不可' : '';
            }

            if (is_numeric($cursor->next_day_time_deadline)) {
                $returnRow['next_day_time_deadline'] = $timeSelectList[$cursor->next_day_time_deadline];
            }
           
            if (is_numeric($cursor->today_time_deadline1)) {
                $returnRow['today_time_deadline1'] = $timeSelectList[$cursor->today_time_deadline1];
            }
            
            if (is_numeric($cursor->today_time_deadline2)) {
                $returnRow['today_time_deadline2'] = $timeSelectList[$cursor->today_time_deadline2];
            }
            
            if (is_bool($cursor->is_area_today_delivery_flg)) {
                $returnRow['is_area_today_delivery_flg'] = $cursor->is_area_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->mon_before_deadline_flg)) {
                $returnRow['mon_before_deadline_flg'] = $cursor->mon_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->mon_today_delivery_flg)) {
                $returnRow['mon_today_delivery_flg'] = $cursor->mon_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->tue_before_deadline_flg)) {
                $returnRow['tue_before_deadline_flg'] = $cursor->tue_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->tue_today_delivery_flg)) {
                $returnRow['tue_today_delivery_flg'] = $cursor->tue_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->wed_before_deadline_flg)) {
                $returnRow['wed_before_deadline_flg'] = $cursor->wed_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->wed_today_delivery_flg)) {
                $returnRow['wed_today_delivery_flg'] = $cursor->wed_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->thu_before_deadline_flg)) {
                $returnRow['thu_before_deadline_flg'] = $cursor->thu_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->thu_today_delivery_flg)) {
                $returnRow['thu_today_delivery_flg'] = $cursor->thu_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->fri_before_deadline_flg)) {
                $returnRow['fri_before_deadline_flg'] = $cursor->fri_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->fri_today_delivery_flg)) {
                $returnRow['fri_today_delivery_flg'] = $cursor->fri_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->sat_before_deadline_flg)) {
                $returnRow['sat_before_deadline_flg'] = $cursor->sat_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->sat_today_delivery_flg)) {
                $returnRow['sat_today_delivery_flg'] = $cursor->sat_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->sun_before_deadline_flg)) {
                $returnRow['sun_before_deadline_flg'] = $cursor->sun_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->sun_today_delivery_flg)) {
                $returnRow['sun_today_delivery_flg'] = $cursor->sun_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->holi_before_deadline_flg)) {
                $returnRow['holi_before_deadline_flg'] = $cursor->holi_before_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->holi_before_today_delivery_flg)) {
                $returnRow['holi_before_today_delivery_flg'] = $cursor->holi_before_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->holi_deadline_flg)) {
                $returnRow['holi_deadline_flg'] = $cursor->holi_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->holi_today_delivery_flg)) {
                $returnRow['holi_today_delivery_flg'] = $cursor->holi_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->holi_after_deadline_flg)) {
                $returnRow['holi_after_deadline_flg'] = $cursor->holi_after_deadline_flg ? '〇' : '×';
            }
            if (is_bool($cursor->holi_after_today_delivery_flg)) {
                $returnRow['holi_after_today_delivery_flg'] = $cursor->holi_after_today_delivery_flg ? '〇' : '×';
            }
            if (is_bool($cursor->private_home_flg)) {
                $returnRow['private_home_flg'] = $cursor->private_home_flg ? '〇' : '×';
            }
            if (is_bool($cursor->handing_flg)) {
                $returnRow['handing_flg'] = $cursor->handing_flg ? '〇' : '×';
            }
            // 慶弔区分
            $keichoTypeList = Config::get('delivery.keicho_type');
            if (!is_null($cursor->congratulation_kbn_flg)) {
                $returnRow['congratulation_kbn_flg'] = $keichoTypeList[$cursor->congratulation_kbn_flg];
            }
            return $returnRow;
        };
        $this->makeStreamDynamicCSV('default_list', $model, $func, $names);
    }
}
