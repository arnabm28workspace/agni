<?php

namespace App\Providers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\AdminInterface;
use App\Interfaces\SubcategoryInterface;
// use App\Interfaces\CollectionInterface;
// use App\Interfaces\CouponInterface;
// use App\Interfaces\OfferInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\PurchaseOrderInterface;
// use App\Interfaces\AddressInterface;
// use App\Interfaces\FaqInterface;
// use App\Interfaces\SettingsInterface;
use App\Interfaces\StoreInterface;
use App\Interfaces\OrderInterface;
// use App\Interfaces\TransactionInterface;
// use App\Interfaces\NotificationInterface;
use App\Interfaces\CartInterface;
// use App\Interfaces\SearchInterface;
// use App\Interfaces\CheckoutInterface;
use App\Interfaces\SubadminInterface;
use App\Interfaces\PaymentCollectionInterface;
use App\Interfaces\UnitInterface;
use App\Interfaces\CustomerInterface;

use App\Repositories\SubadminRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SubcategoryRepository;
use App\Repositories\CollectionRepository;
use App\Repositories\CouponRepository;
// use App\Repositories\OfferRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseOrderRepository;
// use App\Repositories\AddressRepository;
// use App\Repositories\FaqRepository;
// use App\Repositories\NotificationRepository;
// use App\Repositories\SettingsRepository;
use App\Repositories\StoreRepository;
use App\Repositories\OrderRepository;
// use App\Repositories\TransactionRepository;
use App\Repositories\CartRepository;
use App\Repositories\AdminRepository;
use App\Repositories\SearchRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\PaymentCollectionRepository;
use App\Repositories\UnitRepository;
use App\Repositories\CustomerRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(SubcategoryInterface::class, SubcategoryRepository::class);
        // $this->app->bind(CollectionInterface::class, CollectionRepository::class);
        // $this->app->bind(CouponInterface::class, CouponRepository::class);
        // $this->app->bind(OfferInterface::class, OfferRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(PurchaseOrderInterface::class, PurchaseOrderRepository::class);
        // $this->app->bind(AddressInterface::class, AddressRepository::class);
        // $this->app->bind(FaqInterface::class, FaqRepository::class);
        // $this->app->bind(SettingsInterface::class, SettingsRepository::class);
        $this->app->bind(StoreInterface::class, StoreRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        // $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        // $this->app->bind(NotificationInterface::class, NotificationRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
        // $this->app->bind(SearchInterface::class, SearchRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        // $this->app->bind(CheckoutInterface::class, CheckoutRepository::class);
        $this->app->bind(SubadminInterface::class, SubadminRepository::class);
        $this->app->bind(PaymentCollectionInterface::class, PaymentCollectionRepository::class);
        $this->app->bind(UnitInterface::class, UnitRepository::class);
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
