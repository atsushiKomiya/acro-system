<?php

namespace App\Infrastructure\Eloquents;

use App\Domain\Entities\IrregularDepoEntity;
use App\Domain\Factories\IrregularDepoFactory;
use App\Domain\Models\IrregularDepo;
use App\Domain\Repositories\IrregularDepoRepositoryInterface;

class EloquentIrregularDepoRepository implements IrregularDepoRepositoryInterface
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
    public function __construct(IrregularDepo $irregularDepo, IrregularDepoFactory $factory)
    {
        $this->eloquent = $irregularDepo;
        $this->factory = $factory;
    }

    /**
     * イレギュラー設定の取得
     *
     * @return array
     */
    public function findIrregularDepo($irregularId): array
    {
        $irregularDepoFactory = $this->factory;
        $result = $this->eloquent::select(
            'irregular_depo.irregular_depo_id AS irregular_depo_id',
            'irregular_depo.depo_cd AS depocd',
            'irregular_depo.created_id AS created_id',
            'irregular_depo.created_at AS created_at',
            'irregular_depo.updated_id AS updated_id',
            'irregular_depo.updated_at AS updated_at',
            'view_depo.deponame AS deponame'
        )
        ->join('view_depo', 'view_depo.depocd', '=', 'irregular_depo.depo_cd')
        ->where('irregular_id', $irregularId)
        ->get()
        ->map(function ($item) use ($irregularDepoFactory) {
            return $irregularDepoFactory->make($item);
        })->all();

        return $result;
    }

    /**
     * イレギュラーデポ登録
     *
     * @param IrregularDepoEntity $entity
     * @return void
     */
    public function save(IrregularDepoEntity $entity)
    {
        $irregularDepo = $this->eloquent::find($entity->irregularDepoId);

        if (is_null($irregularDepo)) {
            $irregularDepo = new IrregularDepo();
        }

        $irregularDepo->irregular_id = $entity->irregularId;
        $irregularDepo->depo_cd = $entity->depoCd;

        $irregularDepo->save();
    }

    /**
     * イレギュラーデポ削除（PK）
     *
     * @param integer $irregularDepoId
     * @param integer $loginCd
     * @return void
     */
    public function deleteById(int $irregularDepoId, int $loginCd)
    {
        $model = $this->eloquent::where('irregular_depo_id', $irregularDepoId)
        ->update([
            'deleted_id' => $loginCd,
            'deleted_at' => now()
        ]);
        
        return $model;
    }
    
    /**
     * イレギュラーデポ削除
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
