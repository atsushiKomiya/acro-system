<?php

namespace App\Application\Requests;

class DepoApplicationRequest extends ApiRequest
{
    /**
     * 認証有無
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーション
     *
     * @return array
     */
    public function rules()
    {
        return [
            'depoCd'                             => 'required|numeric',
            'dateYm'                             => 'required|min:6|max:6',
            'calendarList.*.deliveryDate'        => 'required|min:8|max:8',
            'calendarList.*.annotationDepo'      => 'required|max:1000',
        ];
    }

    /**
     * 項目名
     *
     * @return void
     */
    public function attributes()
    {
        return [
            'depoCd'   => 'デポコード',
            'dateYm'   => '対象年月',
            'calendarList.*.deliveryDate'     => '届日',
            'calendarList.*.annotationDepo'   => '変更理由',
        ];
    }
}
