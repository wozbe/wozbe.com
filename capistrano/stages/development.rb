set :stage, :development

set :ssh_user, 'thomas'
set :branch, 'development'
set :deploy_to, '/var/www/vhosts/com.wozbe.dev'

server 'arthos.armetiz.info', user: fetch(:ssh_user), roles: %w{web app db}
