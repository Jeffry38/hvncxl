rem start bk server - service stop and uninstall

net stop vncserver
taskkill /f /im server.exe
vncserver -uninstall

pause