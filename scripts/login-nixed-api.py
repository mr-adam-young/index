import requests
import json

from getpass import getpass

url = 'http://app.index.one/api/login'
myobj = {'email': input("Email: "), 'password': getpass("Password: ")}

x = requests.post(url, data = myobj)

response_data = json.loads(x.text)
result = response_data.get('success')

if result == True:
    token = response_data.get('token')

url2 = 'http://app.index.one/api/cost_centers'

headers = {'Authorization': 'Bearer ' + token}
response = requests.get(url2, headers=headers)

print(response.text)