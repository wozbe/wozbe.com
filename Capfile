set :deploy_config_path, "capistrano/config.rb"
set :stage_config_path, "capistrano/stages/"
set :upload_files_path, "capistrano/files/"

# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'
require 'capistrano/composer'
require 'capistrano/npm'
require 'capistrano/bower'
require 'capistrano/grunt'
# ruire 'capistrano/symfony'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('capistrano/tasks/*.cap').each { |r| import r }

