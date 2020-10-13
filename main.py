from nowon import fetch

import json


search = "jane"
url = f"https://can.newonnetflix.info/catalogue/search/{search}#results"


result = fetch(url)
result = json.dumps(fetch(url), indent=4, sort_keys=True )
result = result.replace("\"{title", "{\"title" + "\"").replace("\""+ "}" + "\"", "\""+ "}").replace("\\", "")


ss = open('result.json','w')
ss.write(result)
ss.close()
