var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
	mix.styles([
					'bootstrap.min.css',
					'grayscale.css',
				], 'public/assets/css/web.min.css')
		.styles([
					'bootstrap.min.css',
					'admin.css'
				], 'public/assets/css/web_me.min.css')
		.scripts([
					'jquery.js',
					'bootstrap.min.js',
					'jquery.easing.min.js',
					'grayscale.js'
				], 'public/assets/js/web.min.js')
		.scripts([
					'jquery.js',
					'bootstrap.min.js',
					'jquery.easing.min.js',
				], 'public/assets/js/web_me.min.js')
		.version([
					'assets/css/web.min.css', 
					'assets/js/web.min.js',
					'assets/css/web_me.min.css', 
					'assets/js/web_me.min.js'
				])
		.copy('resources/font-awesome', 'public/assets/font-awesome/')
		.copy('resources/fonts', 'public/assets/fonts')
		.copy('resources/img', 'public/assets/img')
		.copy('resources/plugins', 'public/assets/plugins');
});
