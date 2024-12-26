<?php

namespace Codersgarden\PhpLexofficeApi;

use Illuminate\Support\ServiceProvider;

class LexofficeServiceProvider extends ServiceProvider
{
    public function register()
    {

        // Register the Contact class
        $this->app->singleton('contact', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeContactManager();
        });

        $this->app->singleton('lexoffice-article', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeArticleManager();
        });

        $this->app->singleton('lexoffice-country', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeCountryManager();
        });

        $this->app->singleton('lexoffice-credit-note', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeCreditNoteManager();
        });

        $this->app->singleton('lexoffice-delivery-note', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeDeliveryNotesManager();
        });

        $this->app->singleton('lexoffice-file', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeFileManager();
        });

        $this->app->singleton('lexoffice-invoice', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeInvoiceManager();
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeOrderConfirmationManager();
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeProfileManager();  //done  -
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficePaymentManager();  //done  -
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficePaymentConditionManager();  //done
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeQuotationManager();  //done
        });
 
        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeVoucherListManager();  //done
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeVoucherManager();  //update not working  upload file
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeDunningManager();   //done
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeDownPaymentInvoiceManager();  //find method not working
        });
       
        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeEventSubscriptionManager(); //done
        });
       
        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficePostingCategorieManager();   //done
        });


        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficePrintLayoutManager();  //done
        });

        $this->app->singleton('lexoffice-order-confirmation', function ($app) {
            return new \Codersgarden\PhpLexofficeApi\LexofficeRecurringManager();  //done
        });
        
       

        $this->mergeConfigFrom(__DIR__ . '/../config/lexoffice.php', 'lexoffice');
    }

    public function boot()
    {
        // Publish the config file
        $this->publishes([
            __DIR__ . '/../config/lexoffice.php' => config_path('lexoffice.php'),
        ], 'config');
    }
}
