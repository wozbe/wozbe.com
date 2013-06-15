set :application, "wozbe"
set :host,        "arthos.armetiz.info"
set :deploy_to,   "/var/www/vhosts/com.wozbe.www"
set :app_path,    "app"
set :user,        "root"

set :repository,  "git@github.com:wozbe/wozbe.com.git"
set :scm,         :git
set :model_manager, "doctrine"

set :shared_files,  ["app/config/parameters.yml"]
set :clear_controllers, false
set :writable_dirs, ["app/cache", "app/logs"]
set :webserver_user, "apache"
set :permission_method, :acl
set :use_composer, true
set :use_set_permissions, true
set :use_sudo, false

set :dump_assetic_assets, true
set :composer_options,  "--no-dev --verbose --prefer-dist --optimize-autoloader"

role :web,        host                         # Your HTTP server, Apache/etc
role :app,        host, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

namespace :assets do
  desc "Install node modules non-globally"
  task :npm_install do
    capifony_pretty_print '--> Installing NodeJS dependencies'

    # Hope to be able to remove the pipe to /dev/null
    run "cd #{latest_release} && npm install 2> /dev/null"

    capifony_puts_ok
  end

  desc "Bower Install"
  task :bower_install do
    capifony_pretty_print '--> Installing Bower dependencies'

    # Hope to be able to remove the pipe to /dev/null
    run "cd #{latest_release} && bower install 2> /dev/null"

    capifony_puts_ok
  end

  desc "Grunt Symlink"
  task :grunt_symlink do
    capifony_pretty_print '--> Installing symlink using grunt'

    run "cd #{latest_release} && grunt symlink"

    capifony_puts_ok
  end

  desc "Grunt"
  task :grunt do
    capifony_pretty_print '--> Installing Assets using grunt'

    run "cd #{latest_release} && grunt"

    capifony_puts_ok
  end
end

namespace :cache do
  desc "Flush the mod_pagespeed cache"
  task :pagespeed_flush do
    capifony_pretty_print '--> Clear mod_pagespeed cache'

    run "touch /var/cache/mod_pagespeed/cache.flush"

    capifony_puts_ok
  end
end

namespace :varnish do
  desc "Varnish restart"
  task :restart do
    capifony_pretty_print '--> Restart Varnish'

    run "service varnish restart"

    capifony_puts_ok
  end
end

after "deploy", "deploy:cleanup", "cache:pagespeed_flush", "varnish:restart"
after "deploy:update_code", "assets:bower_install", "assets:npm_install", "assets:grunt_symlink", "assets:grunt"

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL