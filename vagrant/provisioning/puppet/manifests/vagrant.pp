class { "wozbe::profile::common": }
class { "wozbe::profile::symfony2": 
    dist_conf => { 'date.timezone' => 'Europe/Paris' } 
}

class { '::mysql::server':
    root_password    => 'password01',
    override_options => { 'mysqld' => { 'max_connections' => '1024' } }
}