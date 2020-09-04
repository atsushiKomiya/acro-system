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
     * @param array $itemCdList　商品コードの配列
     * @param string $from　yyyyMMddの8桁
     * @param string $to　yyyyMMddの8桁
     * @return void
     */
    public function chgDepoInfoCsv(?array $depoCdList, ?array $addressList, ?array $itemCdList, ?string $from, ?string $to)
    {
        // ファイルディレクトリ
        $fileDir = Config::get('csvexp.file_dir.chg_depo_info');
        // ファイル名
        $fileName = Config::get('csvexp.file_name.chg_depo_info');
        // ファイル名（フルパス）
        $fullName = $fileDir . AppUtility::createFileName($fileName);
        // トリガーファイル名（フルパス）
        $trgFileName = str_replace('.csv', '.trg', $fullName);
        // パラメータ
        $depoCdList = $depoCdList ? $depoCdList : [];
        $addressList = $addressList ? $addressList : [];
        $itemCdList = $itemCdList ? $itemCdList : [];

        try {
            $chgDepoInfoEntityList = array();
            // チェック処理
            Log::channel('daily')->info('パラメータチェック処理を開始');
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
            Log::channel('daily')->info('パラメータチェック処理を終了');
    
            // CSV出力用配列生成処理
            Log::channel('daily')->info('CSV出力用配列生成処理開始');
            $chgDepoInfoEntityList = $this->generateEntityList($depoCdList, $addressList, $itemCdList, $from, $to);
            Log::channel('daily')->info('CSV出力用配列生成処理終了');
    
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
     * @param array $itemCdList
     * @param string|null $from
     * @param string|null $to
     * @return void
     */
    private function generateEntityList(array $depoCdList, array $addressList, array $itemCdList, ?string $from, ?string $to)
    {
        $chgDepoInfoEntityList = array();
        $baseEntity = new ChgDepoInfoEntity();
        $baseEntity->ymdFrom = $from;
        $baseEntity->ymdTo = $to;
        if (count($depoCdList) != 0) {
            foreach ($depoCdList as $depoCd) {
                $chgDepoInfoEntity = clone $baseEntity;
                $chgDepoInfoEntity->depoCd = $depoCd;
                $list = $this->entitySetAddress($chgDepoInfoEntity, $addressList, $itemCdList);
                $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
            }
        } else {
            $list = $this->entitySetAddress($baseEntity, $addressList, $itemCdList);
            $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
        }

        return $chgDepoInfoEntityList;
    }

    /**
     * 住所情報設定
     *
     * @param ChgDepoInfoEntity $baseEntity
     * @param array $addressList
     * @param array $itemCdList
     * @return void
     */
    private function entitySetAddress(ChgDepoInfoEntity $baseEntity, array $addressList, array $itemCdList)
    {
        $chgDepoInfoEntityList = array();
        if (count($addressList) != 0) {
            foreach ($addressList as $address) {
                $chgDepoInfoEntity = clone $baseEntity;

                $chgDepoInfoEntity->prefCd = $address['prefCd'];
                $chgDepoInfoEntity->siku = $address['siku'];
                $chgDepoInfoEntity->tyou = $address['tyou'];

                // 商品設定
                $list = $this->entitySetItem($chgDepoInfoEntity, $itemCdList);
                $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
            }
        } else {
            // 商品設定
            $list = $this->entitySetItem($baseEntity, $itemCdList);
            $chgDepoInfoEntityList = array_merge($chgDepoInfoEntityList, $list);
        }

        return $chgDepoInfoEntityList;
    }

    /**
     * 商品コード設定
     *
     * @param ChgDepoInfoEntity $baseEntity
     * @param array $itemCdList
     * @return void
     */
    private function entitySetItem(ChgDepoInfoEntity $baseEntity, array $itemCdList)
    {
        $chgDepoInfoEntityList = array();
        if (count($itemCdList) != 0) {
            foreach ($itemCdList as $itemCd) {
                $chgDepoInfoEntityTmpItem = clone $baseEntity;
                $chgDepoInfoEntityTmpItem->itemCd = $itemCd;
                // CSV出力リストに追加
                $chgDepoInfoEntityList[] = $chgDepoInfoEntityTmpItem;
            }
        } else {
            $chgDepoInfoEntityList[] =  $baseEntity;
        }

        return $chgDepoInfoEntityList;
    }
}
