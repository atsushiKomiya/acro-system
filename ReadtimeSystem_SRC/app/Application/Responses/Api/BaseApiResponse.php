<?php

namespace App\Application\Responses\Api;

use App\Domain\Entities\ResultEntity;
use App\Domain\Factories\BaseFactory;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class BaseApiResponse implements Responsable
{
    // Common Responses
    public $isSuccess;
    public $message;
    public $code;

    // Data
    public $data;

    // Pagination
    public $currentPage;
    public $lastPage;
    public $perPage;
    public $total;

    public $statusCode;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->isSuccess = false;
        $this->message = "";
        $this->code = 0;

        $this->data = [];
        $this->currentPage = 0;
        $this->lastPage = 0;
        $this->total = 0;

        $this->statusCode = 200;
    }

    /**
     * キャスト
     *
     * @param [type] $obj
     * @return self
     */
    public static function cast($obj) : self
    {
        if (($obj instanceof self) == false) {
            throw new InvalidArgumentException("{$obj} is not instance of BaseApiResponse");
        }
        return $obj;
    }

    /**
     * ResultEntity からResponse作成
     *
     * @param ResultEntity $entity
     * @return void
     */
    public static function byResultEntity(ResultEntity $entity)
    {
        $res = new BaseApiResponse();
        $res->isSuccess = $entity->result;
        $res->message = $entity->errorMessage;

        return $res;
    }

    /**
     * API成功（データあり）
     *
     * @param string $message
     * @return void
     */
    public function apiSuccessful(string $message = "")
    {
        $this->isSuccess = true;
        $this->statusCode = 200;
        $this->message = $message;
    }

    /**
     * API成功（データなし）
     *
     * @param string $message
     * @return void
     */
    public function apiNoContent(string $message = "")
    {
        $this->isSuccess = true;
        $this->statusCode = 204;
        $this->message = $message;
    }

    /**
     * API失敗・エラー
     *
     * @param integer $errorCode
     * @param string $message
     * @return void
     */
    public function apiFailed(int $errorCode, string $message)
    {
        $this->isSuccess = false;
        $this->statusCode = 200;
        $this->code = $errorCode;
        $this->message = $message;
    }

    /**
     * API失敗・サーバーエラー
     *
     * @param integer $errorCode
     * @param string $message
     * @return void
     */
    public function apiServerError(int $errorCode, string $message)
    {
        $this->isSuccess = false;
        $this->statusCode = 500;
        $this->code = $errorCode;
        $this->message = $message;
    }

    /**
     * interface implementation
     *
     * @param [type] $request
     * @return void
     */
    public function toResponse($request)
    {
        return response()
            ->json($this)
            ->setStatusCode($this->statusCode);
    }

    /**
     * Eloquent の paginate result からレスポンス作成
     *
     * @param LengthAwarePaginator $searchResult
     * @param string|null $entityClass
     * @return void
     */
    public function buildBySearchResult(LengthAwarePaginator $searchResult, ?string $entityClass)
    {
        if ($searchResult != null) {
            $this->isSuccess = true;
            $this->currentPage = $searchResult->currentPage();
            $this->lastPage = $searchResult->lastPage();
            $this->perPage = $searchResult->perPage();
            $this->total = $searchResult->total();

            if (count($searchResult) > 0) {
                if ($entityClass != null) {
                    $factory = new BaseFactory();
                    $this->data = $searchResult->map(function ($item) use ($factory, $entityClass) {
                        return $factory->makeEntityByModel($item, $entityClass);
                    });
                } else {
                    $this->data = $searchResult->map(function ($item) {
                        return $item;
                    })->toArray();
                }
                $this->apiSuccessful();
            } else {
                $this->apiNoContent();
            }
        } else {
            $this->apiFailed(999, "");
        }
    }
}
