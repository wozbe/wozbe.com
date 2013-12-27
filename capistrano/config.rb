set :application, 'wozbe'
set :repo_url, 'git@github.com:wozbe/wozbe.com.git'

set :scm, :git

set :format, :pretty
set :log_level, :info
# set :log_level, :debug

set :composer_install_flags, '--no-dev --prefer-dist --no-interaction --optimize-autoloader'

set :linked_files, %w{app/config/parameters.yml}
set :linked_dirs, %w{app/logs web/uploads}

set :keep_releases, 3

set :grunt_tasks, 'deploy'
set :bower_flags, '--quiet --allow-root'

after 'deploy:updated', 'bower:install'
after 'deploy:updated', 'wozbe:robots'
after 'deploy:updated', 'wozbe:install'
after 'deploy:updated', 'grunt'
after 'deploy:finishing', 'deploy:cleanup'
after 'deploy:finishing', 'cache:pagespeed:flush'
after 'deploy:finishing', 'cache:varnish:restart'