<?php

class port2_http_alt_plugin
{

    var $plugin_name = 'port2_http_alt_plugin';
    var $class_name = 'port2_http_alt_plugin';

    var $site_enable = '/etc/apache2/sites-enabled';

    function onLoad()
    {
        global $app;
        //Register for the events

        $app->plugins->registerEvent('web_domain_insert', $this->plugin_name, 'insert');
        $app->plugins->registerEvent('web_domain_update', $this->plugin_name, 'update');



    }


    function insert($event_name, $data)
    {
        global $app, $conf;

        $app->log($event_name, LOGLEVEL_DEBUG);
        $this->changePort($app, $event_name, $data, $conf);

    }

    function update($event_name, $data)
    {
        global $app, $conf;

        $this->changePort($app, $event_name, $data, $conf);

    }

    function changePort($app, $event_name, $data, $conf)
    {
        $app->log("Mise à jour des vhost port", LOGLEVEL_DEBUG);

        //$web = $app->db->queryOneRecord("SELECT * FROM web_domain WHERE domain_id = ?", $data['new']['parent_domain_id']);

        if(!isset($data['new']) || !isset($data['new']['domain'])){
            $app->log("Domain not found", LOGLEVEL_DEBUG);

            return;
        }
        $vhostFile = glob("{$this->site_enable}/*{$data['new']['domain']}*");
        if(!$vhostFile){
            $app->log("vhost file not fount", LOGLEVEL_DEBUG);

            return;
        }
        foreach ($vhostFile as $vhost){
            $content = file_get_contents($vhost);
            $content = str_replace(':80>',':8080>', $content);
            file_put_contents($vhost, $content);
        }
        $app->services->restartService('httpd', 'restart');

    }


}
