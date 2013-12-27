set :stage, :production

set :ssh_user, 'thomas'
set :branch, 'master'
set :deploy_to, '/var/www/vhosts/com.wozbe.www'

server 'arthos.armetiz.info', user: fetch(:ssh_user), roles: %w{web app db}
