from nowon import fetch

import json
import sys

search = sys.argv[1]
url = f"https://can.newonnetflix.info/catalogue/search/{search}#results"


result = fetch(url)
result = json.dumps(fetch(url), indent=4, sort_keys=True )
result = result.replace("\"{title", "{\"title" + "\"").replace("\""+ "}" + "\"", "\""+ "}").replace("\\", "")
result = result

py_result = open('py_result2.json','w')
py_result.write(result)
py_result.close()

print (json.dumps(result))
