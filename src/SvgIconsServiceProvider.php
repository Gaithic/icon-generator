<?php

namespace Rohitgautam\Icon;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class SvgIconsServiceProvider extends ServiceProvider
{
    public function register()
    {
        
    }

    public function boot()
    {
        $this->createIconDirective();  
        $this->registerHelper();        
    }


    /**
     * register directive in blade file or create new directive for blade template
     * @return void
    * **/
    private function createIconDirective(): void
    {
        Blade::directive('svgIcon', function ($expression) {
            return "<?php echo app('SvgIconHelper')->processCustomClassDirective($expression); ?>";
        });
    }

    /**
     * register helper
     */
    public function registerHelper() : void
    {        
        $this->app->singleton('SvgIconHelper', function () {
            return new SvgIconHelper();
        });
    }
    
}
