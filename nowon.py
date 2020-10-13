from urllib.request import Request, urlopen
from bs4 import BeautifulSoup

import re

def fetch(url):
  req=Request(url, headers={'User-Agent': 'Misc Robot'})
  html_week = urlopen(req).read()
  soup = BeautifulSoup(html_week, 'html.parser')

  result = soup.find("div", {"class":"wrapper"}).find_all('section')[3].find_all("img")
  
  #return result
  titles = []
  for title in result:
    if title.has_attr('alt'):
      a = title['alt']
      if title.has_attr('src'):
        b = title['src']
        if re.findall("https",b):
          titles.append("{title" + ":" + "\"" + a + "\"" + "," "\"" + "poster" + "\"" + ":" + "\"" + title['src'] + "\"" + "}")

  return titles      
