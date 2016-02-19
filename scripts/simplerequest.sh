#!/bin/bash

# Your testing URL
TARGET="http://localhost/api/1.0"

# Your Bot's personal API key goes here
APIKEY="2Z1xF30H78lh0gm0O6CGeBxBF7V530Q3"

curl -XPOST -H 'Content-Type:application/json' -H 'Accept: application/json' -H "Prompt-API-key: ${APIKEY}" --data-binary @simplerequest.json ${TARGET}
