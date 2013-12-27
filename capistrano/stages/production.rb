set :stage, :production

set :ssh_user, 'nil'
set :branch, 'master'
set :deploy_to, '/var/www/vhosts/com.wozbe.www'

SSHKit.config.command_map[:composer] = "#{shared_path.join("composer.phar")}"

server 'arthos.armetiz.info', user: fetch(:ssh_user), roles: %w{web app db}
