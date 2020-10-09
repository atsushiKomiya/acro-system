<?php

namespace App\Application\UseCases;

use Illuminate\Support\Facades\Config;
use App\Consts\AppConst;

class BaseCsvExportUseCase
{

    /**
     * コンストラクタ
     */
    public function __construct(
    ) {
    }

    /**
     * Header作成
     *
     * @param string $fileName
     * @return array
     */
    public function makeHeaderWithFilename(string $fileName): array
    {
        $headers = [ //ヘッダー情報
            'Content-type' => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        return $headers;
    }

    /**
     * ヘッダー名のリストを取得する
     *
     * @param [type] $csvType
     * @return array
     */
    protected function getHeaders($csvType): array
    {
        $csvInfo = collect(Config::get('csvexp.' . $csvType));
        return $csvInfo->map(function ($item) {
            return $item[0];
        })->all();
    }

    /**
     * カラム名のリストを取得する
     *
     * @param [type] $csvType
     * @return array
     */
    protected function getColumns($csvType): array
    {
        $csvInfo = collect(Config::get('csvexp.' . $csvType));
        return $csvInfo->map(function ($item) {
            return $item[1];
        })->all();
    }

    /**
     * 表示オプションのリストを取得する
     *
     * @param [type] $csvType
     * @return array
     */
    protected function getOptions($csvType): array
    {
        $csvInfo = collect(Config::get('csvexp.' . $csvType));
        return $csvInfo->map(function ($item) {
            return $item[2];
        })->all();
    }

    /**
     * ローカルCSVファイル作成
     *
     * @param [type] $csvTypeName
     * @param [type] $cursors
     * @param [type] $fullname
     * @return void
     */
    protected function makeCSVLocalFile($csvTypeName, $cursors, $fullname, $headerCallback = null, $dataCallback = null)
    {
        // ディレクトリ存在確認
        $pathParts = pathinfo($fullname);
        if (!file_exists($pathParts['dirname'])) {
            //存在しない場合の処理
            mkdir($pathParts['dirname'], 0755, true);
        }
        $this->makeCsv($csvTypeName, $cursors, $fullname, $headerCallback, $dataCallback);
    }

    /**
     * ダウンロードCSVファイル作成
     *
     * @param [type] $csvTypeName
     * @param [type] $cursors
     * @return void
     */
    protected function makeStreamCSV($csvTypeName, $cursors, $headerCallback = null, $dataCallback = null)
    {
        $fullname = "php://output";
        $this->makeCsv($csvTypeName, $cursors, $fullname, $headerCallback, $dataCallback);
    }


    /**
     * ダウンロードCSV可変ファイル作成
     *
     * @param [type] $csvTypeName
     * @param [type] $cursors
     * @return void
     */
    protected function makeStreamDynamicCSV($csvTypeName, $cursors, $callback = null, $names)
    {
        $fullname = "php://output";
        $this->makeDynamicCsv($csvTypeName, $cursors, $fullname, $callback, $names);
    }

    /**
     * CSV作成
     *
     * @param [type] $csvTypeName
     * @param [type] $cursors
     * @param [type] $fullname
     * @param [type] $callback
     * @return void
     */
    private function makeCsv($csvTypeName, $cursors, $fullname, $headerCallback = null, $dataCallback = null)
    {
        $createCsvFile = fopen($fullname, 'w');
        if (is_null($headerCallback)) {
            $columns = $this->getColumns($csvTypeName);
            $headers = $this->getHeaders($csvTypeName);
            $options = $this->getOptions($csvTypeName);
        } else {
            // [[header name,columns name,options name]]
            $csvExp = \call_user_func($headerCallback, $cursors);
            $csvExpCollect = collect($csvExp);
            $columns = $csvExpCollect->map(function ($item) {
                return $item[1];
            })->all();
            $headers = $csvExpCollect->map(function ($item) {
                return $item[0];
            })->all();
            $options = $csvExpCollect->map(function ($item) {
                return $item[2];
            })->all();
        }

        // header作成
        if ($headers != null) {
            $headerLine = $this->toCsvHeader($headers);
            fputs($createCsvFile, $headerLine);
        }

        foreach ($cursors as $cursor) {
            // 独自加工がある場合
            $model = is_null($dataCallback) ? $cursor : \call_user_func($dataCallback, $cursor);
            $csv = [];
            foreach ($columns as $col) {
                $csv[] = $model[$col];
            }
            $line = $this->toCsv($csv, $options);
            \fputs($createCsvFile, $line);
        }

        fclose($createCsvFile);
    }

    /**
     * 可変CSV作成
     *
     * @param [type] $csvTypeName
     * @param [type] $cursors
     * @param [type] $fullname
     * @param [type] $callback
     * @return void
     */
    private function makeDynamicCsv($csvTypeName, $cursors, $fullname, $callback = null, $names)
    {
        $createCsvFile = fopen($fullname, 'w');
        $columns = $this->getColumns($csvTypeName);
        $headers = $this->getHeaders($csvTypeName);
        $options = $this->getOptions($csvTypeName);

        $headers = \array_merge($headers, $names);

        // header作成
        if ($headers != null) {
            $headerLine = $this->toCsvHeader($headers);
            fputs($createCsvFile, $headerLine);
        }

        $depoItemList = [];
        foreach ($cursors as $cursor) {
            // 独自加工がある場合
            $model = is_null($callback) ? $cursor : \call_user_func($callback, $cursor);
            $csv = [];
            $item = [];
            foreach ($columns as $col) {
                if ($col == 'depo_cd') {
                    $depocd = empty($model[$col]) ? '-1' : $model[$col];
                    if (array_key_exists($depocd, $depoItemList)) {
                        $item = $depoItemList[$depocd];
                    } else {
                        $db = \DB::select('select func_depo_item(\'' . $depocd . '\') AS nb');
                        $item = $db[0]->nb;
                        preg_match('{\{\"\(' . $depocd . ',(.*)\)\"\}.*}', $item, $m);
                        $item = $m[1];
                        $depoItemList[$depocd] = $item;
                    }

                }
                $csv[] = $model[$col];
            }
            \array_push($csv, $item);
            $line = $this->toCsv($csv, $options);
            \fputs($createCsvFile, $line);
        }

        fclose($createCsvFile);
    }

    /**
     * ヘッダー作成
     */
    protected function toCsvHeader($row, $toEncoding = 'UTF-8', $srcEncoding = 'ASCII,JIS,UTF-8,EUC-JP,SJIS')
    {
        $csv = "";
        // ダブルクォーテーションで囲う
        $row = array_map(function ($value) {
            return "\"{$value}\"";
        }, $row);
        // カンマ区切り
        $row = implode(',', $row);
        $csv .= $row . "\n";

        // エンコード
        $csv = mb_convert_encoding($csv, $toEncoding, $srcEncoding);
        return $csv;
    }

    /**
     * コンテンツ作成
     */
    protected function toCsv($row, $options, $toEncoding = 'UTF-8', $srcEncoding = 'ASCII,JIS,UTF-8,EUC-JP,SJIS')
    {
        $csv = "";
        // ダブルクォーテーションで囲う

        for ($i = 0; $i < count($options); $i++) {
            $option = $options[$i];
            $val = $row[$i];
            if ($option == AppConst::TYPE_STR) {
                // TYPE_STR の時はダブルクォート
                $row[$i] = "\"{$val}\"";
            }
        }

        // カンマ区切り
        $row = implode(',', $row);
        $csv = $row . "\n";
        
        // エンコード
        $csv = mb_convert_encoding($csv, $toEncoding, $srcEncoding);
        return $csv;
    }
}
