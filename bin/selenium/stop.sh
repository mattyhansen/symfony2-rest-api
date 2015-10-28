#!/usr/bin/env bash
# stop selenium server on port 4444
kill -9 `ps -eo pid,args | grep "selenium.*-port 4444" | grep -v grep| awk '{ print $1 }'`

# Stop Xvfb on display 22
kill -9 `ps -eo pid,args  | grep "Xvfb.*:22" | grep -v grep| awk '{ print $1 }'`
