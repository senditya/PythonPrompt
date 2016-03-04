from flask import Flask, url_for, Response
import flask
import json
import requests
app = Flask(__name__)

resp={"ok":"okk"}
@app.route('/code', methods=['POST', 'GET'])
def api_root():
    print flask.request, type(flask.request)
    return json.dumps(resp)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=2564)