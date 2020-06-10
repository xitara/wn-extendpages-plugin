<?php namespace Xitara\ExtendPages;

use App;
use Backend;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Event;
use System\Classes\PluginBase;
use System\Classes\PluginManager;

/**
 * ExtendPages Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = [
        'RainLab.Pages',
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'xitara.extendpages::lang.plugin.name',
            'description' => 'xitara.extendpages::lang.plugin.description',
            'author' => 'Xitara, Manuel Burghammer',
            'home' => 'https://xitara.net',
            'icon' => 'icon-files-o',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        return [];

        Event::listen('backend.form.extendFields', function ($widget) {
            if ($widget->isNested === false) {
                if (!($theme = Theme::getEditTheme())) {
                    throw new ApplicationException(Lang::get('cms::lang.theme.edit.not_found'));
                }

                if (PluginManager::instance()->hasPlugin('RainLab.Pages')
                    && $widget->model instanceof \RainLab\Pages\Classes\Page) {

                    $widget->addFields([
                        'viewBag[intro]' => [
                            'label' => 'xitara.extendpages::pages.label.intro',
                            'tab' => 'xitara.extendpages::pages.tab.intro',
                            'span' => 'full',
                            'type' => 'richeditor',
                            'size' => 'huge',
                        ],
                    ], 'primary');
                }
            }
        });
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        // Check if we are currently in backend module.
        if (!App::runningInBackend()) {
            return;
        }
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Xitara\ExtendPages\Components\DisplayIntro' => 'displayIntro',
        ];
    }

    public function registerPageSnippets()
    {
        return [
            'Xitara\ExtendPages\Components\DisplayIntro' => 'displayIntro',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'xitara.extendpages.some_permission' => [
                'tab' => 'ExtendPages',
                'label' => 'Some permission',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'extendpages' => [
                'label' => 'ExtendPages',
                'url' => Backend::url('xitara/extendpages/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['xitara.extendpages.*'],
                'order' => 500,
            ],
        ];
    }
}
