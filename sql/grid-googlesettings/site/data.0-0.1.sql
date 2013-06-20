-- insert default values for table: user_right

INSERT INTO "user_right" ( "label", "group", "resource", "privilege", "optional", "module" )
     VALUES ( NULL, 'settings', 'settings.google', 'edit', TRUE, 'Grid\GoogleAnalytics|Grid\GoogleMap|Grid\GoogleSiteVerification' );
