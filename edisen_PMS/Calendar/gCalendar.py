from __future__ import print_function
import httplib2
import os

from apiclient import discovery
import oauth2client
from oauth2client import client
from oauth2client import tools

import datetime

try:
    import argparse
    flags = argparse.ArgumentParser(parents=[tools.argparser]).parse_args()
except ImportError:
    flags = None

# If modifying these scopes, delete your previously saved credentials
# at ~/.credentials/calendar-python-quickstart.json
SCOPES = 'https://www.googleapis.com/auth/calendar.readonly'
CLIENT_SECRET_FILE = 'client_secret.json'
APPLICATION_NAME = 'Google Calendar API Python Quickstart'


def get_credentials():
    """Gets valid user credentials from storage.

    If nothing has been stored, or if the stored credentials are invalid,
    the OAuth2 flow is completed to obtain the new credentials.

    Returns:
        Credentials, the obtained credential.
    """
    home_dir = os.path.expanduser('~')
    credential_dir = os.path.join(home_dir, '.credentials')
    if not os.path.exists(credential_dir):
        os.makedirs(credential_dir)
    credential_path = os.path.join(credential_dir,
                                   'calendar-python-quickstart.json')

    store = oauth2client.file.Storage(credential_path)
    credentials = store.get()
    if not credentials or credentials.invalid:
        flow = client.flow_from_clientsecrets(CLIENT_SECRET_FILE, SCOPES)
        flow.user_agent = APPLICATION_NAME
        if flags:
            credentials = tools.run_flow(flow, store, flags)
        else: # Needed only for compatibility with Python 2.6
            credentials = tools.run(flow, store)
        print('Storing credentials to ' + credential_path)
    return credentials

def get_events(day = 'tomorrow'):
    """Shows basic usage of the Google Calendar API.

    Creates a Google Calendar API service object and outputs a list of the next
    10 events on the user's calendar.
    """
    credentials = get_credentials()
    http = credentials.authorize(httplib2.Http())
    service = discovery.build('calendar', 'v3', http=http)

    UTC_OFFSET_TIMEDELTA = datetime.datetime.utcnow() - datetime.datetime.now()

    date = datetime.datetime.utcnow()#.isoformat() + 'Z' # 'Z' indicates UTC time
    if day == 'tomorrow':
        date += datetime.timedelta(days=1)

    start_date = datetime.datetime(date.year, date.month, date.day) + UTC_OFFSET_TIMEDELTA + datetime.timedelta(0,1)
    end_date = start_date + datetime.timedelta(days=1) - datetime.timedelta(0,1)
    start_date = start_date.isoformat() + 'Z'
    end_date = end_date.isoformat() + 'Z'
    #print(start_date, end_date)

    #print('Getting the upcoming events for the day')
    eventsResult = service.events().list(
        calendarId='primary', timeMin=start_date, timeMax=end_date, singleEvents=True,
        orderBy='startTime').execute()
    events = eventsResult.get('items', [])

    schedule_dict = {}
    for event in events:
        event_dict = {}

        time = event['start'].get('dateTime')[11:19]
        event_dict['time'] = time

        if 'summary' in event.keys():
            event_dict['summary'] = event['summary']

        if 'location' in event.keys():
            event_dict['location'] = event['location']

        schedule_dict[time] = event_dict

    return schedule_dict


def main():
    get_events()

if __name__ == '__main__':
    main()