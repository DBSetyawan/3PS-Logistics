@servers(['web' => 'daniel@127.0.0.1'])

@setup
	$timezone = 'Asia/Bangkok';

	$path = '/Users/macbook/Documents/3ps-dev';

	$repo = '';

	$branch = 'master';

	$keep = 6;

	$hasHtmlPurifier = true;

	$chmods = [
		'app/storage',
		'app/database/production.sqlite',
		'public',
	];

	$symlinks = [
		'storage/views'    => 'app/storage/views',
		'storage/sessions' => 'app/storage/sessions',
		'storage/logs'     => 'app/storage/logs',
		'storage/cache'    => 'app/storage/cache',
	];

	$date    = new DateTime('now', new DateTimeZone($timezone));
	$release = $path .'/releases/'. $date->format('YmdHis');
@endsetup

@task('clone', ['on' => $on])
	mkdir -p {{ $release }}

	git clone --depth 1 -b {{ $branch }} "{{ $repo }}" {{ $release }}

	echo "Repository has been cloned"
@endtask

@task('composer', ['on' => $on])
	composer self-update

	cd {{ $release }}

	composer install --no-interaction --no-dev --prefer-dist

	echo "Composer dependencies have been installed"
@endtask

{{-- Set permissions for various files and directories --}}
@task('chmod', ['on' => $on])
	@foreach($chmods as $file)
		chmod -R 755 {{ $release }}/{{ $file }}

		chmod -R g+s {{ $release }}/{{ $file }}

		chown -R www-data:www-data {{ $release }}/{{ $file }}

		echo "Permissions have been set for {{ $file }}"
	@endforeach

	@if($hasHtmlPurifier)
		chmod -R 777 {{ $release }}/vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
	@endif

	echo "Permissions for HTMLPurifier have been set"
@endtask

{{-- Symlink some folderss --}}
@task('symlinks', ['on' => $on])
	@foreach($symlinks as $folder => $symlink)
		ln -s {{ $path }}/shared/{{ $folder }} {{ $release }}/{{ $symlink }}

		echo "Symlink has been set for {{ $symlink }}"
	@endforeach

	echo "All symlinks have been set"
@endtask

{{-- Set the symlink for the current release --}}
@task('update-symlink', ['on' => $on])
	rm -rf {{ $path }}/current

	ln -s {{ $release }} {{ $path }}/current

	echo "Release symlink has been set"
@endtask

{{-- Migrate all databases --}}
@task('migrate', ['on' => $on])
	php {{ $release }}/artisan migrate
@endtask

{{-- Just a done message :) --}}
@task('done', ['on' => $on])
	echo "Deployment finished successfully!"
@endtask

{{-- Run all deployment tasks --}}
@macro('deploy')
	clone
	composer
	chmod
	migrate
	symlinks
	update-symlink
	done
@endmacro
