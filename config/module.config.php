<?php
return array(
    'router' => array(
        'routes' => array(
            'Grid\GoogleAnalytics\Admin\Api\Callback' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/app/:locale/admin/googleanalytics/api/callback',
                    'constraints' => array(
                        'locale' => '\w+'
                    ),
                    'defaults' => array(
                        'controller' => 'Grid\GoogleAnalytics\Controller\GoogleApi',
                        'action' => 'callback'
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Grid\GoogleAnalytics\Controller\GoogleApi' => 'Grid\GoogleAnalytics\Controller\GoogleApiController'
        )
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'GoogleAnalyticsPlugin' => 'Grid\GoogleAnalytics\Controller\Plugin\DashboardAnalyticsPlugin'
        )
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            'googleAnalytics' => array(
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../languages/googleAnalytics',
                'pattern' => '%s.php',
                'text_domain' => 'googleAnalytics'
            )
        )
    ),
    'modules' => array(
        'Grid\Core' => array(
            'settings' => array(
                'google' => array(
                    'textDomain' => 'google',
                    'fieldsets' => array(
                        'analytics' => 'google-analytics'
                    )
                ),
                'google-analytics' => array(
                    'textDomain' => 'google',
                    'elements' => array(
                        'id' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.access.analyticsId',
                            'type' => 'ini'
                        ),
                        'googleApiClientId' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.googleApi.clientId',
                            'type' => 'ini'
                        ),
                        'googleApiClientSecret' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.googleApi.clientSecret',
                            'type' => 'ini'
                        ),
                        'googleApiAccessToken' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.googleApi.accessToken',
                            'type' => 'ini'
                        ),
                        'dashboardChartProfileId' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.dashboardChart.profileId',
                            'type' => 'ini'
                        ),
                        'dashboardChartEnabled' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.dashboardChart.enabled',
                            'type' => 'ini'
                        ),
                        'dashboardChartAvalilableProfiles' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.dashboardChart.avalilableProfiles',
                            'type' => 'ini'
                        )
                    )
                )
            ),
            'navigation' => array(
                'settings' => array(
                    'pages' => array(
                        'service' => array(
                            'label' => 'admin.navTop.service',
                            'textDomain' => 'admin',
                            'order' => 7,
                            'uri' => '#',
                            'parentOnly' => true,
                            'pages' => array(
                                'google' => array(
                                    'label' => 'admin.navTop.settings.google',
                                    'textDomain' => 'admin',
                                    'order' => 1,
                                    'route' => 'Grid\Core\Settings\Index',
                                    'resource' => 'settings.google',
                                    'privilege' => 'edit',
                                    'params' => array(
                                        'section' => 'google'
                                    )
                                )
                            )
                        )
                    )
                )
            ),
            'dashboardBoxes' => array(
                'googleanalytics' => array(
                    'order' => 2,
                    'plugin' => 'GoogleAnalyticsPlugin'
                )
            )
        ),
        'Grid\GoogleAnalytics' => array(
            'access' => array(
                'analyticsId' => ''
            )
        )
    ),
    'form' => array(
        'Grid\Core\Settings\Google' => array(
            'type' => 'Grid\Core\Form\Settings',
            'attributes' => array(
                'data-js-type' => 'js.form.fieldsetTabs',
                'bind-plugin-classes' => array(
                    'Grid\GoogleAnalytics\Form\Plugin\Bind'
                ),
                'set-data-plugin-classes' => array(
                    'Grid\GoogleAnalytics\Form\Plugin\SetData'
                )
            ),
            'fieldsets' => array(
                'analytics' => array(
                    'spec' => array(
                        'name' => 'analytics',
                        'options' => array(
                            'label' => 'googleAnalytics.form.settings.legend',
                            'description' => 'googleAnalytics.form.settings.description'
                        ),
                        'elements' => array(
                            'id' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Text',
                                    'name' => 'id',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.id'
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_trackingId'
                                    )
                                )
                            ),
                            'googleApiClientId' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Text',
                                    'name' => 'googleApiClientId',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.googleApi.clientId',
                                        'display_group' => 'googleAnalytics.form.displayGroup.googleApi'
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_googleApi_clientId'
                                    )
                                )
                            ),
                            'googleApiClientSecret' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Text',
                                    'name' => 'googleApiClientSecret',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.googleApi.clientSecret',
                                        'display_group' => 'googleAnalytics.form.displayGroup.googleApi',
                                        'description' => 'googleAnalytics.form.settings.googleApi.clientSecret.description'
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_googleApi_clientSecret'
                                    )
                                )
                            ),
                            'googleApiAccessToken' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Hidden',
                                    'name' => 'googleApiAccessToken',
                                    'options' => array(
                                        'display_group' => 'googleAnalytics.form.displayGroup.googleApi'
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_googleApi_accessToken'
                                    )
                                )
                            ),
                            'googleApiConnect' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Button',
                                    'name' => 'googleApiConnect',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.googleApi.connect',
                                        'display_group' => 'googleAnalytics.form.displayGroup.googleApi'
                                    ),
                                    'attributes' => array(
                                        'data-js-type' => 'js.form.element.googleAnalyticsApiConnectButton',
                                        'data-protocol' => ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ( isset( $_SERVER['SERVER_PORT'] ) && $_SERVER['SERVER_PORT'] == 443 ) ) ? "https://" : "http://",
                                        'data-http-host' => isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : ( isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : 'localhost' ),
                                        'id' => 'googleAnalytics_form_settings_googleApi_connect'
                                    )
                                )
                            ),
                            'dashboardChartEnabled' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Checkbox',
                                    'name' => 'dashboardChartEnabled',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.dashboardChart.enabled',
                                        'display_group' => 'googleAnalytics.form.displayGroup.chart'
                                    )
                                )
                            ),
                            'dashboardChartProfileId' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Select',
                                    'name' => 'dashboardChartProfileId',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.dashboardChart.profileId',
                                        'display_group' => 'googleAnalytics.form.displayGroup.chart',
                                        'value_options' => array()
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_dashboardChart_profileId'
                                    )
                                )
                            ),
                            'dashboardChartAvalilableProfiles' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Hidden',
                                    'name' => 'dashboardChartAvalilableProfiles',
                                    'options' => array(
                                        'display_group' => 'googleAnalytics.form.displayGroup.chart'
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_dashboardChart_avalilableProfiles'
                                    )
                                )
                            )
                        )
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'mvc_strategies' => array(
            'Grid\GoogleAnalytics\Mvc\Strategy\GoogleAnalyticsStrategy' // register JSON renderer strategy
                ),
        'template_map' => array(
            'grid/google-analytics/tracker' => __DIR__ . '/../view/grid/google-analytics/tracker.js',
            'grid/google-analytics/admin-dashboard-plugin/empty' => __DIR__ . '/../view/grid/google-analytics/admin-dashboard-plugin/empty.phtml',
            'grid/google-analytics/admin-dashboard-plugin/chart' => __DIR__ . '/../view/grid/google-analytics/admin-dashboard-plugin/chart.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);