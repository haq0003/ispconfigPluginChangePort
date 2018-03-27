# ispconfigPluginChangePort
change generated virtualhost port

1°/ add file in 
/usr/local/ispconfig/server/plugins-available/

2°/ create symlink
cd /usr/local/ispconfig/server/plugins-enabled
ln -s /usr/local/ispconfig/server/plugins-available/port2_http_alt_plugin.inc.php

3°/ update conf website in ispconfig by adding space in apache conf 
for trigger website update
