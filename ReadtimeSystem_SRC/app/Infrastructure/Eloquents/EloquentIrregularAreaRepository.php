<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\IrregularAreaEntity;
use App\Domain\Factories\IrregularAreaFactory;
use App\Domain\Models\IrregularArea;
use App\Domain\Repositories\IrregularAreaRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EloquentIrregularAreaRepository implements IrregularAreaRepositoryInterface
{
    // Model
    private $eloquent;
    // // ファクトリを格納するプロパティ
    private $factory;

    /**
     * コンストラクタ
     *
     * @param Irregular $irregular
     */
    public function __construct(IrregularArea $irregularArea, IrregularAreaFactory $factory)
    {
        $this->eloquent = $irregularArea;
        $this->factory = $factory;
    }

    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularArea($irregularId): array
    {
        $irregularAreaFactory = $this->factory;
        // 都道府県一時テーブル query
        $prefQuery = DB::table('view_address')->select(
            'pref',
            'pref_name'
        )->distinct(
            'pref'
        );

        // メインQuery
        $result = $this->eloquent::select(
            'irregular_area.irregular_area_id AS irregular_area_id',
            'irregular_area.addr_cd AS addr_cd',
            'irregular_area.zip_cd AS zipcode',
            'irregular_area.pref_cd AS pref_cd',
            'irregular_area.siku AS siku',
            'irregular_area.tyou AS tyou',
            'irregular_area.created_id AS created_id',
            'irregular_area.created_at AS created_at',
            'irregular_area.updated_id AS updated_id',
            'irregular_area.updated_at AS updated_at',
            'view_address.pref_name AS pref_name'
        )
        ->joinSub($prefQuery, 'view_address', function ($join) {
            $join->on('view_address.pref', '=', 'irregular_area.pref_cd');
        })
        ->where('irregular_id', $irregularId)
        ->get()
        ->map(function ($item) use ($irregularAreaFactory) {
            return $irregularAreaFactory->make($item);
        })->all();

        return $result;
    }

    /**
     * イレギュラー設定
     *
     * @param IrregularAreaEntity $entity
     * @return void
     */
    public function save(IrregularAreaEntity $entity)
    {
        $irregularArea = $this->eloquent::find($entity->irregularAreaId);

        if (is_null($irregularArea)) {
            $irregularArea = new IrregularArea();
        }

        $irregularArea->irregular_id = $entity->irregularId;
        $irregularArea->addr_cd = $entity->addrCd;
        $irregularArea->zip_cd = $entity->zipcode;
        $irregularArea->pref_cd = $entity->prefCd;
        $irregularArea->siku = $entity->siku;
        $irregularArea->tyou = $entity->tyou;

        $irregularArea->save();
    }

    /**
     * イレギュラーエリア削除（PK）
     *
     * @param integer $irregularAreaId
     * @param integer $loginCd
     * @return void
     */
    public function deleteById(
        int $irregularAreaId,
        int $loginCd
    )
    {
        $model = $this->eloquent::where('irregular_area_id', $irregularAreaId)
        ->update([
            'deleted_id' => $loginCd,
            'deleted_at' => now()
        ]);
        
        return $model;
    }

    /**
     * イレギュラーエリア削除
     *
     * @param integer $irregularId
     * @param integer $loginCd
     * @return void
     */
    public function deleteByIrregularId(int $irregularId, int $loginCd)
    {
        $model = $this->eloquent::where('irregular_id', $irregularId)
        ->update([
            'deleted_id' => $loginCd,
            'deleted_at' => now()
        ]);
        
        return $model;
    }
}
