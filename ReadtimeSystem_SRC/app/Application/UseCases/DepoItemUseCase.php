<?php

namespace App\Application\UseCases;

use App\Consts\AppConst;
use App\Domain\Entities\ResultEntity;
use App\Domain\Factories\DepoItemInfoFactory;
use App\Domain\Repositories\DepoItemInfoRepositoryInterface;
use Exception;
use Validator;

class DepoItemUseCase
{

    // デポ取扱商品情報
    private $iDepoItemInfoRepository;

    /**
     * コンストラクタ
     */
    public function __construct(
        DepoItemInfoRepositoryInterface $iDepoItemInfoRepository
    ) {
        $this->iDepoItemInfoRepository = $iDepoItemInfoRepository;
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
     * @return ResultEntity
     */
    public function upsert(int $depocd, array $depoItemList): ResultEntity
    {
        $result = new ResultEntity();
        // デポ取扱商品の取得
        $depoItemInfoList = $this->iDepoItemInfoRepository->findDepoItemInfoDeletedAtAllList($depocd);
        $depoItemInfoCollect = collect($depoItemInfoList);
        
        foreach ($depoItemList as $depoItem) {
            // チェック処理
            $validator = Validator::make(['depoCd' => $depocd,'itemCd' => $depoItem['itemCd'],'mode' => $depoItem['mode']], [
                'depoCd' => 'required|integer',
                'itemCd' => 'required|string',
                'mode' => "required|in:add,del"
            ]);
            if ($validator->fails()) {
                throw new Exception($validator);
            }
            // entity作成
            $entity = (new DepoItemInfoFactory())->makeUpdate(
                $depocd,
                $depoItem['itemCd']
            );
            
            // データ取得
            $item = $depoItemInfoCollect
            ->filter(function ($item) use ($depoItem,$depocd) {
                if ($item->itemCd == $depoItem['itemCd'] &&
                $item->depoCd == $depocd) {
                    return true;
                } else {
                    return false;
                }
            })->first();

            if ($depoItem['mode'] == AppConst::LIST_ADD_MODE) {
                if (is_null($item)) {
                    // 新規登録
                    $this->iDepoItemInfoRepository->save($entity);
                } else {
                    // リストア
                    $this->iDepoItemInfoRepository->restore($item->depoItemInfoId);
                }
            } elseif ($depoItem['mode'] == AppConst::LIST_DEL_MODE) {
                if (!is_null($item)) {
                    // 削除
                    $this->iDepoItemInfoRepository->delete($item->depoItemInfoId);
                }
            }
        }
        $result->success();

        return $result;
    }

    /**
     * デポ取扱商品不要データ削除
     *
     * @param array $unnecessaryDepoList
     * @return array
     */
    public function deleteDepoItemUnnecessary($unnecessaryDepoList)
    {
        $result = $this->iDepoItemInfoRepository->deleteDepoItemUnnecessary($unnecessaryDepoList);
        return $result;
    }

    /**
     * 商品を取り扱っているデポの一覧を取得する
     *
     * @param array $itemList
     * @return array
     */
    public function findSimilarItemDepo(array $itemList): array
    {
        $resultList = [];

        $resultList = $this->iDepoItemInfoRepository->findSimilarItemDepo($itemList);

        return $resultList;
    }
}
