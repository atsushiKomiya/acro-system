<?php

namespace App\Providers;

use App\Domain\Repositories\CUseRepositoryInterface;
use App\Domain\Repositories\DepoAddressLeadtimeRepositoryInterface;
use App\Domain\Repositories\ViewLoginUserRepositoryInterface;
use App\Domain\Repositories\DepoCalAprInfoRepositoryInterface;
use App\Domain\Repositories\DepoCalInfoTmpRepositoryInterface;
use App\Domain\Repositories\DepoCalInfoRepositoryInterface;
use App\Domain\Repositories\DepoDefaultRepositoryInterface;
use App\Domain\Repositories\DepoItemInfoRepositoryInterface;
use App\Domain\Repositories\IrregularAreaRepositoryInterface;
use App\Domain\Repositories\IrregularDayofweekRepositoryInterface;
use App\Domain\Repositories\IrregularDepoRepositoryInterface;
use App\Domain\Repositories\IrregularItemRepositoryInterface;
use App\Domain\Repositories\IrregularRepositoryInterface;
use App\Domain\Repositories\ItemCategoryLargeRepositoryInterface;
use App\Domain\Repositories\ItemCategoryMediumRepositoryInterface;
use App\Domain\Repositories\ItemCategoryRelationRepositoryInterface;
use App\Domain\Repositories\LeadtimeDisplayGroupRepositoryInterface;
use App\Domain\Repositories\ViewAddressRepositoryInterface;
use App\Domain\Repositories\ViewDepoRepositoryInterface;
use App\Domain\Repositories\ViewItemRepositoryInterface;
use App\Domain\Repositories\ViewLeadtimeMessageRepositoryInterface;
use App\Domain\Repositories\PublicHolidayRepositoryInterface;
use App\Domain\Repositories\TimeSelectRepositoryInterface;
use App\Infrastructure\Eloquents\EloquentCUseRepository;
use App\Infrastructure\Eloquents\EloquentDepoAddressLeadtimeRepository;
use App\Infrastructure\Eloquents\EloquentViewLoginUserRepository;
use App\Infrastructure\Eloquents\EloquentDepoCalAprInfoRepository;
use App\Infrastructure\Eloquents\EloquentDepoCalInfoTmpRepository;
use App\Infrastructure\Eloquents\EloquentDepoCalInfoRepository;
use App\Infrastructure\Eloquents\EloquentDepoDefaultRepository;
use App\Infrastructure\Eloquents\EloquentDepoItemInfoRepository;
use App\Infrastructure\Eloquents\EloquentIrregularAreaRepository;
use App\Infrastructure\Eloquents\EloquentIrregularDayofweekRepository;
use App\Infrastructure\Eloquents\EloquentIrregularDepoRepository;
use App\Infrastructure\Eloquents\EloquentIrregularItemRepository;
use App\Infrastructure\Eloquents\EloquentIrregularRepository;
use App\Infrastructure\Eloquents\EloquentItemCategoryLargeRepository;
use App\Infrastructure\Eloquents\EloquentItemCategoryMediumRepository;
use App\Infrastructure\Eloquents\EloquentItemCategoryRelationRepository;
use App\Infrastructure\Eloquents\EloquentLeadtimeDisplayGroupRepository;
use App\Infrastructure\Eloquents\EloquentViewAddressRepository;
use App\Infrastructure\Eloquents\EloquentViewDepoRepository;
use App\Infrastructure\Eloquents\EloquentViewItemRepository;
use App\Infrastructure\Eloquents\EloquentViewLeadtimeMessageRepository;
use App\Infrastructure\Eloquents\EloquentPublicHolidayRepository;
use App\Infrastructure\Eloquents\EloquentTimeSelectRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ViewLoginUserRepositoryInterface::class, EloquentViewLoginUserRepository::class);
        $this->app->bind(DepoCalAprInfoRepositoryInterface::class, EloquentDepoCalAprInfoRepository::class);
        $this->app->bind(DepoCalInfoRepositoryInterface::class, EloquentDepoCalInfoRepository::class);
        $this->app->bind(DepoCalInfoTmpRepositoryInterface::class, EloquentDepoCalInfoTmpRepository::class);
        $this->app->bind(ViewLeadtimeMessageRepositoryInterface::class, EloquentViewLeadtimeMessageRepository::class);
        $this->app->bind(ViewAddressRepositoryInterface::class, EloquentViewAddressRepository::class);
        $this->app->bind(ViewDepoRepositoryInterface::class, EloquentViewDepoRepository::class);
        $this->app->bind(LeadtimeDisplayGroupRepositoryInterface::class, EloquentLeadtimeDisplayGroupRepository::class);
        $this->app->bind(ItemCategoryLargeRepositoryInterface::class, EloquentItemCategoryLargeRepository::class);
        $this->app->bind(ItemCategoryMediumRepositoryInterface::class, EloquentItemCategoryMediumRepository::class);
        $this->app->bind(ViewItemRepositoryInterface::class, EloquentViewItemRepository::class);
        $this->app->bind(ItemCategoryRelationRepositoryInterface::class, EloquentItemCategoryRelationRepository::class);
        $this->app->bind(DepoDefaultRepositoryInterface::class, EloquentDepoDefaultRepository::class);
        $this->app->bind(PublicHolidayRepositoryInterface::class, EloquentPublicHolidayRepository::class);
        $this->app->bind(DepoAddressLeadtimeRepositoryInterface::class, EloquentDepoAddressLeadtimeRepository::class);
        $this->app->bind(DepoItemInfoRepositoryInterface::class, EloquentDepoItemInfoRepository::class);
        $this->app->bind(IrregularRepositoryInterface::class, EloquentIrregularRepository::class);
        $this->app->bind(CUseRepositoryInterface::class, EloquentCUseRepository::class);
        $this->app->bind(TimeSelectRepositoryInterface::class, EloquentTimeSelectRepository::class);
        $this->app->bind(IrregularAreaRepositoryInterface::class, EloquentIrregularAreaRepository::class);
        $this->app->bind(IrregularItemRepositoryInterface::class, EloquentIrregularItemRepository::class);
        $this->app->bind(IrregularDepoRepositoryInterface::class, EloquentIrregularDepoRepository::class);
        $this->app->bind(IrregularDayofweekRepositoryInterface::class, EloquentIrregularDayofweekRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
