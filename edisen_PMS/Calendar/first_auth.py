#!/usr/bin/env python

# modified from:
# https://developers.google.com/api-client-library/python/samples/authorized_api_cmd_line_calendar.py

from apiclient.discovery import build
from oauth2client.file import Storage
from oauth2client.client import AccessTokenRefreshError
from oauth2client.client import OAuth2WebServerFlow
from oauth2client.tools import run_flow
from oauth2client.client import flow_from_clientsecrets


def getAuth(clientID = 'client0'):

    scope = 'https://www.googleapis.com/auth/calendar'
    flow = flow_from_clientsecrets('client_secret.json', scope=scope,  redirect_uri='http://prompthelloworld.herokuapp.com')

    storage = Storage('../credentials/'+clientID+'.json')
    credentials = storage.get()

    class fakeargparse(object):  # fake argparse.Namespace
        noauth_local_webserver = False
        logging_level = "ERROR"
        auth_host_name='http://prompthelloworld.herokuapp.com'
        auth_host_port=[8080, 80, 8010, 8000]
    flags = fakeargparse()
    print flags

    print 'Begin flow'
    if credentials is None or credentials.invalid:
        credentials = run_flow(flow, storage, flags)

def main():
    getAuth()

if __name__ == '__main__':
    main()
