#!/usr/bin/env bash

Xvfb -fp /usr/share/fonts/X11/misc/ :22 -screen 0 1024x768x16 2>&1 &
export DISPLAY=:22

java -jar bin/selenium/selenium-server-standalone-2.48.2.jar -port 4444 -multiWindow -browserSessionReuse -timeout 30000 -forcedBrowserModeRestOfLine "*firefox /usr/lib/firefox/firefox" 2>&1 &
