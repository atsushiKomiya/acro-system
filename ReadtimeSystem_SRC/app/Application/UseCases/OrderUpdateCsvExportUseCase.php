<?php

namespace App\Application\UseCases;

use App\Application\Utilities\AppUtility;
use App\Domain\Entities\ChgDepoInfoEntity;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class OrderUpdateCsvExportUseCase extends BaseCsvExportUseCase
{

    /**
     * コンストラクタ
     */
    public function __construct(
    ) {
    }


     /**
     * 受注データ更新用CSV出力
     *
     * @param array $depoCdList デポコードの配列
     * @param array $addressList　prefCd,siku,tyouの連想配列
     * @param array $itemList　itemCategoryLargeCd,itemCategoryMediumCd,itemCdの連想配列
     * @param string $from　yyyyMMddの8桁
     * @param string $to　yyyyMMddの8桁
     * @param array $dayofweekList　dayofweek,publicHolidayStatusの連想配列
     * 
     * @return bool
     */
    public function chgDepoInfoCsv(?array $depoCdList, ?array $addressList, ?array $itemList, ?string $from, ?string $to, ?array $dayofweekList)
    {
        $chgDepoInfoEntityList = $this->getEntityList($depoCdList, $addressList, $itemList, $from, $to, $dayofweekList);
        return $this->outputFiles($chgDepoInfoEntityList);
    }

    /**
     * from, toの形式チェック 
     *
     * @param string|null $from yyyyMMddの8桁
     * @param string|null $to yyyyMMddの8桁
     * @return void
     */
    private function checkFromTo(?string $from, ?string $to){
        // from
        if ($from) {
            // 数値チェック
            if (!(strlen($from) == 8) || !preg_match('/^[0-9]+$/', $from)) {
                // エラー
                Log::channel('daily')->error('期間FROMには半角数字８桁を指定してください');
                throw new Exception("期間FROMには半角数字８桁を指定してください");
            }
        }
        // to
        if ($to) {
            // 数値チェック
            if (!(strlen($to) == 8) || !preg_match('/^[0-9]+$/', $to)) {
                // エラー
                Log::channel('daily')->error('期間TOには半角数字８桁を指定してください');
                throw new Exception("期間TOには半角数字８桁を指定してください");
            }
        }
    }

    /**
     * 受注データ更新用CSV出力データを生成する
     *
     * @param array $depoCdList デポコードの配列
     * @param array $addressList　prefCd,siku,tyouの連想配列
     * @param array $itemList　itemCategoryLargeCd,itemCategoryMediumCd,itemCdの連想配列
     * @param string $from　yyyyMMddの8桁
     * @param string $to　yyyyMMddの8桁
     * @param array $dayofweekList　dayofweek,publicHolidayStatusの連想配列
     * 
     * @return array
     */
    private function getEntityList(?array $depoCdList, ?array $addressList, ?array $itemList, ?string $from, ?string $to, ?array $dayofweekList)
    {
        // パラメータ
        $depoCdList = $depoCdList ? $depoCdList : [];
        $addressList = $addressList ? $addressList : [];
        $itemList = $itemList ? $itemList : [];
        $dayofweekList = $dayofweekList ? $dayofweekList : [];

        $chgDepoInfoEntityList = array();
        // チェック処理
        Log::channel('daily')->info('パラメータチェック処理を開始');
        $this->checkFromTo($from, $to);
        Log::channel('daily')->info('パラメータチェック処理を終了');

        // CSV出力用配列生成処理
        Log::channel('daily')->info('CSV出力用配列生成処理開始');
        $chgDepoInfoEntityList = $this->generateEntityList($depoCdList, $addressList, $itemList, $from, $to, $dayofweekList);
        Log::channel('daily')->info('CSV出力用配列生成処理終了');

        return $chgDepoInfoEntityList;
    }

     /**
     * 受注データ更新用CSV出力(カレンダーデータ更新バッチ用)
     *
     * @param array $depoInfoList depoCd,from,toの連想配列の配列
     * @return bool
     */
    public function chgDepoInfoCsvReloadCalendar(array $depoInfoList)
    {
        $chgDepoInfoEntityList = $this->getEntityListReloadCalendar($depoInfoList);
        return $this->outputFiles($chgDepoInfoEntityList);
    }

    /**
     * 受注データ更新用CSV出力データを生成する(カレンダーデータ更新バッチ用)
     *
     * @param array $depoInfoList depoCd,from,toの連想配列の配列
     * @return array
     */
    private function getEntityListReloadCalendar(array $depoInfoList)
    {

        $chgDepoInfoEntityList = array();

        // チェック処理
        Log::channel('daily')->info('パラメータチェック処理を開始');
        foreach ($depoInfoList as $depoInfo){
            // パラメータ
            $from = $depoInfo['from'];
            $to = $depoInfo['to'];

            $this->checkFromTo($from, $to);
        }
        Log::channel('daily')->info('パラメータチェック処理を終了');

        // CSV出力用配列生成処理
        Log::channel('daily')->info('CSV出力用配列生成処理開始');
        foreach ($depoInfoList as $depoInfo){
            // パラメータ
            $depoCd= $depoInfo['depoCd'];
            $from = $depoInfo['from'];
            $to = $depoInfo['to'];
            $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $this->generateEntityList([$depoCd], [], [], $from, $to, []));
        }
        Log::channel('daily')->info('CSV出力用配列生成処理終了');

        return $chgDepoInfoEntityList;
    }

    /**
     * 受注データ更新用CSVファイルとトリガーファイルを出力する
     *
     * @param array $chgDepoInfoEntityList 出力内容のリスト
     * @return bool
     */
    private function outputFiles(array $chgDepoInfoEntityList)
    {
        // ファイルディレクトリ
        $fileDir = Config::get('csvexp.file_dir.chg_depo_info');
        // ファイル名
        $fileName = Config::get('csvexp.file_name.chg_depo_info');
        // ファイル名のタイムスタンプ部分のフォーマット
        $timeStampFormat = 'YmdHisv'; // yyyyMMddHHmmssSSS
        // CSVファイル名（フルパス）
        $fullName = $fileDir . AppUtility::createFileName($fileName, $timeStampFormat);
        // トリガーファイル名（フルパス）
        $trgFileName = str_replace('.csv', '.trg', $fullName);

        try {
            // CSV作成
            Log::channel('daily')->info('受注データ更新用CSV出力処理開始');
            if (count($chgDepoInfoEntityList) != 0) {
                $this->makeCSVLocalFile('chg_depo_info', $chgDepoInfoEntityList, $fullName, null, function ($entity) {
                    $model = json_decode(json_encode($entity), true);
                    return $model;
                });
                // 成功時にトリガーファイル作成
                $createTrgFile = fopen($trgFileName, 'w');
                fclose($createTrgFile);
            }
            Log::channel('daily')->info('受注データ更新用CSV出力処理終了');
        } catch (Exception $ex) {
            Log::channel('daily')->error($ex->getMessage());
            // ファイル削除
            if (\file_exists($fullName)) {
                unlink($fullName);
            }
            if (\file_exists($trgFileName)) {
                unlink($trgFileName);
            }
            throw new Exception('受注更新用CSV出力に失敗しました');
        }

        return true;
    }


    /**
     * CSV出力用Entity生成
     *
     * @param array $depoCdList
     * @param array $addressList
     * @param array $itemList
     * @param string|null $from
     * @param string|null $to
     * @param array $dayofweekList
     * @return array
     */
    private function generateEntityList(array $depoCdList, array $addressList, array $itemList, ?string $from, ?string $to, array $dayofweekList)
    {
        $chgDepoInfoEntityList = array();
        $baseEntity = new ChgDepoInfoEntity();
        $baseEntity->ymdFrom = $from;
        $baseEntity->ymdTo = $to;
        if (count($depoCdList) != 0) {
            foreach ($depoCdList as $depoCd) {
                $chgDepoInfoEntity = clone $baseEntity;
                $chgDepoInfoEntity->depoCd = $depoCd;
                $list = $this->entitySetAddress($chgDepoInfoEntity, $addressList, $itemList, $dayofweekList);
                $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
            }
        } else {
            $list = $this->entitySetAddress($baseEntity, $addressList, $itemList, $dayofweekList);
            $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
        }

        return $chgDepoInfoEntityList;
    }

    /**
     * 住所情報設定
     *
     * @param ChgDepoInfoEntity $baseEntity
     * @param array $addressList
     * @param array $itemList
     * @param array $dayofweekList
     * @return array
     */
    private function entitySetAddress(ChgDepoInfoEntity $baseEntity, array $addressList, array $itemList, array $dayofweekList)
    {
        $chgDepoInfoEntityList = array();
        if (count($addressList) != 0) {
            foreach ($addressList as $address) {
                $chgDepoInfoEntity = clone $baseEntity;

                $chgDepoInfoEntity->prefCd = $address['prefCd'];
                $chgDepoInfoEntity->siku = $address['siku'];
                $chgDepoInfoEntity->tyou = $address['tyou'];

                // 商品設定
                $list = $this->entitySetItem($chgDepoInfoEntity, $itemList, $dayofweekList);
                $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
            }
        } else {
            // 商品設定
            $list = $this->entitySetItem($baseEntity, $itemList, $dayofweekList);
            $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
        }

        return $chgDepoInfoEntityList;
    }

    /**
     * 商品コード設定
     *
     * @param ChgDepoInfoEntity $baseEntity
     * @param array $itemList
     * @param array $dayofweekList
     * @return array
     */
    private function entitySetItem(ChgDepoInfoEntity $baseEntity, array $itemList, $dayofweekList)
    {
        $chgDepoInfoEntityList = array();
        if (count($itemList) != 0) {
            foreach ($itemList as $item) {
                $chgDepoInfoEntityTmpItem = clone $baseEntity;
                $chgDepoInfoEntityTmpItem->itemCategoryLargeCd = $item['itemCategoryLargeCd'];
                $chgDepoInfoEntityTmpItem->itemCategoryMediumCd = $item['itemCategoryMediumCd'];
                $chgDepoInfoEntityTmpItem->itemCd = $item['itemCd'];

                // 曜日設定
                $list = $this->entitySetDayofweek($chgDepoInfoEntityTmpItem, $dayofweekList);
                $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
            }
        } else {
            // 曜日設定
            $list = $this->entitySetDayofweek($baseEntity, $dayofweekList);
            $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
        }

        return $chgDepoInfoEntityList;
    }

    /**
     * 曜日、祝日設定
     *
     * @param ChgDepoInfoEntity $baseEntity
     * @param array $dayofweekList
     * @return array
     */
    private function entitySetDayofweek(ChgDepoInfoEntity $baseEntity, $dayofweekList)
    {
        $chgDepoInfoEntityList = array();
        if (count($dayofweekList) != 0) {
            foreach ($dayofweekList as $dayofweek) {
                $chgDepoInfoEntityTmpDayofweek = clone $baseEntity;
                $chgDepoInfoEntityTmpDayofweek->dayofweek = $dayofweek['dayofweek'];
                $chgDepoInfoEntityTmpDayofweek->publicHolidayStatus = $dayofweek['publicHolidayStatus'];
                // CSV出力リストに追加
                $chgDepoInfoEntityList[] = $chgDepoInfoEntityTmpDayofweek;
            }
        } else {
            $chgDepoInfoEntityList[] =  $baseEntity;
        }

        return $chgDepoInfoEntityList;
    }
}
