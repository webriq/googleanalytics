<?php
return array(
    'router' => array(
        'routes' => array(
            'Grid\GoogleAnalytics\Admin\Api\Connect' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/app/:locale/admin/googleanalytics/api/connect',
                    'constraints' => array(
                        'locale' => '\w+'
                    ),
                    'defaults' => array(
                        'controller' => 'Grid\GoogleAnalytics\Controller\GoogleApi',
                        'action' => 'connect'
                    )
                )
            ),
            'Grid\GoogleAnalytics\Admin\Api\Callback' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/app/admin/googleanalytics/api/callback',
                    'defaults' => array(
                        'controller' => 'Grid\GoogleAnalytics\Controller\GoogleApi',
                        'action' => 'callback'
                    )
                )
            ),
            'Grid\GoogleAnalytics\Admin\Api\Refresh' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/app/:locale/admin/googleanalytics/api/refresh',
                    'constraints' => array(
                        'locale' => '\w+'
                    ),
                    'defaults' => array(
                        'controller' => 'Grid\GoogleAnalytics\Controller\GoogleApi',
                        'action' => 'refresh'
                    )
                )
            ),
            'Grid\GoogleAnalytics\Admin\Api\Callback\Chart' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/app/admin/googleanalytics/api/callback/chart',
                    'defaults' => array(
                        'controller' => 'Grid\GoogleAnalytics\Controller\GoogleApiChart',
                        'action' => 'callback'
                    )
                )
            ),
            
            'Grid\GoogleAnalytics\Admin\Api\Refresh\Chart' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/app/:locale/admin/googleanalytics/api/refresh',
                    'constraints' => array(
                        'locale' => '\w+'
                    ),
                    'defaults' => array(
                        'controller' => 'Grid\GoogleAnalytics\Controller\GoogleApiChart',
                        'action' => 'refresh'
                    )
                )
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Grid\GoogleAnalytics\Controller\GoogleApi' => 'Grid\GoogleAnalytics\Controller\GoogleApiController',
            'Grid\GoogleAnalytics\Controller\GoogleApiChart' => 'Grid\GoogleAnalytics\Controller\GoogleApiChartController'
        )
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'GoogleAnalyticsPlugin' => 'Grid\GoogleAnalytics\Controller\Plugin\DashboardAnalyticsPlugin',
        ),
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
            'dashboardBoxes' => array(
                'googleanalytics' => array(
                    'order'         => 2,
                    'plugin'        => 'GoogleAnalyticsPlugin',
                ),
            ),
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
                        'clientId' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.googleApi.clientId',
                            'type' => 'ini'
                        ),
                        'clientSecret' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.googleApi.clientSecret',
                            'type' => 'ini'
                        ),
                        'dashboardDiagramEnabled' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.dashboardDiagram.enabled',
                            'type' => 'ini'
                        ),
                        'dashboardDiagramReport' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.dashboardDiagram.report',
                            'type' => 'ini'
                        ),
                        'reports' => array(
                            'key' => 'modules.Grid\GoogleAnalytics.reports',
                            'type' => 'ini'
                        ),
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
                                        'id' => 'googleAnalytics_form_settings_analyticsId',
                                    )
                                )
                            ),
                            'clientId' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Text',
                                    'name' => 'clientId',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.googleApi.clientId',
                                        'display_group' => 'googleAnalytics.form.displayGroup.googleApi'
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_googleApi_clientId',
                                    )
                                )
                            ),
                            'clientSecret' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Text',
                                    'name' => 'clientSecret',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.googleApi.clientSecret',
                                        'display_group' => 'googleAnalytics.form.displayGroup.googleApi',
                                        'description' => 'googleAnalytics.form.settings.googleApi.clientSecret.description'
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_googleApi_clientSecret',
                                    )
                                )
                            ),
                            'connect' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Button',
                                    'name' => 'connect',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.googleApi.connect',
                                        'display_group' => 'googleAnalytics.form.displayGroup.googleApi'
                                    ),
                                    'attributes' => array(
                                        'data-js-type' => 'js.form.element.googleAnalyticsApiConnectButton',
                                        'data-protocol' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://",
                                        'data-http-host' => $_SERVER['HTTP_HOST'],
                                        'id' => 'googleAnalytics_form_settings_googleApi_connect',
                                    )
                                )
                            ),
                            'dashboardDiagramEnabled' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Checkbox',
                                    'name' => 'dashboardDiagramEnabled',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.dashboardDiagram.enabled',
                                        'display_group' => 'googleAnalytics.form.displayGroup.diagram'
                                    )
                                )
                            ),
                            'dashboardDiagramReport' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Select',
                                    'name' => 'dashboardDiagramReport',
                                    'options' => array(
                                        'label' => 'googleAnalytics.form.settings.dashboardDiagram.report',
                                        'display_group' => 'googleAnalytics.form.displayGroup.diagram',
                                        'value_options' => array()
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_dashboardDiagram_report',
                                    )
                                )
                            ),
                            'reports' => array(
                                'spec' => array(
                                    'type' => 'Zork\Form\Element\Hidden',
                                    'name' => 'reports',
                                    'options' => array(
                                        'display_group' => 'googleAnalytics.form.displayGroup.diagram',
                                    ),
                                    'attributes' => array(
                                        'id' => 'googleAnalytics_form_settings_reports',
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
            'grid/google-analytics/dashboard' => __DIR__ . '/../view/grid/google-analytics/dashboard.phtml',
            'grid/google-analytics/dashboard-empty' => __DIR__ . '/../view/grid/google-analytics/dashboard-empty.phtml',
            'grid/google-analytics/dashboard-auth' => __DIR__ . '/../view/grid/google-analytics/dashboard-auth.phtml',
        ),
        'template_path_stack'       => array(
            __DIR__ . '/../view',
        ),
    )
);





