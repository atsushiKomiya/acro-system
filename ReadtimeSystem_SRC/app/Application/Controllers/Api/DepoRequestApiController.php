<?php

namespace App\Application\Controllers\Api;

use App\Application\Requests\DepoApplicationRequest;
use App\Application\Requests\DepoApprovalRequest;
use App\Application\Requests\DepoConfirmRequest;
use App\Application\Responses\Api\BaseApiResponse;
use App\Application\UseCases\DepoCalInfoTmpUseCase;
use App\Application\UseCases\DepoCalAprInfoUseCase;
use App\Application\UseCases\DepoCalInfoUseCase;
use App\Application\UseCases\OrderUpdateCsvExportUseCase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

/**
 * デポ休業申請画面API
 */
class DepoRequestApiController extends ApiController
{
    /**
         * デポ休業申請
         *
         * @param DepoConfirmRequest $request
         * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUsecase
         * @param DepoCalAprInfoUsecase $depoCalAprInfoUsecase
         * @
         * @return void
         */
    public function confirm(DepoConfirmRequest $request, DepoCalAprInfoUsecase $depoCalAprInfoUsecase)
    {
        $res = new BaseApiResponse();
        try {
            DB::beginTransaction();
            //デポカレンダー承認情報確認
            $depoCalAprInfoUsecase->confirmDepoCalAprInfoApi($request->depoCd,$request->dateYm);

            // コミット
            DB::commit();
            // 返却
            $res->apiSuccessful();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L11.confirm'));
        }

        return $res;
    }

    /**
     * デポ休業申請
     *
     * @param DepoApplicationRequest $request
     * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUsecase
     * @param DepoCalAprInfoUsecase $depoCalAprInfoUsecase
     * @
     * @return void
     */
    public function application(DepoApplicationRequest $request, DepoCalInfoTmpUseCase $depoCalInfoTmpUsecase, DepoCalAprInfoUsecase $depoCalAprInfoUsecase)
    {
        $res = new BaseApiResponse();
        $depoCd = $request->depoCd;
        $dateYm = $request->dateYm;
        $calendarList = $request->calendarList;
        $loginUser = Auth::user();

        try {
            DB::beginTransaction();

            $depoCalAprInfo = $depoCalAprInfoUsecase->getDepoCalAprInfo($depoCd, $dateYm);
            if (!is_null($depoCalAprInfo) && !is_null($depoCalAprInfo->approvalId)) {
                //旧デポカレンダーTmp情報論理削除
                $depoCalInfoTmpUsecase->deleteDepoCalInfoTmpApr($depoCd, $calendarList, $loginUser->login_cd);

                //旧デポカレンダー承認情報論理削除
                $depoCalAprInfoUsecase->deleteDepoCalAprInfoApi($depoCd, $dateYm, $loginUser->login_cd);

            }

            //該当デポカレンダーTMP情報登録
            $depoCalInfoTmpUsecase->saveDepoCalInfoTmpApr($depoCd, $calendarList);

            //デポカレンダー承認情報登録
            $depoCalAprInfoUsecase->saveDepoCalAprInfoApi($depoCd, $dateYm);

           // コミット
            DB::commit();
            // 返却
            $res->apiSuccessful();
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            $res->apiServerError(500, Lang::get('error.C_L11.application'));
        }

        return $res;
    }

    /**
     * デポ休業承認
     *
     * @param DepoApprovalRequest $request
     * @param DepoCalInfoTmpUseCase $depoCalInfoTmpUsecase
     * @param DepoCalAprInfoUsecase $depoCalAprInfoUsecase
     * @param DepoCalInfoUsecase $depoCalInfoUsecase
     * @return void
     */
    public function approval(
        DepoApprovalRequest $request,
        DepoCalInfoTmpUseCase $depoCalInfoTmpUsecase,
        DepoCalAprInfoUsecase $depoCalAprInfoUsecase,
        DepoCalInfoUseCase $depoCalInfoUsecase,
        OrderUpdateCsvExportUseCase $orderCsvExpUsecase)
    {
        $res = new BaseApiResponse();
        $depoCd = $request->depoCd;
        $dateYm = $request->dateYm;
        $calendarList = $request->calendarList;
        $loginUser = Auth::user();

        try {
            DB::beginTransaction();

            //デポカレンダーTmp情報更新
            $depoCalInfoTmpUsecase->updateDepoCalInfoTmpApi($depoCd,$calendarList);

            //デポカレンダー情報更新
            $depoCalInfoUsecase->approvalUpdateDepoCalInfoApi($depoCd,$calendarList);

            //デポカレンダー承認情報更新
            $depoCalAprInfoUsecase->approvalDepoCalAprInfoApi($depoCd,$dateYm, $loginUser->login_cd);

            // C_LI_03_受注データ更新用CSV出力
            $depoCdList = [$depoCd];
            $carbon = Carbon::createFromFormat('Ym', $dateYm);
            $from = $carbon->firstOfMonth()->format('Ymd');
            $to = $carbon->endOfMonth()->format('Ymd');

            $orderCsvExpUsecase->chgDepoInfoCsv($depoCdList, null, null, $from, $to, null);

            // コミット
            DB::commit();
            // 返却
            $res->apiSuccessful();
        } catch (Exception $ex) {
            DB::rollBack();
            $res->apiServerError(500, $ex->getMessage());
        }

        return $res;
    }
}
