# WP Browser / Codeception Test Database

For this plugin starter specifically, if the WordPress version is going to be upgraded and that version has database changes, you'll need to make a raw dump.sql, with a single admin user that matches the data in the [.env-dist file](../../.env-dist).

Additionally, you'll need to replace the URL's in the dump.sql with the package slug, so it's properly replaced when the plugin is initially configured:

search: `//square1` _(if the domain you used to create the dump is `http://square1test.tribe`)_.
replace: `//:package_slug`, _so it becomes `http://:package_slugtest.tribe`.
