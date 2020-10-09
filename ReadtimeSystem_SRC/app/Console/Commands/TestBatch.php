<?php

namespace App\Console\Commands;

use App\Application\UseCases\DepoCalInfoUseCase;
use App\Application\UseCases\DepoCalInfoTmpUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;

use DB;
use Illuminate\Console\Command;

class TestBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CleanUPバッチ';

    /**
     * Create a new command instance.
     * @param DepoCalInfoUseCase $depoCalInfoUC
     * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUC
     * @param DepoCalAprInfoUseCase $depoCalAprInfoUC
     * @return void
     */
    public function __construct(DepoCalAprInfoUseCase $depoCalInfoUC)
    {
        parent::__construct();
        $this->depoCalInfoUC = $depoCalInfoUC;
    }

    private $depoCalInfoUC;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
        ->orderBy('irregular_id','asc')
        ->orderBy('date_type','asc')
        ->orderBy('dayofweek','asc')
        ->orderBy('public_holiday_status','asc');

        $query = DB::table('irregular_dayofweek')->select(
            'irregular_dayofweek.irregular_id',
            'irregular_dayofweek.date_type',
            DB::raw("array_agg(DISTINCT dayofweek_trans_temp.dayofweek_list) as dayofweek_list"),
            DB::raw("array_agg(DISTINCT dayofweek_trans_temp.public_holiday_status_list) as public_holiday_status_list"),
        )
        ->joinSub($weekQuery , 'dayofweek_trans_temp', function($join){
            $join->on('dayofweek_trans_temp.irregular_id', '=', 'irregular_dayofweek.irregular_id');
            $join->on('dayofweek_trans_temp.date_type', '=', 'irregular_dayofweek.date_type');
        })
        ->groupBy(
            'irregular_dayofweek.irregular_id',
            'irregular_dayofweek.date_type',
        );

        // $result = $query->get()->all();
        // var_dump($result);
        var_dump($query->toSql(), $query->getBindings());
        exit;
    }
}
