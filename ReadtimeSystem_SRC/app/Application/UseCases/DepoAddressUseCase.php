<?php

namespace App\Application\UseCases;

use App\Domain\Entities\DepoPrefEntity;
use App\Domain\Entities\ResultEntity;
use App\Domain\Factories\DepoItemInfoFactory;
use App\Domain\Repositories\DepoAddressLeadtimeRepositoryInterface;
use DB;
use Exception;
use stdClass;
use Validator;

class DepoAddressUseCase
{

    // デポ取扱商品情報
    private $iDepoItemInfoRepository;

    /**
     * コンストラクタ
     */
    public function __construct(
        DepoAddressLeadtimeRepositoryInterface $iDepoAddressLeadtimeRepository
    ) {
        $this->iDepoAddressLeadtimeRepository = $iDepoAddressLeadtimeRepository;
    }
    
    /**
     * デポ紐付き都道府県Entity（リスト＋最大数のデポの選択状態）取得
     *
     * @param integer $depoCd
     * @return DepoPrefEntity
     */
    public function findDepoPrefEntity(int $depoCd): DepoPrefEntity
    {
        $collection = $this->iDepoAddressLeadtimeRepository->findDepoPrefCollection($depoCd);

        $entity = new DepoPrefEntity();
        $entity->depoCd = $depoCd;
        $entity->prefList = $collection->map(function($leadtime){
            $obj = new stdClass;
            $obj->prefCd = $leadtime->pref_cd;
            $obj->prefName = $leadtime->pref_name;
            return $obj;
        })->all();
        $countMaxPref = $collection->sortByDesc('total')->first();
        if($countMaxPref) {
            $entity->selectPref = $countMaxPref->pref_cd;
        }

        return $entity;
    }

    /**
     * デポ取扱商品リストの取得
     *
     * @param integer $depocd
     * @return array
     */
    public function findDepoItemInfoList(?int $depocd): array
    {
        $result = [];
        if (!is_null($depocd)) {
            $result = $this->iDepoItemInfoRepository->findDepoItemInfoList($depocd);
        }

        return $result;
    }

    /**
     * デポ取扱商品の削除・登録・更新する
     *
     * @param integer $depocd
     * @param array $depoItemList
     * @return void
     */
    public function upsert(int $depocd, array $depoItemList): ResultEntity
    {
        $result = new ResultEntity();
        // デポ取扱商品の取得
        $depoItemInfoList = $this->iDepoItemInfoRepository->findDepoItemInfoDeletedAtAllList($depocd);
        $depoItemInfoCollect = collect($depoItemInfoList);

        try {
            DB::beginTransaction();
            foreach ($depoItemList as $depoItem) {
                // チェック処理
                $validator = Validator::make(['depoCd' => $depocd,'itemCd' => $depoItem['itemCd']], [
                    'depoCd' => 'required|integer',
                    'itemCd' => 'required|string'
                ]);
                if ($validator->fails()) {
                    throw new Exception($validator);
                }
                // entity作成
                $entity = (new DepoItemInfoFactory())->makeUpdate(
                    $depocd,
                    $depoItem['itemCd']
                );

                // 差分チェック,
                $item = $depoItemInfoCollect
                ->filter(function ($item) use ($depoItem,$depocd) {
                    if ($item->itemCd == $depoItem['itemCd'] &&
                    $item->depoCd == $depocd) {
                        return true;
                    } else {
                        return false;
                    }
                })->first();
                if (is_null($item)) {
                    // 新規
                    $this->iDepoItemInfoRepository->save($entity);
                } else {
                    // 削除されている場合は復元
                    if (!is_null($item->deletedAt)) {
                        // リストア
                        $this->iDepoItemInfoRepository->restore($item->depoItemInfoId);
                    }
                }
            }

            // リストないものをDBから削除
            $paramCollection = collect($depoItemList);
            foreach ($depoItemInfoList as $itemInfo) {
                $diffItem = $paramCollection
                ->filter(function ($item) use ($itemInfo,$depocd) {
                    if ($item['itemCd'] == $itemInfo->itemCd &&
                    $depocd == $itemInfo->depoCd) {
                        return true;
                    } else {
                        return false;
                    }
                })->first();
                if (is_null($diffItem)) {
                    // 削除
                    $this->iDepoItemInfoRepository->delete($itemInfo->depoItemInfoId);
                }
            }
    
            DB::commit();
            $result->success();
        } catch (Exception $ex) {
            DB::rollBack();
            $result->exception = $ex;
            $result->failure($ex->getMessage());
        }

        return $result;
    }

    /**
     * デポ住所リードタイム情報不要データ削除
     *
     * @param array $unnecessaryDepoList
     * @return array
     */
    public function deleteDepoAddressUnnecessary($unnecessaryDepoList)
    {
        $result = $this->iDepoAddressLeadtimeRepository->deleteDepoAddressUnnecessary($unnecessaryDepoList);

        return $result;
    }

    /**
     * 住所を取り扱っているデポの一覧を取得する
     *
     * @param array $addressList
     * @return array
     */
    public function findSimilarAddressDepo(array $addressList): array
    {
        $resultList = [];

        $resultList = $this->iDepoAddressLeadtimeRepository->findSimilarAddressDepo($addressList);

        return $resultList;
    }
}
