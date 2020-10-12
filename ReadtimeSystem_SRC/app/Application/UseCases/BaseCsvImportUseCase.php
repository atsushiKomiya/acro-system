<?php

namespace App\Application\UseCases;

use App\Domain\Entities\CsvImportResultEntity;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use SplFileObject;

class BaseCsvImportUseCase
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
    }

    /**
     * CSV取り込みカラム数を取得する
     *
     * @param [type] $csvType
     * @return array
     */
    protected function getImportColumns($csvType): int
    {
        $csvInfo = collect(Config::get('csvimp.' . $csvType));
        return $csvInfo->count();
    }

    /**
     * 作業フォルダ
     *
     * @return string
     */
    protected function tempDirPath(): string
    {
        return storage_path('app/temp/');
    }

    /**
     * バックアップフォルダ
     *
     * @return string
     */
    protected function backupdDirPath(): string
    {
        return storage_path('app/backup/');
    }

    /**
     * インポートメイン
     *
     * @param string $fileName
     * @param boolean $useHeader
     * @param [function] $rowCallback
     * @return array
     */
    protected function importFile(string $fileName, $displayName, $rowCallback): array
    {
        $errors = [];

        $file = new SplFileObject($this->tempDirPath() . $fileName);

        $file->setFlags(
            +SplFileObject::READ_AHEAD |     // 先読み/巻き戻しで読み出す
            +SplFileObject::SKIP_EMPTY |     // 空行は読み飛ばす
            SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
        );

        // 各行を処理
        foreach ($file as $i => $lineStr) {
            try {
                if ($i == 0) {
                    // ヘッダ行は処理しない
                    continue;
                }
                // 文字コード変換
                $enc_line = mb_convert_encoding($lineStr, 'UTF-8', 'UTF-8');
                $row = str_getcsv($enc_line);

                \call_user_func($rowCallback, $row, $i);
            } catch (\Exception $ex) {
                $errors[] = Lang::get('error.CSV.base_error',['lineNo' => $i,'errorMsg' => $ex->getMessage()]);
            }
        }

        // 元ファイルをバックアップフォルダに移動
        $tempFile = 'temp/' . $fileName;
        if ($displayName != null) {
            $backupFile = 'backup/'. $displayName . '_' . date('YmdHis') . '.csv';
        } else {
            $backupFile = 'backup/'. $fileName;
        }
        $disk = \Storage::disk('local');
        if ($disk->exists($backupFile)) {
            $disk->delete($backupFile);
        }
        $disk->move($tempFile, $backupFile);

        return $errors;
    }

    /**
     * CSV取込用返却Entityを生成する
     *
     * @param [type] $errorList
     * @param [type] $totalCount
     * @param [type] $errorCount
     * @return CsvImportResultEntity
     */
    protected function resultEntitySet($errorList ,$totalCount,$errorCount): CsvImportResultEntity
    {
        $entity = new CsvImportResultEntity();

        $entity->totalRowCount = $totalCount;
        $entity->successRowCount = $totalCount - $errorCount;
        $entity->errorRowCount = $errorCount;

        if(count($errorList) != 0) {
            $entity->errorList = $errorList;
            $entity->isSuccess = false;

        } else {
            $entity->errorList = [];
            $entity->isSuccess = true;
        }

        return $entity;
    }
}
