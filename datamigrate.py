import json
import pandas as pd

FILE = 'New_Request-1701054082689.json'

with open(FILE) as f:
    data = json.load(f)

df = pd.json_normalize(data['data'])

uniques = {
    'kategori': df['kategori'].unique(),
    'status': df['status'].unique()
}

print(uniques)

#replace kategori and status with index+1
df['kategori'] = df['kategori'].apply(lambda x: uniques['kategori'].tolist().index(x)+1)
df['status'] = df['status'].apply(lambda x: uniques['status'].tolist().index(x)+1)

#drop no and id_produck rename nama_produk to nama
df = df.drop(columns=['no'])
df = df.drop(columns=['id_produk'])
df = df.rename(columns={'nama_produk': 'nama'})
df = df.rename(columns={'kategori': 'kategori_id'})
df = df.rename(columns={'status': 'status_id'})

#insert to database
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from sqlalchemy import text


engine = create_engine('mysql+pymysql://root@localhost:3306/fastprint_ci3')

Session = sessionmaker(bind=engine)
session = Session()

session.execute(text('''SET FOREIGN_KEY_CHECKS = 0'''))
session.execute(text('''TRUNCATE TABLE produk'''))
session.execute(text('''TRUNCATE TABLE kategori'''))
session.execute(text('''TRUNCATE TABLE status'''))
session.execute(text('''SET FOREIGN_KEY_CHECKS = 1'''))

#add uniques first then add df
uniques['kategori'] = pd.DataFrame(uniques['kategori'], columns=['nama'])
uniques['status'] = pd.DataFrame(uniques['status'], columns=['nama'])

with engine.connect() as con:
    uniques['kategori'].to_sql('kategori', con=con, if_exists='append', index=False)
    uniques['status'].to_sql('status', con=con, if_exists='append', index=False)
    df.to_sql('produk', con=con, if_exists='append', index=False)