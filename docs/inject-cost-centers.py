# pip install mysql-connector-python
# https://realpython.com/python-mysql/

import pandas as pd
from getpass import getpass
from mysql.connector import connect, Error

try:
    with connect(
        host="localhost",
        user=input("Enter MySQL username: "),
        password=getpass("Enter MySQL password: "),
        database="emeraude",
    ) as connection:
        df = pd.read_csv('data/cost_centers.csv', keep_default_na=False, na_values=None)
        for index, row in df.iterrows():
            query = """INSERT INTO cost_centers (id, long_name, short_name, description) VALUES (%s, %s, %s, %s);"""
            values = (row['id'], row['long_name'], row['short_name'], row['description'])
            print(query)
            print(values)
            cursor = connection.cursor(prepared=True)
            cursor.execute(query, values)
            connection.commit()
except Error as e:
    print(e)

