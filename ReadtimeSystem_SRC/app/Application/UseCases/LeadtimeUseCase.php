<?php

namespace App\Application\UseCases;

use App\Consts\AppConst;
use App\Domain\Entities\ResultEntity;
use App\Domain\Factories\DepoAddressLeadtimeFactory;
use App\Domain\Repositories\DepoAddressLeadtimeRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\LazyCollection;
use Validator;

class LeadtimeUseCase
{

    // デポ住所リードタイム情報
    private $iDepoAddressLeadtimeRepository;

    /**
     * コンストラクタ
     */
    public function __construct(
        DepoAddressLeadtimeRepositoryInterface $iDepoAddressLeadtimeRepository
    ) {
        $this->iDepoAddressLeadtimeRepository = $iDepoAddressLeadtimeRepository;
    }

    /**
     * リードタイムアドレス一覧を取得する
     *
     * @param integer $depocd
     * @return void
     */
    public function findLeadtimeAddressList(int $depocd, ?int $pref)
    {
        return $this->iDepoAddressLeadtimeRepository->findLeadtimeAddressList($depocd, $pref);
    }

    /**
     * デポ住所紐付け用のリードタイムアドレス一覧を取得する
     *
     * @param integer $depocd
     * @return void
     */
    public function findDepoAddressListCursor(int $depocd, ?int $pref): LazyCollection
    {
        return $this->iDepoAddressLeadtimeRepository->findDepoAddressListCursor($depocd, $pref);
    }

    /**
     * リードタイムアドレスを更新する
     *
     * @param array $leadtimeList
     * @return ResultEntity
     */
    public function save(array $leadtimeList, $displayType): ResultEntity
    {
        $result = new ResultEntity();
        // 文字列から数値へ変換
        $displayType = intval($displayType);

        try {
            foreach ($leadtimeList as $leadtime) {
                // サプライズ 翌日時間指定 翌日締切時間 の選択された場合に例外
                if (
                    // サプライズデポ
                    $displayType === AppConst::DEPO_DISPLAY_CLS_SURP &&
                    (
                        // 翌日時間指定もしくは翌日締切時間の入力があった場合
                        intval($leadtime['nextDayTimeType']) > 0 ||
                        intval($leadtime['nextDayTimeDeadline']) > 0
                    )
                ) {
                    throw new Exception('surprise depo leadtime save error.', 4);
                // エンタメ 当日配送締切時間の指定をされた場合に例外
                } else if (
                    // エンタメデポ
                    $displayType === AppConst::DEPO_DISPLAY_CLS_ENTERME &&
                    (
                        // 当日配送締切時間の入力があった場合
                        intval($leadtime['todayTimeDeadline1']) > 0 ||
                        intval($leadtime['todayTimeDeadline2']) > 0 ||
                        $leadtime['isAreaTodayDeliveryFlg'] === true
                    )
                ) {
                    throw new Exception('entertainment depo leadtime save error.', 8);
                }
                // チェック処理
                $validator = Validator::make($leadtime, [
                    'depoAddressLeadtimeId' => 'required|integer',
                    'nextDayTimeType' => 'nullable|integer',
                    'isAreaTodayDeliveryFlg' => 'nullable|boolean',
                    'nextDayTimeDeadline' => 'nullable|integer',
                    'todayTimeDeadline1' => 'nullable|integer',
                    'todayTimeDeadline2' => 'nullable|integer',
                ]);
                if ($validator->fails()) {
                    throw new Exception($validator);
                }
                // entity作成
                $entity = (new DepoAddressLeadtimeFactory())->makeUpdate(
                    $leadtime['depoAddressLeadtimeId'],
                    $leadtime['nextDayTimeType'],
                    $leadtime['isAreaTodayDeliveryFlg'],
                    $leadtime['nextDayTimeDeadline'],
                    $leadtime['todayTimeDeadline1'],
                    $leadtime['todayTimeDeadline2']
                );
                // 更新
                $this->iDepoAddressLeadtimeRepository->save($entity);
            }
    
            $result->success();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            throw $ex;
        }

        return $result;
    }

    /**
     * デポ住所コード紐付けからリードタイムアドレスを更新する
     *
     * @param integer $depoCd
     * @param integer $prefCd
     * @param array $addressList
     * @return ResultEntity
     */
    public function saveDepoAddressForLeadtime(int $depoCd, array $addressList): ResultEntity
    {
        $result = new ResultEntity();

        // デポ住所コード紐付けの取得
        $depoAddressListCollect = collect($this->iDepoAddressLeadtimeRepository->findDepoLeadtimeAddressDeletedAtAllList($depoCd, null));
        foreach ($addressList as $address) {
            // entity作成
            $entity = (new DepoAddressLeadtimeFactory())->makeUpdateForDepoAddress(
                null,
                $depoCd,
                $address['zipcode'],
                $address['prefCd'],
                $address['jiscode'],
                $address['siku'],
                $address['tyou']
            );

            // 差分チェック,
            $leadtime = $depoAddressListCollect
            ->filter(function ($leadtime) use ($address,$depoCd) {
                if ($leadtime->prefCd == $address['prefCd'] &&
                $leadtime->siku == $address['siku'] &&
                $leadtime->tyou == $address['tyou'] &&
                $leadtime->depoCd == $depoCd) {
                    return true;
                } else {
                    return false;
                }
            })->first();

            if ($address['mode'] == AppConst::LIST_ADD_MODE) {
                if (is_null($leadtime)) {
                    // 新規登録
                    $this->iDepoAddressLeadtimeRepository->create($entity);
                } else {
                    // リストア
                    $this->iDepoAddressLeadtimeRepository->restore($leadtime->depoAddressLeadtimeId);
                }
            } elseif ($address['mode'] == AppConst::LIST_DEL_MODE) {
                if (!is_null($leadtime)) {
                    // 削除
                    $this->iDepoAddressLeadtimeRepository->delete($leadtime->depoAddressLeadtimeId);
                }
            }
        }

        $result->success();

        return $result;
    }
}
